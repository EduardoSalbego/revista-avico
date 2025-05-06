<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Avaliador;
use App\Business\Avaliador\AvaliadorBusiness;

class AvaliadorController extends Controller
{

    private AvaliadorBusiness $business;

    public function show($id){

        $avaliador = Avaliador::findOrFail($id);
        return view('avaliador.show', ['avaliador' => $avaliador]);
    }

    public function edit(Request $request){
        $this->business = new AvaliadorBusiness;
        $avaliador = $this->business->selectAvaliador($request);
        return view ('avaliador.edit', ['avaliador' => $avaliador]);

    }


    public function delete(Request $request){

        $this->business = new AvaliadorBusiness;
        $request = $this->business->deleteAvaliador($request);

        return $request === True ? redirect()->route('listaAvaliadores') : redirect()->route('listaAvaliadores', 'err');

    }

    public function manage(Request $request){

        $this->business = new AvaliadorBusiness;
        $avaliadores = $this->business->manageAvaliador($request);
        return view('avaliador.manage', ['avaliador' => $avaliadores]);

    }

    public function update(Request $request){
        $this->business = new AvaliadorBusiness;
        $request = $this->business->updateAvaliador($request);

        return redirect()->route('listaAvaliadores');
    }




}
