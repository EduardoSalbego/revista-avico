<?php

namespace App\Http\Controllers\Artigo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Edicao;
use App\Models\User;
use App\Models\Artigo;
use App\Models\Autor;

class ArtigoController extends Controller
{
    public function show($id)
    {
        $artigo = Artigo::findOrFail($id);
        return view('artigo.show', compact('artigo'));
    }

    public function create()
    {
        $usuarios = User::all();
        return view('artigo.create', compact('usuarios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'edicao_id' => 'required|exists:edicoes,id',
            'user_id' => 'required|exists:users,id', // Validação do autor cadastrado
            'titulo' => 'required|string|max:255',
            // ... outras validações ...
        ]);

        $caminhoPdf = $request->file('arquivo_pdf')->store('artigos/pdfs', 'public');

        $artigo = Artigo::create([
            'edicao_id' => $request->edicao_id,
            'user_id' => $request->user_id, // Vincula ao usuário escolhido
            'titulo' => $request->titulo,
            'resumo' => $request->resumo,
            'arquivo_pdf' => $caminhoPdf,
            'ordem' => $request->ordem,
            'doi' => $request->doi,
            'palavras_chave' => $request->palavras_chave,
        ]);

        // Opcional: Se quiser que o Autor escolhido também entre na tabela 'autores' automaticamente
        $autorPrincipal = User::find($request->user_id);
        Autor::create([
            'artigo_id' => $artigo->id,
            'nome' => $autorPrincipal->name,
            'instituicao' => 'Instituição Principal', // Ou pegue do perfil do user se existir
        ]);

        return redirect()->route('editor.edicoes.index')->with('success', 'Artigo manual criado com sucesso!');
    }
}
