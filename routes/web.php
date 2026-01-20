<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AuthController;

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
/*
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/edicoes', function () {
    return view('revista/edicoes');
});
Route::get('/revista', function () {
    return view('revista/revista');
});
Route::get('/sobre_nos', function () {
    return view('revico/sobre_nos');
});
Route::get('/assinar', function () {
    return view('revico/assinatura');
});
Route::get('/nova_edicao', function () {
    return view('revista/create');
});

// AUTH
Route::get('/entrar', function () {
    return view('auth/login');
});
Route::get('/cadastro', function () {
    return view('auth/register');
});
Route::get('/redefinir_senha', function () {
    return view('auth/passwords/email');
});
// CADASTRO
Route::post('/register', [AuthController::class, 'register'])->name('register');
// LOGIN
Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store']);
// LOGOUT
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/')->with('success', 'Você saiu da sua conta.');
})->name('logout');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/auth.php';
