<?php

namespace App\Http\Controllers;

use App\Models\Edicao;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $ultimasEdicoes = Edicao::where('status', 'publicado')
            ->orderBy('data_publicacao', 'desc')
            ->take(3)
            ->get();
        return view('welcome', compact('ultimasEdicoes'));
    }

    public function revista()
    {
        return view('');
    }


}
