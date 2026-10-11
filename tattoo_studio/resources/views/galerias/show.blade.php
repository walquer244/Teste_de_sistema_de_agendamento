@extends('layouts.app')

@section('title', 'Detalhes do Trabalho')
@section('page-title', 'Detalhes do Trabalho')

@section('content')

<div class="breadcrumb">
    <a href="{{ route('dashboard') }}">Dashboard</a>
    <span>/</span>
    <a href="{{ route('galerias.index') }}">Galeria</a>
    <span>/</span>
    <span style="color:#e8e8f0;">Trabalho #{{ $galeria->id }}</span>
</div>

<div class="page-header" style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:16px;">
    <div>
        <h1>{{ $galeria->estilo_label }} por {{ $galeria->funcionario->nome ?? 'Artista' }}</h1>
        <p>Cliente: {{ $galeria->nome_cliente }}</p>
    </div>
    <div style="display:flex;gap:10px;">
        <a href="{{ route('galerias.edit', $galeria) }}" class="btn-primary">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            Editar Trabalho
        </a>
        <form action="{{ route('galerias.destroy', $galeria) }}" method="POST" onsubmit="return confirm('Deseja excluir este trabalho da galeria?');" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-danger">Excluir</button>
        </form>
        <a href="{{ route('galerias.index') }}" class="btn-secondary">Voltar</a>
    </div>
</div>

<div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(340px, 1fr));gap:28px;">
    <!-- Foto Principal -->
    <div class="card" style="padding:16px;overflow:hidden;">
        <img src="{{ $galeria->imagem_tatuagem_url }}" alt="Tatuagem" style="width:100%;max-height:500px;object-fit:cover;border-radius:12px;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-top:16px;padding:0 8px;">
            <div style="display:flex;gap:8px;">
                <span class="badge badge-gold">{{ $galeria->estilo_label }}</span>
                @if($galeria->destaque)
                    <span class="badge badge-yellow">★ Destaque</span>
                @endif
            </div>
            <div style="font-size:0.8rem;color:#6b6b8f;">
                Publicado em {{ $galeria->created_at->format('d/m/Y') }}
            </div>
        </div>
    </div>

    <!-- Informações e Avaliações -->
    <div style="display:flex;flex-direction:column;gap:24px;">
        <!-- Card do Artista -->
        <div class="card" style="padding:24px;">
            <h3 style="color:#6b6b8f;font-size:0.8rem;text-transform:uppercase;margin-bottom:12px;">Tatuador(a)</h3>
            <div style="display:flex;align-items:center;gap:16px;">
                <img src="{{ $galeria->funcionario->foto_perfil_url }}" alt="{{ $galeria->funcionario->nome }}" class="avatar" style="width:52px;height:52px;">
                <div>
                    <h2 style="font-size:1.2rem;font-weight:700;color:#e8e8f0;margin:0;">
                        <a href="{{ route('tatuadores.perfil', $galeria->funcionario_id) }}" style="color:#d4a853;text-decoration:none;">
                            {{ $galeria->funcionario->nome }}
                        </a>
                    </h2>
                    <div style="font-size:0.85rem;color:#9898b8;margin-top:2px;">{{ $galeria->funcionario->especialidade ?? 'Tatuador' }}</div>
                    @if($galeria->funcionario->instagram)
                        <div style="font-size:0.8rem;color:#6b6b8f;margin-top:4px;">{{ $galeria->funcionario->instagram }}</div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Card do Cliente -->
        <div class="card" style="padding:24px;">
            <h3 style="color:#6b6b8f;font-size:0.8rem;text-transform:uppercase;margin-bottom:12px;">Cliente</h3>
            <div style="display:flex;align-items:center;gap:14px;">
                <img src="{{ $galeria->foto_perfil_cliente_url }}" alt="{{ $galeria->nome_cliente }}" class="avatar" style="width:44px;height:44px;">
                <div>
                    <div style="font-size:1.1rem;font-weight:600;color:#e8e8f0;">{{ $galeria->nome_cliente }}</div>
                    @if($galeria->agendamento_id)
                        <a href="{{ route('agendamentos.show', $galeria->agendamento_id) }}" style="font-size:0.8rem;color:#d4a853;text-decoration:none;">
                            Ver agendamento de origem (#{{ $galeria->agendamento_id }}) →
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Card de Avaliação -->
        <div class="card" style="padding:24px;">
            <h3 style="color:#d4a853;font-size:1.05rem;margin-bottom:16px;display:flex;align-items:center;gap:8px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                Avaliação do Cliente
            </h3>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:18px;">
                <div style="background:#1a1a28;padding:14px;border-radius:10px;border:1px solid #252535;">
                    <div style="font-size:0.75rem;color:#6b6b8f;text-transform:uppercase;">Atendimento</div>
                    <div style="display:flex;align-items:center;gap:4px;margin-top:6px;">
                        @for($i = 1; $i <= 5; $i++)
                            <span class="star {{ $i <= $galeria->avaliacao_atendimento ? 'filled' : '' }}" style="font-size:0.9rem;">★</span>
                        @endfor
                        <span style="font-size:0.85rem;color:#d4a853;font-weight:600;margin-left:4px;">{{ $galeria->avaliacao_atendimento }}/5</span>
                    </div>
                </div>

                <div style="background:#1a1a28;padding:14px;border-radius:10px;border:1px solid #252535;">
                    <div style="font-size:0.75rem;color:#6b6b8f;text-transform:uppercase;">Resultado Final</div>
                    <div style="display:flex;align-items:center;gap:4px;margin-top:6px;">
                        @for($i = 1; $i <= 5; $i++)
                            <span class="star {{ $i <= $galeria->avaliacao_resultado ? 'filled' : '' }}" style="font-size:0.9rem;">★</span>
                        @endfor
                        <span style="font-size:0.85rem;color:#d4a853;font-weight:600;margin-left:4px;">{{ $galeria->avaliacao_resultado }}/5</span>
                    </div>
                </div>
            </div>

            @if($galeria->comentario)
                <div style="background:#1a1a28;padding:18px;border-radius:12px;border:1px solid rgba(212,168,83,0.15);position:relative;">
                    <div style="font-size:1.6rem;color:#d4a853;opacity:0.3;line-height:1;position:absolute;top:10px;left:14px;">“</div>
                    <p style="font-style:italic;color:#e8e8f0;font-size:0.95rem;line-height:1.6;margin:0;padding-left:18px;">
                        {{ $galeria->comentario }}
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
