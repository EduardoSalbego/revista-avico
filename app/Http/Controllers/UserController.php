<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        // Pendentes separados (sem paginar — geralmente poucos)
        $pendentes = User::where('status', 'pendente')
            ->orderBy('created_at', 'asc')
            ->get();

        // Ativos paginados
        $usuarios = User::where('status', 'ativo')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.usuarios.index', compact('usuarios', 'pendentes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        return view('admin.usuarios.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,leitor,autor,revisor,editor',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuário criado com sucesso!');
    }

    /**
     * Approve a pending user account.
     * 
     * @param mixed $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function aprovar($id)
    {
        $user = User::findOrFail($id);

        if ($user->status !== 'pendente') {
            return back()->with('success', 'Este usuário já está ativo.');
        }

        $user->update(['status' => 'ativo']);

        return back()->with('success', "Conta de {$user->name} aprovada com sucesso!");
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     */
    public function edit($id)
    {
        $usuario = User::findOrFail($id);
        return view('admin.usuarios.edit', compact('usuario'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, $id)
    {
        $usuario = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $usuario->id,
            'role' => 'required|in:admin,leitor,autor,revisor,editor'
        ]);

        $dados = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        // Só atualiza a senha se o admin digitou uma nova
        if ($request->filled('password')) {
            $dados['password'] = Hash::make($request->password);
        }

        $usuario->update($dados);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuário atualizado!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        $usuario = User::findOrFail($id);
        $usuario->delete();

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuário excluído!');
    }
}
