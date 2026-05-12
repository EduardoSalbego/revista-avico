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
use App\Http\Controllers\Revisor\ParecerController;

// ==========================================
// 1. ROTAS PÚBLICAS
// ==========================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/sobre_nos', fn() => view('revico/sobre_nos'))->name('sobre_nos');
Route::get('/revista2', fn() => view('revista/revista'))->name('revista');

Route::prefix('edicoes')->name('edicoes.')->group(function () {
    Route::get('/', [EdicaoController::class, 'index'])->name('index');
});

// Autenticação
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
    Route::get('/redefinir_senha', fn() => view('auth.passwords.email'))->name('password.request');
});

// ==========================================
// 2. ASSINANTES
// ==========================================
Route::middleware(['auth', 'assinatura'])->group(function () {
    Route::prefix('edicoes')->name('edicoes.')->group(function () {
        Route::get('/{id}', [EdicaoController::class, 'show'])
            ->where('id', '[0-9]+')
            ->name('show');
    });
});

// ==========================================
// 3. AUTENTICADAS
// ==========================================
Route::middleware('auth')->group(function () {
    Route::get('/logout', [LoginController::class, 'destroy'])->name('logout');

    Route::get('/dashboard', fn() => view('dashboard'))
        ->middleware('verified')
        ->name('dashboard');

    Route::get('/assinar', fn() => view('revico/assinatura'))->name('assinar');
    Route::post('/processar_pagamento', [AssinaturaController::class, 'processar'])
        ->name('pagamento.processar');

    // Perfil básico do usuário
    Route::prefix('perfil')->name('perfil.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::put('/', [ProfileController::class, 'update'])->name('update');
        Route::post('/', [ProfileController::class, 'salvarPerfil'])->name('funcao.store');
        Route::put('/perfil/temas/{tipo}', [ProfileController::class, 'updateTemas'])->name('temas.update');
    });

    Route::prefix('comentarios')->name('comentarios.')->group(function () {
        Route::post('/', [ComentarioController::class, 'store'])->name('store');
        Route::delete('/{id}', [ComentarioController::class, 'destroy'])->name('destroy');
    });

    // Busca de revisores (pode ser usada pelo editor)
    Route::get('/revisores/buscar', [RevisorBuscaController::class, 'buscar'])
        ->name('revisores.buscar');
});

// ==========================================
// 4. ADMIN
// ==========================================
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::resource('usuarios', UserController::class);
        Route::patch('/usuarios/{revisor}/aprovar', [UserController::class, 'aprovar'])
            ->name('usuarios.aprovar');
        Route::patch('/usuarios/{revisor}/rejeitar', [UserController::class, 'rejeitar'])
            ->name('usuarios.rejeitar');

        Route::prefix('edicoes')->name('edicoes.')->group(function () {
            Route::get('/', [EdicaoController::class, 'indexAdmin'])->name('index');
            Route::prefix('/{id}')->where(['id' => '[0-9]+'])->group(function () {
                Route::get('/editar', [EdicaoController::class, 'edit'])->name('edit');
                Route::put('/', [EdicaoController::class, 'update'])->name('update');
                Route::delete('/', [EdicaoController::class, 'destroy'])->name('destroy');
            });
        });
    });

// ==========================================
// 5. EDITOR
// ==========================================
Route::middleware(['auth', 'role:editor|admin'])
    ->prefix('editor')
    ->name('editor.')
    ->group(function () {

        Route::get('/edicoes/create', [EdicaoController::class, 'create'])->name('edicoes.create');
        Route::post('/edicoes/create', [EdicaoController::class, 'store'])->name('edicoes.store');

        Route::prefix('/submissoes')->name('submissoes.')->group(function () {
            Route::get('/', [EditorSubmissaoController::class, 'index'])->name('index');
            Route::patch('/{id}/atribuir', [EditorSubmissaoController::class, 'atribuir'])->name('atribuir');
            Route::patch('/{id}/decidir', [EditorSubmissaoController::class, 'decidir'])->name('decidir');
            Route::patch('/{submissao}/substituir-revisor', [EditorSubmissaoController::class, 'substituirRevisor'])->name('substituirRevisor');
        });
    });

// ==========================================
// 6. AUTOR
// ==========================================
Route::middleware(['auth', 'perfil:autor'])
    ->prefix('autor')
    ->name('autor.')
    ->group(function () {

        Route::prefix('/submissoes')->name('submissoes.')->group(function () {
            Route::get('/', [AutorSubmissaoController::class, 'index'])->name('index');
            Route::get('/criar', [AutorSubmissaoController::class, 'create'])->name('create');
            Route::post('/', [AutorSubmissaoController::class, 'store'])->name('store');
            Route::post('/{id}/docx', [AutorSubmissaoController::class, 'enviarDocx'])->name('docx');
            Route::post('/{id}/resubmeter', [AutorSubmissaoController::class, 'resubmeter'])->name('resubmeter');
        });
    });

// ==========================================
// 7. REVISOR
// ==========================================
Route::middleware(['auth', 'perfil:revisor', 'revisor.aprovado'])
    ->prefix('revisor')
    ->name('revisor.')
    ->group(function () {

        Route::prefix('/pareceres')->name('pareceres.')->group(function () {
            Route::get('/', [ParecerController::class, 'index'])->name('index');
            Route::patch('/{id}/tarefa', [ParecerController::class, 'responderTarefa'])->name('responderTarefa');
            Route::patch('/{id}/emitir', [ParecerController::class, 'emitir'])->name('emitir');
        });
    });

require __DIR__ . '/auth.php';