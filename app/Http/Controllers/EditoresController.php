<?php

namespace App\Http\Controllers;

use App\Business\Editor\EditorBusiness;
use Illuminate\Http\Request;
use App\Models\Editor;

class EditoresController extends Controller
{

    private EditorBusiness $business;

    public function show($id)
    {
        $editor = Editor::findOrFail($id);
        return view('editores.show', ['editor' => $editor]);
    }

    public function manage(Request $request)
    {
        $this->business = new EditorBusiness;
        $editor = $this->business->manageEditor($request);
        return view('editores.manage', ['editor' => $editor]);
    }


    public function edit(Request $request)
    {
        $this->business = new EditorBusiness;
        $editor = $this->business->selectEditor($request);
        return view('editores.edit', ['editor' => $editor] );
    }

    public function update(Request $request)
    {
        $this->business = new EditorBusiness;
        $request = $this->business->updateEditor($request);

        return redirect()->route('lista_editores');
    }

    public function delete(Request $request)
    {
        $this->business = new EditorBusiness;
        $request = $this->business->deleteEditor($request);
        return $request === True ? redirect()->route('lista_editores') : redirect()->route('lista_editores', 'err');
    }
}
