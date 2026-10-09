@extends('layouts.app')

@section('title', $funcionario->nome)
@section('page-title', $funcionario->nome)

@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Dashboard</a>
    <span>/</span>
    <a href="{{ route('funcionarios.index') }}">Funcionários</a>
    <span>/</span>
    <span style="color:#e8e8f0;">{{ $funcionario->nome }}</span>
@endsection

@section('content')

<!-- Header do Perfil -->
<div class="card-gold" style="padding:32px;margin-bottom:24px;">
    <div style="display:flex;align-items:center;gap:28px;flex-wrap:wrap;">
        <!-- Avatar -->
        <div style="position:relative;">
            @if($funcionario->foto_perfil)
                <img src="{{ asset('storage/' . $funcionario->foto_perfil) }}" alt="{{ $funcionario->nome }}"
                    style="width:120px;height:120px;border-radius:50%;object-fit:cover;border:4px solid #d4a853;box-shadow:0 0 30px rgba(212,168,83,0.3);">
            @else
                <div style="width:120px;height:120px;border-radius:50%;background:linear-gradient(135deg,#252535,#1a1a28);border:4px solid #d4a853;display:flex;align-items:center;justify-content:center;font-size:2.5rem;font-weight:800;color:#d4a853;box-shadow:0 0 30px rgba(212,168,83,0.2);">
                    {{ strtoupper(substr($funcionario->nome, 0, 1)) }}
                </div>
            @endif
            <div style="position:absolute;bottom:4px;right:4px;width:22px;height:22px;border-radius:50%;background:{{ $funcionario->ativo ? '#22c55e' : '#ef4444' }};border:3px solid #0a0a0f;"></div>
        </div>

        <!-- Dados -->
        <div style="flex:1;">
            <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
                <h2 style="font-size:1.8rem;font-weight:800;color:#e8e8f0;">{{ $funcionario->nome }}</h2>
                <span class="badge {{ $funcionario->funcao === 'tatuador' ? 'badge-gold' : 'badge-blue' }}" style="font-size:0.8rem;">{{ $funcionario->funcao_label }}</span>
                <span class="badge {{ $funcionario->ativo ? 'badge-green' : 'badge-red' }}">{{ $funcionario->ativo ? 'Ativo' : 'Inativo' }}</span>
            </div>

            @if($funcionario->especialidade)
                <p style="color:#9898b8;margin-top:4px;font-size:1rem;">{{ $funcionario->especialidade }}</p>
            @endif

            @if($funcionario->bio)
                <p style="color:#6b6b8f;margin-top:8px;font-size:0.9rem;max-width:500px;">{{ $funcionario->bio }}</p>
            @endif

            <div style="display:flex;gap:20px;margin-top:16px;flex-wrap:wrap;">
                <div style="font-size:0.85rem;color:#9898b8;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:inline;vertical-align:middle;margin-right:4px;"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    Admitido em {{ $funcionario->data_admissao->format('d/m/Y') }}
                </div>
                <div style="font-size:0.85rem;color:#9898b8;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:inline;vertical-align:middle;margin-right:4px;"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    {{ $funcionario->idade }} anos
                </div>
                @if($funcionario->instagram)
                <div style="font-size:0.85rem;color:#9898b8;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:inline;vertical-align:middle;margin-right:4px;"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                    @{{ $funcionario->instagram }}
                </div>
                @endif
            </div>
        </div>

        <!-- Salary + Actions -->
        <div style="text-align:right;">
            <div style="font-size:0.75rem;color:#6b6b8f;margin-bottom:4px;">Salário</div>
            <div style="font-size:1.6rem;font-weight:800;color:#d4a853;">R$ {{ number_format($funcionario->salario, 2, ',', '.') }}</div>

            <div style="display:flex;gap:8px;margin-top:16px;justify-content:end;">
                <a href="{{ route('funcionarios.edit', $funcionario) }}" class="btn-secondary btn-sm">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    Editar
                </a>
                @if($funcionario->funcao === 'tatuador')
                <a href="{{ route('tatuadores.perfil', $funcionario) }}" class="btn-primary btn-sm">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    Ver Portfólio
                </a>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Estatísticas (só para tatuadores) -->
@if($funcionario->funcao === 'tatuador')
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:16px;margin-bottom:24px;">
    <div class="stat-card" style="text-align:center;">
        <div style="font-size:1.8rem;font-weight:800;color:#d4a853;">{{ $estatisticas['total_agendamentos'] }}</div>
        <div style="font-size:0.8rem;color:#6b6b8f;margin-top:4px;">Total de Agendamentos</div>
    </div>
    <div class="stat-card" style="text-align:center;">
        <div style="font-size:1.8rem;font-weight:800;color:#22c55e;">{{ $estatisticas['agendamentos_concluidos'] }}</div>
        <div style="font-size:0.8rem;color:#6b6b8f;margin-top:4px;">Concluídos</div>
    </div>
    <div class="stat-card" style="text-align:center;">
        <div style="font-size:1.8rem;font-weight:800;color:#eab308;">{{ $estatisticas['agendamentos_pendentes'] }}</div>
        <div style="font-size:0.8rem;color:#6b6b8f;margin-top:4px;">Pendentes</div>
    </div>
    <div class="stat-card" style="text-align:center;">
        <div style="font-size:1.8rem;font-weight:800;color:#a855f7;">{{ $estatisticas['total_galeria'] }}</div>
        <div style="font-size:0.8rem;color:#6b6b8f;margin-top:4px;">Na Galeria</div>
    </div>
    <div class="stat-card" style="text-align:center;">
        <div style="font-size:1.2rem;font-weight:800;color:#d4a853;">R$ {{ number_format($estatisticas['receita_total'], 0, ',', '.') }}</div>
        <div style="font-size:0.8rem;color:#6b6b8f;margin-top:4px;">Receita Gerada</div>
    </div>
    <div class="stat-card" style="text-align:center;">
        <div style="font-size:1.8rem;font-weight:800;color:#f97316;">★ {{ number_format($estatisticas['media_resultado'], 1) }}</div>
        <div style="font-size:0.8rem;color:#6b6b8f;margin-top:4px;">Avaliação Resultado</div>
    </div>
</div>
@endif

<div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">

    <!-- Agendamentos recentes -->
    <div class="card" style="padding:24px;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
            <h3 style="font-weight:700;color:#e8e8f0;">Agendamentos Recentes</h3>
            <a href="{{ route('agendamentos.index', ['tatuador' => $funcionario->id]) }}" style="font-size:0.8rem;color:#d4a853;text-decoration:none;">Ver todos →</a>
        </div>

        @if($funcionario->agendamentos->isEmpty())
            <div style="text-align:center;padding:24px;color:#4a4a6a;">Nenhum agendamento ainda</div>
        @else
            <div style="display:flex;flex-direction:column;gap:10px;">
                @foreach($funcionario->agendamentos as $ag)
                <div style="display:flex;justify-content:space-between;align-items:center;padding:10px 12px;background:#1a1a28;border-radius:8px;">
                    <div>
                        <div style="font-weight:500;color:#e8e8f0;font-size:0.9rem;">{{ $ag->nome_cliente }}</div>
                        <div style="font-size:0.78rem;color:#6b6b8f;">{{ $ag->data_agendamento->format('d/m/Y') }} · {{ $ag->hora_agendamento }}</div>
                    </div>
                    <span class="badge badge-{{ $ag->status_color }}">{{ $ag->status_label }}</span>
                </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Galeria recente -->
    <div class="card" style="padding:24px;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
            <h3 style="font-weight:700;color:#e8e8f0;">Galeria Recente</h3>
            @if($funcionario->funcao === 'tatuador')
                <a href="{{ route('tatuadores.perfil', $funcionario) }}" style="font-size:0.8rem;color:#d4a853;text-decoration:none;">Ver tudo →</a>
            @endif
        </div>

        @if($funcionario->galerias->isEmpty())
            <div style="text-align:center;padding:24px;color:#4a4a6a;">Nenhum trabalho na galeria</div>
        @else
            <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:8px;">
                @foreach($funcionario->galerias->take(9) as $galeria)
                <a href="{{ route('galerias.show', $galeria) }}" style="display:block;aspect-ratio:1;border-radius:8px;overflow:hidden;border:1px solid #252535;transition:transform 0.2s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                    <img src="{{ asset('storage/' . $galeria->imagem_tatuagem) }}" alt="Tatuagem" style="width:100%;height:100%;object-fit:cover;">
                </a>
                @endforeach
            </div>
        @endif
    </div>

</div>

@endsection
