<?php

namespace App\Http\Controllers\Editor;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Business\Editor\AtribuicaoBusiness;

class AtribuirAvaliacaoController extends Controller
{

    private AtribuicaoBusiness $business;

    public function showAvaliadores()
    {

        $this->business = new AtribuicaoBusiness;
        $avaliadores = $this->business->showAvaliadores();

        return view('editores.atribuirava', ['avaliadores' => $avaliadores]);
    }

    public function atribuirAvaliacao(Request $request)
    {
        $numAvaliadores = DB::table('artigoavaliador')
        ->where('artigo_id',$request->artigo)
        ->count('avaliador_id');

        if($numAvaliadores <= 2){

            $this->business = new AtribuicaoBusiness;
            $request = $this->business->atribuirAvaliacao($request);
            
            return redirect()->route('lista.avaliadores');
        }else{
            Session::flash('error', 'Esse artigo já possui muitos avaliadores vinculados.');
            return redirect()->route('lista.avaliadores');
        }
    }
}
