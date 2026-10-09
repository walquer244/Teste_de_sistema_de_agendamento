@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

<!-- Stats Grid -->
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:20px;margin-bottom:32px;">

    <div class="stat-card" style="border-left:3px solid #d4a853;">
        <div style="display:flex;justify-content:space-between;align-items:start;">
            <div>
                <div style="font-size:0.8rem;color:#6b6b8f;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:8px;">Total Agendamentos</div>
                <div style="font-size:2.2rem;font-weight:800;color:#e8e8f0;line-height:1;">{{ $totalAgendamentos }}</div>
                <div style="font-size:0.8rem;color:#6b6b8f;margin-top:6px;">Todos os registros</div>
            </div>
            <div style="width:48px;height:48px;background:rgba(212,168,83,0.1);border-radius:12px;display:flex;align-items:center;justify-content:center;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#d4a853" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
        </div>
    </div>

    <div class="stat-card" style="border-left:3px solid #3b82f6;">
        <div style="display:flex;justify-content:space-between;align-items:start;">
            <div>
                <div style="font-size:0.8rem;color:#6b6b8f;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:8px;">Agendamentos Hoje</div>
                <div style="font-size:2.2rem;font-weight:800;color:#e8e8f0;line-height:1;">{{ $agendamentosHoje }}</div>
                <div style="font-size:0.8rem;color:#6b6b8f;margin-top:6px;">{{ now()->format('d/m/Y') }}</div>
            </div>
            <div style="width:48px;height:48px;background:rgba(59,130,246,0.1);border-radius:12px;display:flex;align-items:center;justify-content:center;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
        </div>
    </div>

    <div class="stat-card" style="border-left:3px solid #eab308;">
        <div style="display:flex;justify-content:space-between;align-items:start;">
            <div>
                <div style="font-size:0.8rem;color:#6b6b8f;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:8px;">Pendentes</div>
                <div style="font-size:2.2rem;font-weight:800;color:#e8e8f0;line-height:1;">{{ $agendamentosPendentes }}</div>
                <div style="font-size:0.8rem;color:#6b6b8f;margin-top:6px;">Aguardando confirmação</div>
            </div>
            <div style="width:48px;height:48px;background:rgba(234,179,8,0.1);border-radius:12px;display:flex;align-items:center;justify-content:center;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#eab308" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12"/></svg>
            </div>
        </div>
    </div>

    <div class="stat-card" style="border-left:3px solid #22c55e;">
        <div style="display:flex;justify-content:space-between;align-items:start;">
            <div>
                <div style="font-size:0.8rem;color:#6b6b8f;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:8px;">Concluídos</div>
                <div style="font-size:2.2rem;font-weight:800;color:#e8e8f0;line-height:1;">{{ $agendamentosConcluidos }}</div>
                <div style="font-size:0.8rem;color:#6b6b8f;margin-top:6px;">Serviços realizados</div>
            </div>
            <div style="width:48px;height:48px;background:rgba(34,197,94,0.1);border-radius:12px;display:flex;align-items:center;justify-content:center;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
        </div>
    </div>

    <div class="stat-card" style="border-left:3px solid #a855f7;">
        <div style="display:flex;justify-content:space-between;align-items:start;">
            <div>
                <div style="font-size:0.8rem;color:#6b6b8f;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:8px;">Tatuadores</div>
                <div style="font-size:2.2rem;font-weight:800;color:#e8e8f0;line-height:1;">{{ $totalTatuadores }}</div>
                <div style="font-size:0.8rem;color:#6b6b8f;margin-top:6px;">{{ $totalFuncionarios }} funcionários total</div>
            </div>
            <div style="width:48px;height:48px;background:rgba(168,85,247,0.1);border-radius:12px;display:flex;align-items:center;justify-content:center;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#a855f7" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
        </div>
    </div>

    <div class="stat-card" style="border-left:3px solid #f97316;">
        <div style="display:flex;justify-content:space-between;align-items:start;">
            <div>
                <div style="font-size:0.8rem;color:#6b6b8f;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:8px;">Receita do Mês</div>
                <div style="font-size:2rem;font-weight:800;color:#e8e8f0;line-height:1;">R$ {{ number_format($receitaMes, 0, ',', '.') }}</div>
                <div style="font-size:0.8rem;color:#6b6b8f;margin-top:6px;">{{ now()->format('F Y') }}</div>
            </div>
            <div style="width:48px;height:48px;background:rgba(249,115,22,0.1);border-radius:12px;display:flex;align-items:center;justify-content:center;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#f97316" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
            </div>
        </div>
    </div>

</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">

    <!-- Próximos Agendamentos -->
    <div class="card" style="padding:24px;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
            <h2 style="font-size:1rem;font-weight:700;color:#e8e8f0;">📅 Próximos Agendamentos</h2>
            <a href="{{ route('agendamentos.index') }}" style="font-size:0.8rem;color:#d4a853;text-decoration:none;">Ver todos →</a>
        </div>

        @if($proximosAgendamentos->isEmpty())
            <div style="text-align:center;padding:32px 0;color:#4a4a6a;">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin:0 auto 12px;display:block;"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                Nenhum agendamento futuro
            </div>
        @else
            <div style="display:flex;flex-direction:column;gap:12px;">
                @foreach($proximosAgendamentos as $ag)
                <div style="display:flex;align-items:center;gap:14px;padding:12px;border-radius:10px;background:#1a1a28;transition:background 0.2s;" onmouseover="this.style.background='#252535'" onmouseout="this.style.background='#1a1a28'">
                    <div style="flex-shrink:0;text-align:center;background:#0a0a0f;border-radius:8px;padding:8px 10px;min-width:50px;">
                        <div style="font-size:1.1rem;font-weight:800;color:#d4a853;line-height:1;">{{ $ag->data_agendamento->format('d') }}</div>
                        <div style="font-size:0.65rem;color:#6b6b8f;text-transform:uppercase;">{{ $ag->data_agendamento->format('M') }}</div>
                    </div>
                    <div style="flex:1;min-width:0;">
                        <div style="font-weight:600;color:#e8e8f0;font-size:0.9rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $ag->nome_cliente }}</div>
                        <div style="font-size:0.8rem;color:#6b6b8f;">{{ $ag->hora_agendamento }} · {{ $ag->funcionario->nome }}</div>
                    </div>
                    <span class="badge badge-{{ $ag->status_color }}">{{ $ag->status_label }}</span>
                </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Top Tatuadores -->
    <div class="card" style="padding:24px;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
            <h2 style="font-size:1rem;font-weight:700;color:#e8e8f0;">🏆 Top Tatuadores</h2>
            <a href="{{ route('funcionarios.index') }}" style="font-size:0.8rem;color:#d4a853;text-decoration:none;">Ver todos →</a>
        </div>

        @if($tatuadoresDestaque->isEmpty())
            <div style="text-align:center;padding:32px 0;color:#4a4a6a;">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin:0 auto 12px;display:block;"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                Nenhum tatuador cadastrado
            </div>
        @else
            <div style="display:flex;flex-direction:column;gap:16px;">
                @foreach($tatuadoresDestaque as $i => $tatuador)
                <div style="display:flex;align-items:center;gap:14px;">
                    <div style="font-size:1.1rem;font-weight:800;color:{{ $i === 0 ? '#d4a853' : ($i === 1 ? '#9898b8' : '#b8902e') }};width:24px;text-align:center;">#{{ $i + 1 }}</div>
                    @if($tatuador->foto_perfil)
                        <img src="{{ asset('storage/' . $tatuador->foto_perfil) }}" alt="{{ $tatuador->nome }}" class="avatar" style="width:44px;height:44px;">
                    @else
                        <div class="avatar-placeholder" style="width:44px;height:44px;font-size:1rem;">{{ strtoupper(substr($tatuador->nome, 0, 1)) }}</div>
                    @endif
                    <div style="flex:1;">
                        <div style="font-weight:600;color:#e8e8f0;font-size:0.9rem;">{{ $tatuador->nome }}</div>
                        <div style="font-size:0.8rem;color:#6b6b8f;">{{ $tatuador->especialidade ?? 'Tatuador(a)' }}</div>
                    </div>
                    <div style="text-align:right;">
                        <div style="font-size:1rem;font-weight:700;color:#d4a853;">{{ $tatuador->agendamentos_count }}</div>
                        <div style="font-size:0.7rem;color:#6b6b8f;">concluídos</div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>

</div>

<!-- Quick actions -->
<div style="margin-top:24px;display:flex;gap:12px;flex-wrap:wrap;">
    <a href="{{ route('agendamentos.create') }}" class="btn-primary">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Novo Agendamento
    </a>
    <a href="{{ route('funcionarios.create') }}" class="btn-secondary">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
        Novo Funcionário
    </a>
    <a href="{{ route('galerias.create') }}" class="btn-secondary">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
        Adicionar à Galeria
    </a>
</div>

@endsection
