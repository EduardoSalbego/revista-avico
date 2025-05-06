<?php

namespace App\Repository;

use Illuminate\Http\Request;
//use Illuminate\Contracts\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Avaliador;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
//use Illuminate\Support\Facades\Validator;

class AvaliadorRepository
{
    public function store(array $data, $user_id)
    {

        // $dados = request()->validate([
        //     'nome' => 'required|max:50|min:3',
        //     'email' => 'required|max:250',
        //     'endereco' => 'required|max:250',
        //     'telefone' => 'required|min:13|max:13',
        //     'area_pref' => 'required',
        //     'pais_origem' => 'required'
        // ]);

        $avaliador = new Avaliador();
        $avaliador ->user_id = $user_id;
        $avaliador ->area_pref=$data['area_pref'];

        // $avaliador = Avaliador::create([
        //     'nome' => $request->nome,
        //     'email' => $request->email,
        //     'endereco' => $request->endereco,
        //     'telefone' => $request->telefone,
        //     'area_pref' => $request->area_pref,
        //     'pais_origem' => $request->pais_origem,
        // ]);

        // $user = User::create([
        //     'name' => $request->nome,
        //     'email' => $request->email,
        //     'password' => Hash::make($request->password),
        // ]);



        // $user->assignRole('avaliador');
        // $user->save();

        return $avaliador->save();
    }

    public function getByID($id)
    {
        try {
            $avaliador = Avaliador::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return False;
        }
        return $avaliador;
    }

    public function show()
    {
        return Avaliador::paginate(10);
    }

    public function update(Request $request)
    {

        $data = request()->validate([
            'nome' => 'required|min:3',
            'endereco' => 'required|max:255|min:10',
            'telefone' => 'required|min:13|max:13',
            'area_pref' => 'nullable',
            'pais_origem' => 'required'
        ]);

        $avaliador = new Avaliador();
        $avaliador = Avaliador::where('id', $request->id)->first();

        $avaliador->user->name = $request->nome;
        $avaliador->user->endereco = $request->endereco;
        $avaliador->user->telefone = $request->telefone;
        $avaliador->area_pref = $request->area_pref;

        return $avaliador->push();

    }

    public function destroy($id)
    {
        $avaliador = Avaliador::findOrFail($id);
        $user = User::findOrFail($avaliador->user_id);
        $avaliador->delete();

        return $user->delete();

    }
}
