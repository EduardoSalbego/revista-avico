<?php

namespace App\Http\Controllers\Autor;

use App\Http\Controllers\Controller;
use App\Models\Artigo;
use App\Models\Autor;
use App\Models\Submissao;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use App\Mail\NovaSubmissaoAutorMail;

class SubmissaoController extends Controller
{
    // Lista as submissões do autor logado
    public function index()
    {
        $submissoes = Submissao::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('autor.submissoes.index', compact('submissoes'));
    }

    public function create()
    {
        return view('autor.submissoes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'resumo' => 'required|string',
            'cover_letter' => 'required|string',
            'arquivo_pdf' => 'required|file|mimes:pdf|max:20480', // 20MB

            'autor_principal' => 'required|string|max:255',
            'instituicao_principal' => 'required|string|max:255',

            // Dados dos Coautores
            'coautores_nomes' => 'nullable|array',
            'coautores_nomes.*' => 'nullable|string|max:255',
            'coautores_instituicoes' => 'nullable|array',
            'coautores_instituicoes.*' => 'nullable|string|max:255',

            'revisores_sugeridos' => 'nullable|array|max:4',
            'revisores_sugeridos.*.revisor_id' => [
                'nullable',
                'integer',
                Rule::exists('revisores', 'id')
                    ->where(function ($query) {
                        $query->where('status', 'ativo');
                    }),
            ],
            'revisores_sugeridos.*.nome' => [
                'required',
                'string',
                'max:255',
            ],
            'revisores_sugeridos.*.email' => [
                'nullable',
                'email',
                'max:255',
            ],
        ]);

        $caminhoPdf = $request->file('arquivo_pdf')
            ->store('submissoes/pdf', 'public');

        $submissao = Submissao::create([
            'user_id' => Auth::id(),
            'titulo' => $request->titulo,
            'resumo' => $request->resumo,
            'cover_letter' => $request->cover_letter,
            'arquivo_pdf' => $caminhoPdf,
            'status' => 'submetido',
            'deadline' => now()->addDays(60),
        ]);

        DB::table('submissao_autor')->insert([
            'submissao_id' => $submissao->id,
            'nome' => $request->autor_principal,
            'instituicao' => $request->instituicao_principal,
            'autor_principal' => true,
            'ordem' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if ($request->has('coautores_nomes') && is_array($request->coautores_nomes)) {
            $ordem = 2;
            $coautoresData = [];

            foreach ($request->coautores_nomes as $index => $coautorNome) {
                if (!empty(trim($coautorNome))) {
                    $instituicaoCoautor = isset($request->coautores_instituicoes[$index])
                        ? trim($request->coautores_instituicoes[$index])
                        : null;
                    $coautoresData[] = [
                        'submissao_id' => $submissao->id,
                        'nome' => trim($coautorNome),
                        'instituicao' => $instituicaoCoautor,
                        'autor_principal' => false,
                        'ordem' => $ordem++,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            if (!empty($coautoresData)) {
                DB::table('submissao_autor')->insert($coautoresData);
            }
        }

        foreach ($request['revisores_sugeridos'] ?? [] as $revisor) {
            $submissao->revisoresSugeridos()->create([
                // REVISOR INTERNO
                'revisor_id' => $revisor['revisor_id'] ?? null,

                // REVISOR EXTERNO
                'nome' => empty($revisor['revisor_id'])
                    ? $revisor['nome']
                    : null,
                'email' => empty($revisor['revisor_id'])
                    ? $revisor['email']
                    : null,
            ]);
        }

        Mail::to($submissao->user->email)->send(new NovaSubmissaoAutorMail($submissao));
        return redirect()->route('autor.submissoes.index')
            ->with('success', 'Artigo submetido com sucesso! Acompanhe o status aqui.');
    }

    // Upload do PDF final
    public function enviarPublicacao(Request $request, $id)
    {
        $submissao = Submissao::where('id', $id)->first();

        if ($submissao->artigoEnviado()) {
            return back()->withErrors(['arquivo_pdf' => 'Esta submissão não está apta para envio de versão final.']);
        }

        $request->validate([
            'arquivo_pdf' => 'required|file|mimes:pdf|max:20480',
            'doi' => ['nullable', 'string', 'max:255'],
            'palavras_chave' => ['required', 'array', 'size:5'],
            'palavras_chave.*' => ['required', 'string', 'max:100'],
            'referencias' => ['required', 'array', 'min:1'],
            'referencias.*' => ['required', 'string', 'max:1000'],

        ]);

        $caminhoPdf = $request->file('arquivo_pdf')
            ->store('submissoes/pdf', 'public');

        $autor = Autor::firstOrCreate(['user_id' => $submissao->user_id]);
        Artigo::create([
            'edicao_id' => null,
            'submissao_id' => $id,
            'titulo' => $submissao->titulo,
            'autor_id' => $autor->id,
            'resumo' => $submissao->resumo,
            'arquivo_pdf' => $caminhoPdf,
            'doi' => $request['doi'] ?? null,
            'palavras_chave' => $request['palavras_chave'],
            'referencias' => array_values(
                array_filter(
                    $request['referencias'],
                    fn($r) => strlen(trim($r)) > 0
                )
            ),


        ]);

        return back()->with('success', 'Versão final enviada! O editor irá incorporá-la na próxima edição.');
    }

    public function resubmeter(Request $request, $id)
    {
        $submissao = Submissao::where('user_id', Auth::id())->findOrFail($id);

        if ($submissao->status !== 'major_review') {
            return back()->with('error', 'Esta submissão não está aguardando resubmissão.');
        }

        $request->validate([
            'arquivo_pdf_revisado' => 'required|file|mimes:pdf|max:20480',
        ]);

        $caminho = $request->file('arquivo_pdf_revisado')
            ->store('submissoes/pdf_revisado', 'public');

        $submissao->update([
            'arquivo_pdf_revisado' => $caminho,
            'status' => 'em_revisao',
        ]);

        // Zera os pareceres anteriores para os revisores emitirem novamente
        $submissao->pareceres()->update([
            'decisao' => null,
            'comentario' => null,
        ]);

        return back()->with('success', 'PDF revisado enviado! Os revisores foram notificados.');
    }

}
