<?php

namespace App\Repository;

use Illuminate\Http\Request;
use App\Models\Autor;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AutorRepository
{

    public function store($user_id, array $data) // repository
    {
        $autor = new Autor();
        $autor->user_id = $user_id;
        $autor->orcid = $data['orcid'];
        $autor->area_id = $data['area_pref'];
        $autor->instituicao = $data['instituicao'];
        return $autor->save();
    }


    public function update(Request $request)
    {
        $request->validate([
            'nome' => 'required|min:3',
            'endereco' => 'required|max:255|min:10',
            'telefone' => 'required|min:13|max:13',
            'area_pref' => 'required',
            'instituicao' => 'required',
            'pais_origem' => 'required'
        ]);

        $autor = new Autor();
        $autor = Autor::where('orcid',$request->id)->first();

        $autor->user->name = $request->nome;
        //$autor->user->email = $request->email;
        $autor->user->endereco = $request->endereco;
        $autor->user->telefone = $request->telefone;
        $autor->area_id = $request->area_pref;
        $autor->instituicao = $request->instituicao;

        return $autor->push();
    }

    public function getAutorByUserID($user_id){
        return Autor::where('user_id', $user_id)->first();
    }

    public function getByID($id){
        try{
            $autor = Autor::findOrFail($id);
        }catch(ModelNotFoundException $e){
            return False;
        }
        return $autor;
    }

    public function destroy($id) {
        $autor = new Autor();
        $autor = Autor::where('orcid', $id)->first();
        $user = User::findOrFail($autor->user_id);
        $autor->delete();

        return $user->delete();
    }


    public function show(){
        return Autor::paginate(10);
    }

    public function queryTitle(String $title){
        return Autor::where('nome', 'LIKE', '%'.$title.'%')->get();
    }
}
