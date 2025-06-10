<?php

use App\Http\Controllers\ClienteController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProblemaController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\TicketController;
use PHPUnit\Framework\Attributes\Ticket;

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

Route::resource('problemas', ProblemaController::class);
Route::resource('clientes', ClienteController::class);
Route::resource('perfiles', PerfilController::class);
Route::resource('usuarios', UsuarioController::class);
Route::resource('tickets', TicketController::class);

Route::middleware(['auth'])->group(function () {
    Route::get('/asignados', [TicketController::class, 'asignados'])->name('tickets.asignados');
    Route::get('/creados', [TicketController::class, 'creados'])->name('tickets.creados');
    // Si no tienes show, NO pongas /tickets/{id}
});







Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();
