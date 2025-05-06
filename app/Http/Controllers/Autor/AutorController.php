<?php

namespace App\Http\Controllers\Autor;

use App\Business\Autor\AutorBusiness;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Autor;

class AutorController extends Controller
{


    public function edit(Request $request)
    {
        $this->business = new AutorBusiness;
        $autor = $this->business->selectAutor($request);

        return view('autor.editar', ['autor' => $autor]);
    }

    public function delete(Request $request)
    {
        $this->business = new AutorBusiness;
        $request = $this->business->deleteAutor($request);

        return $request === True ? redirect()->route('list.autor.mgmt') : redirect()->route('list.autor.mgmt', 'err');
    }

    public function show($id)
    {
        $autor = Autor::findOrFail($id);
        return view('autor.mostrar', ['autor' => $autor]);
    }

    public function show_with_pagination()
    {
        return Autor::paginate(10);
    }

    public function manage(Request $request)
    {
        $this->business = new AutorBusiness;
        $autores = $this->business->manageAutor($request);

        return view('autor.gerenciar', ['autor' => $autores]);
    }

    public function update(Request $request)
    {
        $this->business = new AutorBusiness;
        $request = $this->business->updateAutor($request);

        return redirect()->route('list.autor.mgmt');
        
    }

}
