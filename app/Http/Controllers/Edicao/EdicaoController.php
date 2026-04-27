<?php

namespace App\Http\Controllers\Edicao;

use App\Models\Edicao;
use App\Models\Comentario;

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
        $query = Edicao::query();
    
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
        $request->validate([
            'titulo' => 'required|string|max:255',
            'autor' => 'required|string|max:255',
            'imagem_capa' => 'required|image|mimes:jpeg,png,jpg|max:2048', 
            'conteudo_html' => 'required|string',
        ]);


        $arquivo = $request->file('imagem_capa');
        $nomeArquivo = time() . '_' . $arquivo->getClientOriginalName();
        $arquivo->move(public_path('capas'), $nomeArquivo);
        $caminhoCapa = 'capas/' . $nomeArquivo;

        $edicao = new Edicao();
        $edicao->titulo = $request->titulo;
        $edicao->autor = $request->autor;
        $edicao->imagem_capa = $caminhoCapa;
        $edicao->conteudo_html = $request->conteudo_html;
        $edicao->save();

        return redirect()->back()->with('success', 'Edição da revista criada com sucesso!');
    }

    // Lista todas as edições no formato de tabela para o admin
    public function indexAdmin()
    {
        $edicoes = Edicao::orderBy('created_at', 'desc')->paginate(10);
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
            'imagem_capa' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'tipo_conteudo' => 'required|in:blocos,pdf',
            'arquivo_pdf' => 'nullable|mimes:pdf|max:10240', 
        ]);

        $edicao->titulo = $request->titulo;
        $edicao->autor = $request->autor;
        $edicao->tipo_conteudo = $request->tipo_conteudo;

        if ($request->hasFile('imagem_capa')) {
            $arquivo = $request->file('imagem_capa');
            $nomeArquivo = time() . '_' . $arquivo->getClientOriginalName();
            $arquivo->move(public_path('capas'), $nomeArquivo);
            $edicao->imagem_capa = 'capas/' . $nomeArquivo;
        }

        if ($request->tipo_conteudo === 'pdf') {
            
            if ($request->hasFile('arquivo_pdf')) {
                $arquivo = $request->file('arquivo_pdf');
                $nomeArquivo = time() . '_' . $arquivo->getClientOriginalName();
                $arquivo->move(public_path('edicoes_pdfs'), $nomeArquivo);
                $edicao->arquivo_pdf = 'edicoes_pdfs/' . $nomeArquivo;
            }
            $edicao->conteudo_blocos = null;
            
        } else {
            $blocosFormatados = [];
            
            if ($request->has('tipo')) {
                $textos = $request->input('conteudo', []);
                $arquivos = $request->file('conteudo', []);
                $conteudosAntigos = $request->input('conteudo_antigo', []); 
                
                $indiceTexto = 0;
                $indiceArquivo = 0;

                foreach ($request->tipo as $index => $tipo) {
                    $conteudo = null;
                
                    if ($tipo === 'imagem') {
                        if (isset($arquivos[$indiceArquivo])) {
                            $arquivo = $arquivos[$indiceArquivo];
                            $nomeArquivo = time() . '_' . $arquivo->getClientOriginalName();
                            $arquivo->move(public_path('blocos_imagens'), $nomeArquivo);
                            $conteudo = 'blocos_imagens/' . $nomeArquivo;
                        } else {
                            $conteudo = $conteudosAntigos[$index] ?? null;
                        }
                        $indiceArquivo++; 
                        
                    } else { 
                        if (isset($textos[$indiceTexto])) {
                            $conteudo = $textos[$indiceTexto];
                        }
                        $indiceTexto++; 
                    }

                    $blocosFormatados[] = [
                        'tipo' => $tipo,
                        'conteudo' => $conteudo,
                        'ordem' => $index + 1
                    ];
                }
            }
            
            $edicao->conteudo_blocos = json_encode($blocosFormatados);
            $edicao->arquivo_pdf = null;
        }

        $edicao->save();

        return redirect()->route('admin.edicoes.index')->with('success', 'Edição atualizada com sucesso!');
    }
}
