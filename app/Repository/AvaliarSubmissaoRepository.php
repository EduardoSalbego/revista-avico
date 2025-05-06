<?php
namespace App\Repository;


use App\Models\Avaliacao;
use App\Models\Submissao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AvaliarSubmissaoRepository{

    public function showSubmissions(){

        return Submissao::paginate(10);
    }

    public function showArticlesPerSubmission($id){

        $artigos = DB::table('SubmissaoArtigo')->where('submissao_id', $id)->get();
        return $artigos;
    }

    public function showArticle($id){

        $artigo = DB::table('artigos')->where('id', $id)->first();
        return $artigo;
    }

    public function store($user_id, Request $request) // repository
    {

        $dados = request()->validate([
            'nota' => 'numeric|min:1|max:10',
            'comentarios' => 'nullable'
        ]);

        $avaliador = DB::table('avaliadors')->where('user_id', $user_id)->first();
        $avaliacao = new Avaliacao();
        $avaliacao->nota = $request->nota;
        $avaliacao->comentarios = $request->comentarios;
        $avaliacao->avaliador_id = $avaliador->id;
        $avaliacao->artigo_id = $request->id;


        return $avaliacao->push();
    }

}

?>
