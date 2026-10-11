@extends('layouts.app')

@section('title', 'Galeria de Trabalhos')
@section('page-title', 'Galeria de Trabalhos')

@section('content')

<div class="page-header" style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:16px;">
    <div>
        <h1>Galeria de Tatuagens</h1>
        <p>Portfólio de artes concluídas, avaliações dos clientes e trabalhos em destaque</p>
    </div>
    <a href="{{ route('galerias.create') }}" class="btn-primary">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Adicionar Trabalho
    </a>
</div>

<!-- Filtros -->
<div class="card" style="padding:20px;margin-bottom:28px;">
    <form method="GET" action="{{ route('galerias.index') }}" style="display:flex;gap:12px;flex-wrap:wrap;align-items:end;">
        <div style="flex:1;min-width:200px;">
            <label class="form-label">Buscar por cliente</label>
            <input type="text" name="busca" value="{{ request('busca') }}" placeholder="Nome do cliente..." class="form-input">
        </div>
        <div style="min-width:180px;">
            <label class="form-label">Estilo</label>
            <select name="estilo" class="form-select">
                <option value="">Todos os estilos</option>
                @foreach($estilos as $estilo)
                    <option value="{{ $estilo }}" {{ request('estilo') === $estilo ? 'selected' : '' }}>
                        {{ ucfirst(str_replace('_', ' ', $estilo)) }}
                    </option>
                @endforeach
            </select>
        </div>
        <div style="min-width:180px;">
            <label class="form-label">Tatuador</label>
            <select name="tatuador" class="form-select">
                <option value="">Todos os tatuadores</option>
                @foreach($tatuadores as $t)
                    <option value="{{ $t->id }}" {{ request('tatuador') == $t->id ? 'selected' : '' }}>{{ $t->nome }}</option>
                @endforeach
            </select>
        </div>
        <div style="display:flex;align-items:center;gap:8px;padding-bottom:12px;">
            <input type="checkbox" name="destaque" id="destaque" value="1" {{ request('destaque') ? 'checked' : '' }} style="accent-color:#d4a853;width:18px;height:18px;">
            <label for="destaque" class="form-label" style="margin:0;cursor:pointer;">Apenas Destaques</label>
        </div>
        <button type="submit" class="btn-primary">Filtrar</button>
        @if(request()->anyFilled(['busca', 'estilo', 'tatuador', 'destaque']))
            <a href="{{ route('galerias.index') }}" class="btn-secondary">Limpar</a>
        @endif
    </form>
</div>

<!-- Grid de Trabalhos -->
<div class="gallery-grid">
    @forelse($galerias as $item)
        <div class="gallery-card">
            <!-- Imagem da Tatuagem -->
            <a href="{{ route('galerias.show', $item) }}" style="display:block;position:relative;">
                <img src="{{ $item->imagem_tatuagem_url }}" alt="Tatuagem por {{ $item->funcionario->nome ?? 'Artista' }}" loading="lazy">
                @if($item->destaque)
                    <div style="position:absolute;top:12px;left:12px;background:linear-gradient(135deg,#d4a853,#b8902e);color:#0a0a0f;padding:4px 10px;border-radius:20px;font-size:0.75rem;font-weight:700;display:flex;align-items:center;gap:4px;box-shadow:0 4px 12px rgba(0,0,0,0.5);">
                        ★ DESTAQUE
                    </div>
                @endif
                <div style="position:absolute;top:12px;right:12px;background:rgba(10,10,15,0.75);backdrop-filter:blur(8px);border:1px solid #252535;color:#e8e8f0;padding:4px 10px;border-radius:20px;font-size:0.75rem;font-weight:600;">
                    {{ $item->estilo_label }}
                </div>
            </a>

            <!-- Informações & Avaliação -->
            <div style="padding:18px;background:#12121a;">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
                    <div style="display:flex;align-items:center;gap:10px;">
                        <img src="{{ $item->foto_perfil_cliente_url }}" alt="{{ $item->nome_cliente }}" class="avatar" style="width:34px;height:34px;">
                        <div>
                            <div style="font-weight:600;font-size:0.95rem;color:#e8e8f0;">{{ $item->nome_cliente }}</div>
                            <div style="font-size:0.8rem;color:#6b6b8f;">
                                Por <a href="{{ route('tatuadores.perfil', $item->funcionario_id) }}" style="color:#d4a853;text-decoration:none;">{{ $item->funcionario->nome ?? 'Artista' }}</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Avaliação em Estrelas -->
                <div style="display:flex;align-items:center;justify-content:space-between;border-top:1px solid #1a1a28;padding-top:12px;margin-top:12px;">
                    <div style="display:flex;align-items:center;gap:4px;">
                        @for($i = 1; $i <= 5; $i++)
                            <span class="star {{ $i <= $item->media_avaliacoes ? 'filled' : '' }}" style="font-size:0.95rem;">★</span>
                        @endfor
                        <span style="font-size:0.8rem;color:#d4a853;margin-left:4px;font-weight:600;">{{ $item->media_avaliacoes }}</span>
                    </div>

                    <div style="display:flex;gap:6px;">
                        <a href="{{ route('galerias.show', $item) }}" class="btn-secondary btn-sm" title="Ver detalhes">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </a>
                        <a href="{{ route('galerias.edit', $item) }}" class="btn-secondary btn-sm" title="Editar">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="card" style="grid-column:1/-1;text-align:center;padding:56px 20px;">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#4a4a6a" stroke-width="1.5" style="margin:0 auto 16px;"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
            <h3 style="color:#e8e8f0;font-size:1.1rem;margin-bottom:8px;">Nenhum trabalho na galeria ainda</h3>
            <p style="color:#6b6b8f;font-size:0.9rem;margin-bottom:20px;">Publique novos trabalhos finalizados para compor o portfólio dos tatuadores.</p>
            <a href="{{ route('galerias.create') }}" class="btn-primary">Adicionar Primeiro Trabalho</a>
        </div>
    @endforelse
</div>

@if($galerias->hasPages())
    <div class="pagination">
        {{ $galerias->links() }}
    </div>
@endif

@endsection
