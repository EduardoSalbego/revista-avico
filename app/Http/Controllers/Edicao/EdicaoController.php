<?php

namespace App\Http\Controllers\Edicao;

use App\Models\Edicao;
use App\Models\Revista;
use App\Models\Submissao;
use App\Models\ArtigoFinal;
use App\Models\ArtigoAvaliador;
use App\Models\SubmissaoArtigo;
use App\Models\Avaliacao;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class EdicaoController extends Controller
{
    public function create()
    {
        $proximaEdicao = Edicao::count() + 1;

        return view('revista.create', compact('proximaEdicao'));
    }
    public function manage($id)
    {
        $revista = Revista::where('id', $id)->first();
        $edicoes = Edicao::paginate(10);

        return view('edicao.manage', compact('edicoes', 'revista'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'autor' => 'required|string|max:255',
            'imagem_capa' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'tipo_conteudo' => 'required|in:blocos,pdf',
            'arquivo_pdf' => 'required_if:tipo_conteudo,pdf|mimes:pdf|max:10240', 
        ]);

        // 2. Upload da Imagem de Capa
        $caminhoCapa = $request->file('imagem_capa')->store('capas', 'public');

        // 3. Criando a instância da Edição
        $edicao = new Edicao();
        $edicao->titulo = $request->titulo;
        $edicao->autor = $request->autor;
        $edicao->imagem_capa = $caminhoCapa;
        $edicao->tipo_conteudo = $request->tipo_conteudo;

        // 4. Lógica de Salvamento baseada no Tipo de Conteúdo
        if ($request->tipo_conteudo === 'pdf') {
            
            // Faz o upload do PDF
            $caminhoPdf = $request->file('arquivo_pdf')->store('edicoes_pdfs', 'public');
            $edicao->arquivo_pdf = $caminhoPdf;
            $edicao->conteudo_blocos = null; // Garante que a coluna de blocos fique vazia

        } else {
            
            // Lógica para os Blocos
            $blocosFormatados = [];
            
            if ($request->has('tipo') && $request->has('conteudo')) {
                foreach ($request->tipo as $index => $tipo) {
                    $conteudo = $request->conteudo[$index];

                    // Se o bloco for uma imagem, precisamos fazer o upload dela também
                    if ($tipo === 'imagem' && $request->file("conteudo.{$index}")) {
                        $conteudo = $request->file("conteudo.{$index}")->store('blocos_imagens', 'public');
                    }

                    $blocosFormatados[] = [
                        'tipo' => $tipo,
                        'conteudo' => $conteudo,
                        'ordem' => $index + 1
                    ];
                }
            }
            
            // Salva os blocos em formato JSON no banco de dados
            $edicao->conteudo_blocos = json_encode($blocosFormatados);
            $edicao->arquivo_pdf = null;
        }

        // 5. Salva no banco de dados
        $edicao->save();

        // 6. Redireciona com mensagem de sucesso
        return redirect()->back()->with('success', 'Edição da revista criada com sucesso!');
    }
}
