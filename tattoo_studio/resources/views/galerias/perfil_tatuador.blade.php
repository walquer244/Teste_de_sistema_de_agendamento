@extends('layouts.app')

@section('title', 'Perfil de ' . $funcionario->nome)
@section('page-title', 'Portfólio do Tatuador')

@section('content')

<div class="breadcrumb">
    <a href="{{ route('dashboard') }}">Dashboard</a>
    <span>/</span>
    <a href="{{ route('funcionarios.index') }}">Tatuadores</a>
    <span>/</span>
    <span style="color:#e8e8f0;">{{ $funcionario->nome }}</span>
</div>

<!-- Artist Hero Card -->
<div class="card" style="padding:32px;margin-bottom:32px;background:linear-gradient(135deg, #12121a 0%, #1a1a28 100%);border:1px solid rgba(212,168,83,0.25);">
    <div style="display:flex;align-items:center;gap:24px;flex-wrap:wrap;">
        <img src="{{ $funcionario->foto_perfil_url }}" alt="{{ $funcionario->nome }}" class="avatar" style="width:96px;height:96px;border:3px solid #d4a853;">
        <div style="flex:1;min-width:260px;">
            <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
                <h1 style="font-size:2rem;font-weight:800;color:#e8e8f0;margin:0;">{{ $funcionario->nome }}</h1>
                <span class="badge badge-gold" style="font-size:0.8rem;">{{ $funcionario->especialidade ?? 'Tatuador' }}</span>
                @if($funcionario->ativo)
                    <span class="badge badge-green">Disponível</span>
                @else
                    <span class="badge badge-red">Indisponível</span>
                @endif
            </div>

            @if($funcionario->bio)
                <p style="color:#c4c4d8;margin-top:10px;font-size:0.95rem;line-height:1.5;max-width:700px;">
                    {{ $funcionario->bio }}
                </p>
            @endif

            <div style="display:flex;align-items:center;gap:20px;margin-top:14px;font-size:0.85rem;color:#9898b8;flex-wrap:wrap;">
                @if($funcionario->instagram)
                    <span style="display:flex;align-items:center;gap:6px;color:#d4a853;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                        {{ $funcionario->instagram }}
                    </span>
                @endif
                <span>Admissão: {{ \Carbon\Carbon::parse($funcionario->data_admissao)->format('d/m/Y') }}</span>
                <span>{{ $funcionario->idade }} anos</span>
            </div>
        </div>

        <div style="display:flex;flex-direction:column;gap:10px;">
            <a href="{{ route('agendamentos.create') }}?funcionario_id={{ $funcionario->id }}" class="btn-primary">
                + Novo Agendamento
            </a>
            <a href="{{ route('galerias.create') }}?funcionario_id={{ $funcionario->id }}" class="btn-secondary">
                + Adicionar à Galeria
            </a>
        </div>
    </div>
</div>

<!-- Estatísticas do Tatuador -->
<div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(200px, 1fr));gap:16px;margin-bottom:32px;">
    <div class="stat-card">
        <div style="font-size:0.8rem;color:#6b6b8f;text-transform:uppercase;">Trabalhos no Portfólio</div>
        <div style="font-size:1.8rem;font-weight:800;color:#e8e8f0;margin-top:6px;">{{ $estatisticas['total_trabalhos'] }}</div>
    </div>
    <div class="stat-card">
        <div style="font-size:0.8rem;color:#6b6b8f;text-transform:uppercase;">Média Atendimento</div>
        <div style="font-size:1.8rem;font-weight:800;color:#d4a853;margin-top:6px;display:flex;align-items:center;gap:6px;">
            ★ {{ $estatisticas['media_atendimento'] ?: '5.0' }}
        </div>
    </div>
    <div class="stat-card">
        <div style="font-size:0.8rem;color:#6b6b8f;text-transform:uppercase;">Média Resultado</div>
        <div style="font-size:1.8rem;font-weight:800;color:#d4a853;margin-top:6px;display:flex;align-items:center;gap:6px;">
            ★ {{ $estatisticas['media_resultado'] ?: '5.0' }}
        </div>
    </div>
    <div class="stat-card">
        <div style="font-size:0.8rem;color:#6b6b8f;text-transform:uppercase;">Estilos Praticados</div>
        <div style="font-size:1.8rem;font-weight:800;color:#e8e8f0;margin-top:6px;">{{ count($estatisticas['estilos']) }}</div>
    </div>
</div>

<!-- Seção da Galeria -->
<div class="page-header" style="margin-bottom:20px;">
    <h2>Trabalhos Realizados ({{ $galerias->count() }})</h2>
    <p>Obras finalizadas e registradas no estúdio por {{ $funcionario->nome }}</p>
</div>

<div class="gallery-grid" style="margin-bottom:40px;">
    @forelse($galerias as $item)
        <div class="gallery-card">
            <a href="{{ route('galerias.show', $item) }}" style="display:block;position:relative;">
                <img src="{{ $item->imagem_tatuagem_url }}" alt="Tatuagem" loading="lazy">
                @if($item->destaque)
                    <div style="position:absolute;top:10px;left:10px;background:linear-gradient(135deg,#d4a853,#b8902e);color:#0a0a0f;padding:4px 8px;border-radius:20px;font-size:0.7rem;font-weight:700;">
                        ★ DESTAQUE
                    </div>
                @endif
                <div style="position:absolute;top:10px;right:10px;background:rgba(10,10,15,0.8);backdrop-filter:blur(8px);border:1px solid #252535;color:#e8e8f0;padding:3px 8px;border-radius:20px;font-size:0.7rem;">
                    {{ $item->estilo_label }}
                </div>
            </a>
            <div style="padding:16px;background:#12121a;">
                <div style="font-weight:600;color:#e8e8f0;font-size:0.95rem;">{{ $item->nome_cliente }}</div>
                @if($item->comentario)
                    <p style="font-size:0.8rem;color:#9898b8;margin-top:6px;line-height:1.4;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                        “{{ $item->comentario }}”
                    </p>
                @endif
                <div style="display:flex;align-items:center;justify-content:space-between;margin-top:12px;border-top:1px solid #1a1a28;padding-top:10px;">
                    <div style="display:flex;align-items:center;gap:3px;">
                        @for($i = 1; $i <= 5; $i++)
                            <span class="star {{ $i <= $item->media_avaliacoes ? 'filled' : '' }}" style="font-size:0.85rem;">★</span>
                        @endfor
                    </div>
                    <a href="{{ route('galerias.show', $item) }}" style="font-size:0.8rem;color:#d4a853;text-decoration:none;">
                        Ver Detalhes →
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="card" style="grid-column:1/-1;text-align:center;padding:48px 20px;">
            <p style="color:#6b6b8f;margin-bottom:16px;">Nenhum trabalho cadastrado para este tatuador ainda.</p>
            <a href="{{ route('galerias.create') }}?funcionario_id={{ $funcionario->id }}" class="btn-primary">
                Adicionar Trabalho
            </a>
        </div>
    @endforelse
</div>

<!-- Agendamentos Concluídos Prontos para Galeria -->
@if($agendamentosConcluidos->isNotEmpty())
    <div class="card" style="padding:28px;margin-top:24px;">
        <h3 style="color:#d4a853;font-size:1.1rem;margin-bottom:8px;">Importar Sessões Concluídas em Lote</h3>
        <p style="font-size:0.85rem;color:#9898b8;margin-bottom:20px;">
            Selecione sessões que possuem fotos anexadas para publicar diretamente na galeria do tatuador.
        </p>

        <form action="{{ route('tatuadores.importar-galeria', $funcionario) }}" method="POST">
            @csrf
            <div style="display:flex;flex-direction:column;gap:10px;margin-bottom:20px;">
                @foreach($agendamentosConcluidos as $ag)
                    @if(!$ag->galeria)
                        <label style="display:flex;align-items:center;gap:12px;padding:12px;background:#1a1a28;border-radius:10px;cursor:pointer;">
                            <input type="checkbox" name="agendamentos[]" value="{{ $ag->id }}" style="accent-color:#d4a853;width:18px;height:18px;">
                            <div style="flex:1;">
                                <span style="color:#e8e8f0;font-weight:600;">{{ $ag->nome_cliente }}</span>
                                <span style="color:#6b6b8f;font-size:0.85rem;"> - {{ \Carbon\Carbon::parse($ag->data_agendamento)->format('d/m/Y') }} ({{ $ag->descricao_tatuagem ?? 'Tatuagem' }})</span>
                            </div>
                            @if($ag->imagem_tatuagem)
                                <span class="badge badge-green">Com Foto</span>
                            @else
                                <span class="badge badge-yellow">Sem Foto</span>
                            @endif
                        </label>
                    @endif
                @endforeach
            </div>

            <button type="submit" class="btn-primary">Importar Selecionados para Galeria</button>
        </form>
    </div>
@endif

@endsection
