<?php

namespace App\Repository;

use App\Models\User;
use App\Models\Editor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class EditorRepository
{

    public function show()
    {
        return Editor::paginate(10);
    }

    public function store(array $data, $user_id) // repository
    {
        // $dados = request()->validate([
        //     'nome' => 'required|min:3',
        //     'email' => 'required|max:250',
        //     'endereco' => 'required|max:250',
        //     'telefone' => 'required|max:13|min:13',
        //     'area_id' => 'nullable',
        //     'pais_id' => 'nullable',
        //     'dataContratacao' => 'required',
        // ]);

        $editor = new Editor();
        $editor->user_id = $user_id;
        $editor->area_id = $data['especialidade'];
        $editor->dataContratacao = $data['dataContratacao'];

        return $editor->save();
    }

    public function update(Request $request) // repository
    {

        $dados = request()->validate([
            'nome' => 'required|min:3',
            'endereco' => 'required|max:255|min:10',
            'telefone' => 'required|max:13|min:13',
            'area_id' => 'nullable',
            'pais_id' => 'nullable',
        ]);

        $editor = new Editor();
        $editor = Editor::where('id', $request->id)->first();

        $editor->user->name = $request->nome;
        $editor->user->endereco = $request->endereco;
        $editor->user->telefone = $request->telefone;
        $editor->user->pais_id = $request->pais_id;
        $editor->area_id = $request->especialidade;

        return $editor->push();

    }

    public function destroy($id) // repository
    {
        $editor = Editor::findOrFail($id);
        $user = User::findOrFail($editor->user_id);
        $editor->delete();

        return $user->delete();
    }

    public function getByID($id)
    {
        try {
            $editor = Editor::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return False;
        }
        return $editor;
    }

    public function getEditorByUserID($user_id){
        return Editor::where('user_id', $user_id)->first();
    }
}
