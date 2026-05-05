<?php

use Illuminate\Support\Facades\Route;
use App\Models\Ruta;
use App\Models\Tiquete;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\TiqueteController;

Route::get('/', function () {
    $rutas = Ruta::orderBy('id')->get();

    return view('welcome', compact('rutas'));
});

Route::post('/registrar-cliente', [ClienteController::class, 'registrar'])
    ->name('clientes.registrar');

Route::post('/login-cliente', [ClienteController::class, 'login'])
    ->name('clientes.login');

Route::post('/logout-cliente', [ClienteController::class, 'logout'])
    ->name('clientes.logout');

Route::get('/compra', function () {
    if (!session()->has('cliente_id')) {
       return redirect()->route('acceso')->with('error_login', 'Debe iniciar sesión para acceder al sistema de compra.');
    }

    $rutas = Ruta::orderBy('id')->get();

    $misTiquetes = Tiquete::with('ruta')
        ->where('cliente_id', session('cliente_id'))
        ->orderByDesc('id')
        ->get();

    return view('compra', compact('rutas', 'misTiquetes'));
})->name('compra.index');

Route::post('/comprar-tiquete', [TiqueteController::class, 'comprar'])
    ->name('tiquetes.comprar');

Route::get('/comprobante', [TiqueteController::class, 'comprobante'])
    ->name('tiquetes.comprobante');

Route::get('/comprobante/{tiquete}', [TiqueteController::class, 'comprobanteIndividual'])
    ->name('tiquetes.comprobante.individual');

Route::get('/contacto', function () {
    return view('contacto');
});

Route::get('/horarios', function () {
    $rutas = Ruta::orderBy('id')->get();

    return view('horarios', compact('rutas'));
});

Route::get('/registro', function () {
    return view('registro');
});

Route::get('/acceso', function () {
    return view('acceso');
})->name('acceso');