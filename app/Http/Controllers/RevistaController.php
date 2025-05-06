<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Business\Revista\RevistaBusiness;
use App\Models\Editor;
use Illuminate\Http\Request;


class RevistaController extends Controller
{

    private RevistaBusiness $business;



    public function createForm()
    {

        $editores = Editor::all();
        return view("revista.create", compact("editores"));
    }

    public function createChamado(Request $request)
    {
        $this->business = new RevistaBusiness;
        $request = $this->business->createChamado($request);
        return redirect()->route('list.revista.mgmt');
    }

    public function create(Request $request)
    {

        if (!empty($request->all())) {
            $this->business = new RevistaBusiness;
            $request = $this->business->createRevista($request);
            return $request === True ? redirect()->route('list.revista.mgmt',) : redirect()->route('create.revista.view')->with('ERRO', $request);
        } else {
            return redirect()->route('create.revista.view', 'err');
        }
    }


    public function manage(Request $request)
    {

        $this->business = new RevistaBusiness;
        $revistas = $this->business->manageRevistas($request);

        return view('revista.manage', compact('revistas'));
    }

    public function select(Request $request)
    {
        $this->business = new RevistaBusiness;
        $revista = $this->business->selectRevista($request);

        return view('revista.edit', compact('revista'));
    }


    public function update(Request $request)
    {
        $this->business = new RevistaBusiness;
        $request = $this->business->updateRevista($request);

        return redirect()->route('list.revista.mgmt');
    }

    public function delete(Request $request)
    {

        $this->business = new RevistaBusiness;
        $request = $this->business->deleteRevista($request);

        return $request === True ? redirect()->route('list.revista.mgmt') : redirect()->route('list.revista.mgmt', 'err');
    }
}
