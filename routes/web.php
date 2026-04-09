<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Edicao\EdicaoController;
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
Route::get('/edicoes', [EdicaoController::class, 'index'])->name('edicoes');
Route::get('/revista/{id}', [EdicaoController::class, 'show'])->name('revista.show');
Route::get('/revista', function () { return view('revista/revista'); }) -> name('revista');
Route::get('/sobre_nos', function () { return view('revico/sobre_nos'); }) -> name('sobre_nos');


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
    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/')->with('success', 'Você saiu da sua conta.');
    })->name('logout');
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');
});

// ==========================================
// 4. ROTAS ADMINISTRATIVAS (Requer Admin)
// ==========================================


// ==========================================
// 5. ROTAS DE EDITORIA (Requer Colaborador)
// ==========================================
Route::middleware('role:colaborador')->group(function () {
    Route::get('/nova_edicao', [EdicaoController::class, 'create'])->name('create.edicao');
    Route::post('/nova_edicao', [EdicaoController::class, 'store'])->name('store.edicao');
});

require __DIR__ . '/auth.php';
