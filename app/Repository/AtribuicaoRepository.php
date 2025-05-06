<?php

namespace App\Repository;

use Illuminate\Http\Request;
use App\Models\Avaliador;
use App\Models\Avaliacao;
use App\Models\ArtigoFinal;
use App\Models\ArtigoAvaliador;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AtribuicaoRepository
{

    public function showAvaliadores()
    {

        return Avaliador::paginate(10);
    }

    public function atribuirAvaliacao(Request $request)
    {
        $article = ArtigoFinal::where('id', $request->artigo)->first();
        if($article->situacao_id == 4){
            $article->situacao_id = 3;
            $article->update();
        }      

        $avaliacao = new ArtigoAvaliador();      
        $avaliacao->artigo_id = $request->artigo;
        $avaliacao->avaliador_id = $request->id;
        $avaliacao->save();
        
    }
}
