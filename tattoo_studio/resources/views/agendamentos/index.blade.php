@extends('layouts.app')

@section('title', 'Agendamentos')
@section('page-title', 'Agendamentos')

@section('content')

<div class="page-header" style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:16px;">
    <div>
        <h1>Agendamentos</h1>
        <p>Gerencie as sessões, procedimentos e horários do estúdio</p>
    </div>
    <a href="{{ route('agendamentos.create') }}" class="btn-primary">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Novo Agendamento
    </a>
</div>

<!-- Filtros -->
<div class="card" style="padding:20px;margin-bottom:24px;">
    <form method="GET" action="{{ route('agendamentos.index') }}" style="display:flex;gap:12px;flex-wrap:wrap;align-items:end;">
        <div style="flex:1;min-width:200px;">
            <label class="form-label">Buscar por cliente</label>
            <input type="text" name="busca" value="{{ request('busca') }}" placeholder="Nome do cliente..." class="form-input">
        </div>
        <div style="min-width:160px;">
            <label class="form-label">Tatuador</label>
            <select name="tatuador" class="form-select">
                <option value="">Todos os tatuadores</option>
                @foreach($tatuadores as $t)
                    <option value="{{ $t->id }}" {{ request('tatuador') == $t->id ? 'selected' : '' }}>{{ $t->nome }}</option>
                @endforeach
            </select>
        </div>
        <div style="min-width:140px;">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="">Todos os status</option>
                <option value="pendente" {{ request('status') === 'pendente' ? 'selected' : '' }}>Pendente</option>
                <option value="confirmado" {{ request('status') === 'confirmado' ? 'selected' : '' }}>Confirmado</option>
                <option value="concluido" {{ request('status') === 'concluido' ? 'selected' : '' }}>Concluído</option>
                <option value="cancelado" {{ request('status') === 'cancelado' ? 'selected' : '' }}>Cancelado</option>
            </select>
        </div>
        <div style="min-width:140px;">
            <label class="form-label">Data</label>
            <input type="date" name="data" value="{{ request('data') }}" class="form-input">
        </div>
        <button type="submit" class="btn-primary">Filtrar</button>
        @if(request()->anyFilled(['busca', 'tatuador', 'status', 'data']))
            <a href="{{ route('agendamentos.index') }}" class="btn-secondary">Limpar</a>
        @endif
    </form>
</div>

<!-- Tabela de Agendamentos -->
<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Tatuador</th>
                <th>Data & Horário</th>
                <th>Procedimento</th>
                <th>Valor / Pagto</th>
                <th>Status</th>
                <th style="text-align:right;">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($agendamentos as $agendamento)
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:12px;">
                            <img src="{{ $agendamento->foto_perfil_url }}" alt="{{ $agendamento->nome_cliente }}" class="avatar" style="width:40px;height:40px;">
                            <div>
                                <div style="font-weight:600;color:#e8e8f0;">{{ $agendamento->nome_cliente }}</div>
                                <div style="font-size:0.8rem;color:#6b6b8f;">
                                    {{ $agendamento->idade_cliente }} anos
                                    @if($agendamento->telefone) • {{ $agendamento->telefone }} @endif
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div style="display:flex;align-items:center;gap:8px;">
                            <div style="width:8px;height:8px;border-radius:50%;background:#d4a853;"></div>
                            <span style="font-weight:500;color:#c4c4d8;">{{ $agendamento->funcionario->nome ?? 'Não atribuído' }}</span>
                        </div>
                    </td>
                    <td>
                        <div style="font-weight:600;color:#e8e8f0;">{{ \Carbon\Carbon::parse($agendamento->data_agendamento)->format('d/m/Y') }}</div>
                        <div style="font-size:0.8rem;color:#d4a853;">{{ \Carbon\Carbon::parse($agendamento->hora_agendamento)->format('H:i') }}</div>
                    </td>
                    <td>
                        <div style="color:#c4c4d8;font-size:0.85rem;max-width:220px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            {{ $agendamento->descricao_tatuagem ?? 'Sem descrição' }}
                        </div>
                        <div style="font-size:0.75rem;color:#6b6b8f;">
                            {{ $agendamento->local_corpo ?? 'Local n/d' }} • {{ $agendamento->tamanho ?? 'Tamanho n/d' }}
                        </div>
                    </td>
                    <td>
                        <div style="font-weight:600;color:#e8e8f0;">
                            R$ {{ number_format($agendamento->valor_estimado ?? 0, 2, ',', '.') }}
                        </div>
                        <div style="font-size:0.75rem;color:#9898b8;">
                            {{ $agendamento->forma_pagamento_label }}
                            @if($agendamento->parcelas > 1) ({{ $agendamento->parcelas }}x) @endif
                        </div>
                    </td>
                    <td>
                        <span class="badge badge-{{ $agendamento->status_color }}">
                            {{ $agendamento->status_label }}
                        </span>
                    </td>
                    <td style="text-align:right;">
                        <div style="display:inline-flex;gap:6px;align-items:center;">
                            <a href="{{ route('agendamentos.show', $agendamento) }}" class="btn-secondary btn-sm" title="Visualizar Detalhes">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            </a>
                            <a href="{{ route('agendamentos.edit', $agendamento) }}" class="btn-secondary btn-sm" title="Editar">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </a>
                            <form action="{{ route('agendamentos.destroy', $agendamento) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja cancelar e excluir este agendamento?');" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-danger btn-sm" title="Excluir">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align:center;padding:48px 20px;color:#6b6b8f;">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#4a4a6a" stroke-width="1.5" style="margin:0 auto 12px;"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        <p style="font-size:1rem;color:#c4c4d8;margin-bottom:6px;">Nenhum agendamento encontrado</p>
                        <p style="font-size:0.85rem;">Tente ajustar os filtros ou crie um novo agendamento.</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($agendamentos->hasPages())
    <div class="pagination">
        {{ $agendamentos->links() }}
    </div>
@endif

@endsection
