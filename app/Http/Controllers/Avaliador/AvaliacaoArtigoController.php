<?php

namespace App\Http\Controllers\Avaliador;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Business\Avaliador\AvaliarSubmissaoBusiness;

class AvaliacaoArtigoController extends Controller{

    public function showavaliacoes(Request $request){

        $id = Auth::id();
            $ava = DB::table('avaliadors')
            ->where('user_id', $id)
            ->first(); 
//Passar id para utilizar na rota
//O botão de visualizar mostrará somente aquele artigo e não todos
        $avaliacao = DB::table('avaliacao')
            ->where('avaliador_id', $ava->id)
            ->get();
    return view ('avaliador.avaliacaonota', ['avaliacao' => $avaliacao, 'artigo_id' => $request->id]);

    }
}