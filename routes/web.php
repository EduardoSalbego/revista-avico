<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Edicao\EdicaoController;
use App\Http\Controllers\Edicao\ComentarioController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;

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
Route::get('/sobre_nos', function () { return view('revico/sobre_nos'); }) -> name('sobre_nos');

Route::prefix('edicoes')->name('edicoes.')->group(function () {
    Route::get('/', [EdicaoController::class, 'index'])->name('index');
    Route::get('/{id}', [EdicaoController::class, 'show'])->where('id', '[0-9]+')->name('show');
});

Route::get('/revista2', function () { return view('revista/revista'); }) -> name('revista');


// ==========================================
// 2. Rotas de Autenticação (Acesso deslogado)
// ==========================================
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::get('/redefinir_senha', function () { return view('auth.passwords.email'); });


// ==========================================
// 3. ROTAS AUTENTICADAS (Requer Login)
// ==========================================
Route::middleware('auth')->group(function () {
    Route::get('/assinar', function () { return view('revico/assinatura'); }) -> name('assinar');
    Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::prefix('comentarios')->name('comentarios.')->group(function () {
        Route::post('/', [ComentarioController::class, 'store'])->name('store');
        Route::delete('/{id}', [ComentarioController::class, 'destroy'])->name('destroy');
    });
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');
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
});

// ==========================================
// 5. ROTAS DE EDITORIA (Requer Colaborador)
// ==========================================
Route::middleware('role:colaborador')->group(function () {
    Route::get('/edicoes/create', [EdicaoController::class, 'create'])->name('edicoes.create');
    Route::post('/edicoes/create', [EdicaoController::class, 'store'])->name('edicoes.store');
});

require __DIR__ . '/auth.php';
