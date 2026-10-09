<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FuncionarioController;
use App\Http\Controllers\AgendamentoController;
use App\Http\Controllers\GaleriaController;

// Rota principal - redireciona para o dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Funcionários - CRUD completo
Route::resource('funcionarios', FuncionarioController::class);

// Agendamentos - CRUD completo + atualização de status
Route::resource('agendamentos', AgendamentoController::class);
Route::patch('/agendamentos/{agendamento}/status', [AgendamentoController::class, 'updateStatus'])
    ->name('agendamentos.update-status');

// Galeria - CRUD completo
Route::resource('galerias', GaleriaController::class);

// Perfil público do tatuador (com toda a galeria)
Route::get('/tatuadores/{funcionario}/perfil', [GaleriaController::class, 'perfilTatuador'])
    ->name('tatuadores.perfil');

// Importar agendamentos para galeria em lote
Route::post('/tatuadores/{funcionario}/importar-galeria', [GaleriaController::class, 'importarAgendamentos'])
    ->name('tatuadores.importar-galeria');
