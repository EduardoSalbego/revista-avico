<?php

namespace App\Http\Controllers\Edicao;

use App\Models\Edicao;
use App\Models\Comentario;
use App\Models\Capitulo;
use App\Models\Artigo;
use App\Models\Autor;
use App\Models\Submissao;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;


class EdicaoController extends Controller
{
    /*
     * Função para listar as edições
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Edicao::query()->where('status', 'publicado')->orderBy('data_publicacao', 'desc');

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
        $artigos = Artigo::where('edicao_id', $id)->orderBy('ordem')->get();
        return view('revista.show', compact('edicao', 'comentarios', 'artigos'));
    }

    /*
     * Função para criar uma nova edição
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $proximaEdicao = Edicao::count() + 1;
        $artigos = Artigo::whereNull('edicao_id')->orderBy('created_at', 'desc')->get();
        return view('revista.create', compact('proximaEdicao', 'artigos'));
    }

    /*
     * Função para salvar uma nova edição
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'organizador' => 'required|string|max:255',
            'resumo' => 'required|string',
            'imagem_capa' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'tipo_acesso' => 'required|in:publica,exclusiva',
            'status' => 'required|in:rascunho,publicado',
            'artigos' => 'required|array|min:1',
        ]);

        try {
            DB::beginTransaction();

            $arquivo = $request->file('imagem_capa');
            $nomeArquivo = time() . '_' . $arquivo->getClientOriginalName();
            $arquivo->move(public_path('capas'), $nomeArquivo);
            $caminhoCapa = 'capas/' . $nomeArquivo;

            $edicao = Edicao::create([
                'titulo' => $request->titulo,
                'organizador' => $request->organizador,
                'resumo' => $request->resumo,
                'imagem_capa' => $caminhoCapa,
                'tipo_acesso' => $request->tipo_acesso,
                'permitir_comentarios' => $request->boolean('permitir_comentarios'),
                'status' => $request->status,
                'data_publicacao' => $request->status === 'publicado' ? now() : null,
            ]);

            foreach ($request->artigos as $dadosArtigo) {
                $artigo = Artigo::findOrFail($dadosArtigo['artigo_id']);

                $artigo->update([
                    'edicao_id' => $edicao->id,
                    'ordem' => $dadosArtigo['ordem'],
                ]);
            }

        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Ocorreu um erro ao salvar a edição: ' . $e->getMessage());
        }

        DB::commit();

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
        $artigosEdicao = Artigo::where('edicao_id', $id)->orderBy('ordem')->get();
        $artigosDisponiveis = Artigo::whereNull('edicao_id')->orderBy('created_at', 'desc')->get();
        return view('admin.edicoes.edit', compact('edicao', 'artigosEdicao', 'artigosDisponiveis'));
    }

    // Salva as atualizações no banco
    public function update(Request $request, $id)
    {
        $edicao = Edicao::findOrFail($id);

        // 1. Validações Corrigidas
        $request->validate([
            'titulo' => 'required|string|max:255',
            'organizador' => 'required|string|max:255', // Recebe do formulário
            'resumo' => 'required|string',
            'imagem_capa' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'tipo_acesso' => 'required|in:publica,exclusiva',
            'status' => 'required|in:rascunho,publicado',
            'artigos_ids' => 'nullable|array',
            'artigos_ids.*' => 'exists:artigos,id',
        ]);

        try {
            DB::beginTransaction();

            $dadosAtualizacao = [
                'titulo' => $request->titulo,
                'organizador' => $request->organizador,
                'resumo' => $request->resumo,
                'tipo_acesso' => $request->tipo_acesso,
                'permitir_comentarios' => $request->boolean('permitir_comentarios'),
                'status' => $request->status,
            ];

            if ($request->hasFile('imagem_capa')) {
                if ($edicao->imagem_capa && file_exists(public_path($edicao->imagem_capa))) {
                    unlink(public_path($edicao->imagem_capa));
                }

                $arquivo = $request->file('imagem_capa');
                $nomeArquivo = time() . '_' . $arquivo->getClientOriginalName();
                $arquivo->move(public_path('capas'), $nomeArquivo);
                $dadosAtualizacao['imagem_capa'] = 'capas/' . $nomeArquivo;
            }

            if ($request->status === 'publicado' && is_null($edicao->data_publicacao)) {
                $dadosAtualizacao['data_publicacao'] = now();
            }

            $edicao->update($dadosAtualizacao);

            $novosArtigosIds = $request->input('artigos_ids', []);

            // A) Desvincular artigos removidos na tela
            Artigo::where('edicao_id', $edicao->id)
                ->whereNotIn('id', $novosArtigosIds)
                ->update([
                    'edicao_id' => null
                ]);

            // B) Vincular e ordenar os artigos exatamente como ficou no Drag & Drop
            foreach ($novosArtigosIds as $index => $artigoId) {
                Artigo::where('id', $artigoId)->update([
                    'edicao_id' => $edicao->id,
                    'ordem' => $index + 1,
                ]);
            }

            DB::commit();

            $mensagem = $request->status === 'rascunho'
                ? 'Rascunho atualizado com sucesso!'
                : 'Edição atualizada e publicada com sucesso!';

            return redirect()->route('admin.edicoes.index')->with('success', $mensagem);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Ocorreu um erro interno ao atualizar: ' . $e->getMessage());
        }
    }
}
