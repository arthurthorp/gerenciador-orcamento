<?php

use App\Http\Controllers\LerEstadosController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\OrcamentoController;
use App\Http\Controllers\CidadeController;
use App\Http\Controllers\LogoController;

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

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware('auth:sanctum', 'verified')->prefix('admin')->group( function (){
    Route::get("/dashboard", function(){
        return view("dashboard");
    })->name("dashboard");

    Route::prefix('clientes')->group( function(){
        Route::get("/", [ClienteController::class, 'index'])->name("clientes");
        Route::get("/create", [ClienteController::class, 'create'])->name("clientes.create");
        Route::post("/", [ClienteController::class, 'store'])->name("clientes.store");
        Route::get("/{id}", [ClienteController::class, 'show'])->name("clientes.show");
        Route::get("/{id}/edit", [ClienteController::class, 'edit'])->name("clientes.edit");
        Route::put("/{id}", [ClienteController::class, 'update'])->name("clientes.update");
        Route::delete("/{id}", [ClienteController::class, 'destroy'])->name("clientes.destroy");
    });

    Route::prefix('orcamentos')->group( function(){
        Route::get("/", [OrcamentoController::class, 'index'])->name("orcamentos");
        Route::get("/create", [OrcamentoController::class, 'create'])->name("orcamentos.create");
        Route::post("/", [OrcamentoController::class, 'store'])->name("orcamentos.store");
        Route::get("/{id}", [OrcamentoController::class, 'show'])->name("orcamentos.show");
        Route::get("/{id}/edit", [OrcamentoController::class, 'edit'])->name("orcamentos.edit");
        Route::put("/{id}", [OrcamentoController::class, 'update'])->name("orcamentos.update");
        Route::delete("/{id}", [OrcamentoController::class, 'destroy'])->name("orcamentos.destroy");

        Route::get("/{id}/download", [OrcamentoController::class, 'download'])->name("orcamentos.download");
    });

    Route::put("users/{id}/logo", [LogoController::class, 'update'])->name("users.logo");

    Route::get("/cidades", [CidadeController::class, 'find'])->name("cidades.find");
});

Route::get('estados', [LerEstadosController::class, 'save']);

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
