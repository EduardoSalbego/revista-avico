<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RevisorBuscaController extends Controller
{
    public function buscar(Request $request)
    {
        $q = $request->query('q', '');

        $revisores = User::where('role', 'revisor')
            ->where('status', 'ativo')
            ->where('name', 'like', "%{$q}%")
            ->select('id', 'name')
            ->limit(8)
            ->get();

        return response()->json($revisores);
    }
}
