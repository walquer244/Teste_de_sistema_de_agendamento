<?php

namespace App\Http\Controllers;

use App\Models\Funcionario;
use App\Models\Agendamento;
use App\Models\Galeria;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAgendamentos = Agendamento::count();
        $agendamentosHoje = Agendamento::whereDate('data_agendamento', today())->count();
        $agendamentosPendentes = Agendamento::where('status', 'pendente')->count();
        $agendamentosConcluidos = Agendamento::where('status', 'concluido')->count();

        $totalFuncionarios = Funcionario::where('ativo', true)->count();
        $totalTatuadores = Funcionario::tatuadores()->count();

        $totalGaleria = Galeria::count();

        $proximosAgendamentos = Agendamento::with('funcionario')
            ->where('data_agendamento', '>=', today())
            ->where('status', '!=', 'cancelado')
            ->orderBy('data_agendamento')
            ->orderBy('hora_agendamento')
            ->take(5)
            ->get();

        $tatuadoresDestaque = Funcionario::tatuadores()
            ->withCount(['agendamentos' => function ($q) {
                $q->where('status', 'concluido');
            }])
            ->orderByDesc('agendamentos_count')
            ->take(3)
            ->get();

        $receitaMes = Agendamento::whereMonth('data_agendamento', now()->month)
            ->whereYear('data_agendamento', now()->year)
            ->where('status', 'concluido')
            ->sum('valor_estimado');

        return view('dashboard', compact(
            'totalAgendamentos',
            'agendamentosHoje',
            'agendamentosPendentes',
            'agendamentosConcluidos',
            'totalFuncionarios',
            'totalTatuadores',
            'totalGaleria',
            'proximosAgendamentos',
            'tatuadoresDestaque',
            'receitaMes'
        ));
    }
}
