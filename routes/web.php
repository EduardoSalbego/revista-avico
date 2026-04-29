<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Edicao\EdicaoController;
use App\Http\Controllers\Edicao\ComentarioController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Assinatura\AssinaturaController;
use App\Http\Controllers\Perfil\ProfileController;
use App\Http\Controllers\Autor\SubmissaoController as AutorSubmissaoController;
use App\Http\Controllers\Editor\SubmissaoController as EditorSubmissaoController;
use App\Http\Controllers\RevisorBuscaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// ==========================================
// 1. ROTAS PÚBLICAS (Visitantes em geral)
// ==========================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/sobre_nos', function () {
    return view('revico/sobre_nos');
})->name('sobre_nos');

Route::prefix('edicoes')->name('edicoes.')->group(function () {
    Route::get('/', [EdicaoController::class, 'index'])->name('index');
});

Route::get('/revista2', function () {
    return view('revista/revista');
})->name('revista');

// Rotas de Autenticação
Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);
Route::get('/redefinir_senha', function () {
    return view('auth.passwords.email');
});

// ==========================================
// 2. Rotas de Assinantes
// ==========================================
Route::middleware(['auth', 'assinatura'])->group(function () {
    Route::prefix('edicoes')->name('edicoes.')->group(function () {
        Route::get('/{id}', [EdicaoController::class, 'show'])->where('id', '[0-9]+')->name('show');
    });
});

// ==========================================
// 3. ROTAS AUTENTICADAS (Requer Login)
// ==========================================
Route::middleware('auth')->group(function () {
    Route::get('/assinar', function () {
        return view('revico/assinatura');
    })->name('assinar');
    Route::post('/processar_pagamento', [AssinaturaController::class, 'processar'])->name('pagamento.processar');

    Route::get('/perfil', [ProfileController::class, 'index'])->name('perfil.index');
    Route::put('/perfil', [ProfileController::class, 'update'])->name('perfil.update');

    Route::get('/logout', [LoginController::class, 'destroy'])->name('logout');
    Route::prefix('comentarios')->name('comentarios.')->group(function () {
        Route::post('/', [ComentarioController::class, 'store'])->name('store');
        Route::delete('/{id}', [ComentarioController::class, 'destroy'])->name('destroy');
    });
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');
    Route::get('/revisores/buscar', [RevisorBuscaController::class, 'buscar']);
});

// ==========================================
// 4. ROTAS ADMINISTRATIVAS (Requer Admin)
// ==========================================
Route::middleware('role:admin')->prefix('admin')->as('admin.')->group(function () {
    Route::resource('usuarios', UserController::class);

    Route::prefix('edicoes')->name('edicoes.')->group(function () {
        Route::get('/', [EdicaoController::class, 'indexAdmin'])->name('index');
        Route::prefix('/{id}')->where(['id' => '[0-9]+'])->group(function () {
            Route::get('/editar', [EdicaoController::class, 'edit'])->name('edit');
            Route::put('/', [EdicaoController::class, 'update'])->name('update');
            Route::delete('/', [EdicaoController::class, 'destroy'])->name('destroy');
        });
    });
    Route::patch('/usuarios/{id}/aprovar', [UserController::class, 'aprovar'])->name('usuarios.aprovar');
});

// ==========================================
// 5. ROTAS DE EDITORIA (Requer Editor)
// ==========================================
Route::middleware('role:editor')->prefix('/editor')->name('editor.')->group(function () {
    Route::get('/edicoes/create', [EdicaoController::class, 'create'])->name('edicoes.create');
    Route::post('/edicoes/create', [EdicaoController::class, 'store'])->name('edicoes.store');
    Route::prefix('/submissoes')->name('submissoes.')->group(function () {
        Route::get('/', [EditorSubmissaoController::class, 'index'])->name('index');
        Route::patch('/{id}/atribuir', [EditorSubmissaoController::class, 'atribuir'])->name('atribuir');
        Route::patch('/{id}/decidir', [EditorSubmissaoController::class, 'decidir'])->name('decidir');
    });
});

// ==========================================
// 6. ROTAS DE AUTORES (Requer Autor)
// ==========================================
Route::middleware('role:autor')->prefix('/autor')->name('autor.')->group(function () {
    Route::prefix('/submissoes')->name('submissoes.')->group(function () {
        Route::get('/', [AutorSubmissaoController::class, 'index'])->name('index');
        Route::post('/', [AutorSubmissaoController::class, 'store'])->name('store');
        Route::get('/criar', [AutorSubmissaoController::class, 'create'])->name('create');
        Route::post('/{id}/docx', [AutorSubmissaoController::class, 'enviarDocx'])->name('docx');
    });
});

require __DIR__ . '/auth.php';
