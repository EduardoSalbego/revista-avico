<?php

namespace App\Http\Controllers\Autor;

use App\Http\Controllers\Controller;
use App\Models\Submissao;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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
            'coautores' => 'nullable|array',
            'coautores.*' => 'nullable|string|max:255',

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
        ]);

        DB::table('submissao_autor')->insert([
            'submissao_id' => $submissao->id,
            'nome' => $request->autor_principal,
            'autor_principal' => true,
            'ordem' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if ($request->has('coautores') && is_array($request->coautores)) {
            $ordem = 2;
            $coautoresData = [];

            foreach ($request->coautores as $coautorNome) {
                if (!empty(trim($coautorNome))) {
                    $coautoresData[] = [
                        'submissao_id' => $submissao->id,
                        'nome' => trim($coautorNome),
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

        return redirect()->route('autor.submissoes.index')
            ->with('success', 'Artigo submetido com sucesso! Acompanhe o status aqui.');
    }

    // Upload do DOCX final (só disponível quando status = aceito)
    public function enviarDocx(Request $request, $id)
    {
        $submissao = Submissao::where('user_id', Auth::id())->findOrFail($id);

        if (!$submissao->isAceito()) {
            return back()->withErrors(['arquivo_docx' => 'Esta submissão não está apta para envio de versão final.']);
        }

        $request->validate([
            'arquivo_docx' => 'required|file|mimes:docx,doc|max:20480',
        ]);

        $caminhoDocx = $request->file('arquivo_docx')
            ->store('submissoes/docx', 'public');

        $submissao->update(['arquivo_docx' => $caminhoDocx]);

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
