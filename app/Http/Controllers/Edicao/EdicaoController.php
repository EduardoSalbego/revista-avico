<?php

namespace App\Http\Controllers\Edicao;

use App\Models\Edicao;
use App\Models\Comentario;
use App\Models\Capitulo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class EdicaoController extends Controller
{
    /*
     * Função para listar as edições
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Edicao::query()->where('status', 'publicado');

        if ($request->has('busca') && $request->busca != '') {
            $query->where('titulo', 'like', '%' . $request->busca . '%');
        }

        $edicoes = $query->orderBy('created_at', 'desc')->paginate(9);

        return view('revista.edicoes', compact('edicoes'));
    }

    /*
     * Função para mostrar uma edição específica
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $edicao = Edicao::findOrFail($id);
        $comentarios = Comentario::with('user')
            ->where('edicao_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('revista.show', compact('edicao', 'comentarios'));
    }

    /*
     * Função para criar uma nova edição
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $proximaEdicao = Edicao::count() + 1;
        return view('revista.create', compact('proximaEdicao'));
    }

    /*
     * Função para salvar uma nova edição
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        $rules = [
            'titulo' => 'required|string|max:255',
            'autor' => 'required|string|max:255',
            'imagem_capa' => 'required|image|max:5120',
            'status' => 'required|in:rascunho,publicado',
            'capitulos' => 'required|array|min:1',
            'capitulos.*.titulo' => 'required|string|max:255',
            'capitulos.*.conteudo_html' => 'nullable|string',
            'capitulos.*.ordem' => 'nullable|integer',
        ];
        $request->validate($rules);

        $arquivo = $request->file('imagem_capa');
        $nomeArquivo = time() . '_' . $arquivo->getClientOriginalName();
        $arquivo->move(public_path('capas'), $nomeArquivo);
        $caminhoCapa = 'capas/' . $nomeArquivo;

        $edicao = new Edicao();
        $edicao->titulo = $request->titulo;
        $edicao->autor = $request->autor;
        $edicao->imagem_capa = $caminhoCapa;
        $edicao->status = $request->status;
        $edicao->save();

        // Cria os capítulos
        if ($request->filled('capitulos')) {
            foreach ($request->capitulos as $dadosCapitulo) {

                $edicao->capitulos()->create([
                    'titulo' => $dadosCapitulo['titulo'] ?? 'Sem título',
                    'conteudo_html' => $dadosCapitulo['conteudo_html'],
                    'ordem' => $dadosCapitulo['ordem'] ?? 0,
                ]);
            }
        }

        $mensagem = $request->status === 'rascunho'
            ? 'Rascunho salvo com sucesso!'
            : 'Edição publicada com sucesso!';

        return redirect()->route('edicoes.index')->with('success', $mensagem);
    }

    // Lista todas as edições no formato de tabela para o admin
    public function indexAdmin()
    {
        $edicoes = Edicao::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.edicoes.index', compact('edicoes'));
    }

    // Deleta uma edição do banco de dados
    public function destroy($id)
    {
        $edicao = Edicao::findOrFail($id);

        $edicao->delete();

        return redirect()->route('admin.edicoes.index')->with('success', 'Edição excluída com sucesso!');
    }

    // Mostra a tela de edição
    public function edit($id)
    {
        $edicao = Edicao::findOrFail($id);
        return view('admin.edicoes.edit', compact('edicao'));
    }

    // Salva as atualizações no banco
    public function update(Request $request, $id)
    {
        $edicao = Edicao::findOrFail($id);

        $request->validate([
            'titulo' => 'required|string|max:255',
            'autor' => 'required|string|max:255',
            'imagem_capa' => 'nullable|image|max:5120',
            'status' => 'required|in:rascunho,publicado',
            'capitulos' => 'nullable|array',
            'capitulos.*.id' => 'nullable|integer|exists:capitulos,id',
            'capitulos.*.titulo' => 'nullable|string|max:255',
            'capitulos.*.conteudo_html' => 'nullable|string',
            'capitulos.*.ordem' => 'nullable|integer',
        ]);

        // Atualiza imagem de capa se enviada
        $dados = [
            'titulo' => $request->titulo ?? $edicao->titulo,
            'autor' => $request->autor ?? $edicao->autor,
            'status' => $request->status,
        ];

        if ($request->hasFile('imagem_capa')) {
            // Remove a capa antiga se existir
            if ($edicao->imagem_capa) {
                Storage::disk('public')->delete($edicao->imagem_capa);
            }
            $dados['imagem_capa'] = $request->file('imagem_capa')->store('capas', 'public');
        }

        $edicao->update($dados);

        // Atualiza capítulos
        if ($request->filled('capitulos')) {

            // IDs dos capítulos recebidos no form (para detectar os excluídos)
            $idsRecebidos = collect($request->capitulos)
                ->pluck('id')
                ->filter()
                ->map(fn($id) => (int) $id)
                ->toArray();

            // Remove capítulos que foram excluídos na tela
            if (!empty($idsRecebidos)) {
                $edicao->capitulos()
                    ->whereNotIn('id', $idsRecebidos)
                    ->delete();
            }
            foreach ($request->capitulos as $capituloData) {

                $payload = [
                    'titulo' => $capituloData['titulo'] ?? 'Sem título',
                    'conteudo_html' => $capituloData['conteudo_html'],
                    'ordem' => $capituloData['ordem'] ?? 0,
                    'edicao_id' => $edicao->id,
                ];

                if (!empty($capituloData['id'])) {
                    Capitulo::where('id', $capituloData['id'])
                        ->where('edicao_id', $edicao->id)
                        ->update($payload);
                } else {
                    $edicao->capitulos()->create(array_merge($payload, [
                        'edicao_id' => $edicao->id
                    ]));
                }
            }
        }

        $mensagem = $request->status === 'rascunho'
            ? 'Rascunho salvo com sucesso!'
            : 'Edição atualizada e publicada!';

        return redirect()->route('admin.edicoes.index')->with('success', $mensagem);
    }

}
