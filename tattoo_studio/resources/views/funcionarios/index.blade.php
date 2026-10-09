@extends('layouts.app')

@section('title', 'Funcionários')
@section('page-title', 'Funcionários')

@section('content')

<div class="page-header" style="display:flex;justify-content:space-between;align-items:center;">
    <div>
        <h1>Equipe</h1>
        <p>Gerencie os funcionários do studio</p>
    </div>
    <a href="{{ route('funcionarios.create') }}" class="btn-primary">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Novo Funcionário
    </a>
</div>

<!-- Filtros -->
<div class="card" style="padding:20px;margin-bottom:24px;">
    <form method="GET" action="{{ route('funcionarios.index') }}" style="display:flex;gap:12px;flex-wrap:wrap;align-items:end;">
        <div style="flex:1;min-width:200px;">
            <label class="form-label">Buscar por nome</label>
            <input type="text" name="busca" value="{{ request('busca') }}" placeholder="Nome do funcionário..." class="form-input">
        </div>
        <div style="min-width:160px;">
            <label class="form-label">Função</label>
            <select name="funcao" class="form-select">
                <option value="">Todas as funções</option>
                <option value="tatuador" {{ request('funcao') === 'tatuador' ? 'selected' : '' }}>Tatuador(a)</option>
                <option value="atendente" {{ request('funcao') === 'atendente' ? 'selected' : '' }}>Atendente</option>
                <option value="gerente" {{ request('funcao') === 'gerente' ? 'selected' : '' }}>Gerente</option>
                <option value="auxiliar" {{ request('funcao') === 'auxiliar' ? 'selected' : '' }}>Auxiliar</option>
                <option value="recepcionista" {{ request('funcao') === 'recepcionista' ? 'selected' : '' }}>Recepcionista</option>
            </select>
        </div>
        <div style="min-width:140px;">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="">Todos</option>
                <option value="ativo" {{ request('status') === 'ativo' ? 'selected' : '' }}>Ativos</option>
                <option value="inativo" {{ request('status') === 'inativo' ? 'selected' : '' }}>Inativos</option>
            </select>
        </div>
        <button type="submit" class="btn-primary">Filtrar</button>
        @if(request()->anyFilled(['busca', 'funcao', 'status']))
            <a href="{{ route('funcionarios.index') }}" class="btn-secondary">Limpar</a>
        @endif
    </form>
</div>

<!-- Tabela -->
<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>Funcionário</th>
                <th>Função</th>
                <th>Idade</th>
                <th>Admissão</th>
                <th>Salário</th>
                <th>Agendamentos</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($funcionarios as $funcionario)
            <tr>
                <td>
                    <div style="display:flex;align-items:center;gap:12px;">
                        @if($funcionario->foto_perfil)
                            <img src="{{ asset('storage/' . $funcionario->foto_perfil) }}" alt="{{ $funcionario->nome }}" class="avatar" style="width:42px;height:42px;">
                        @else
                            <div class="avatar-placeholder" style="width:42px;height:42px;font-size:1rem;">{{ strtoupper(substr($funcionario->nome, 0, 1)) }}</div>
                        @endif
                        <div>
                            <div style="font-weight:600;color:#e8e8f0;">{{ $funcionario->nome }}</div>
                            @if($funcionario->especialidade)
                                <div style="font-size:0.78rem;color:#6b6b8f;">{{ $funcionario->especialidade }}</div>
                            @endif
                        </div>
                    </div>
                </td>
                <td>
                    <span class="badge {{ $funcionario->funcao === 'tatuador' ? 'badge-gold' : 'badge-blue' }}">
                        {{ $funcionario->funcao_label }}
                    </span>
                </td>
                <td>{{ $funcionario->idade }} anos</td>
                <td>{{ $funcionario->data_admissao->format('d/m/Y') }}</td>
                <td style="color:#d4a853;font-weight:600;">R$ {{ number_format($funcionario->salario, 2, ',', '.') }}</td>
                <td style="text-align:center;">
                    @if($funcionario->funcao === 'tatuador')
                        <span style="background:rgba(212,168,83,0.1);color:#d4a853;padding:4px 10px;border-radius:20px;font-size:0.8rem;font-weight:600;">
                            {{ $funcionario->agendamentos_count }}
                        </span>
                    @else
                        <span style="color:#4a4a6a;">—</span>
                    @endif
                </td>
                <td>
                    <span class="badge {{ $funcionario->ativo ? 'badge-green' : 'badge-red' }}">
                        {{ $funcionario->ativo ? 'Ativo' : 'Inativo' }}
                    </span>
                </td>
                <td>
                    <div style="display:flex;gap:8px;">
                        <a href="{{ route('funcionarios.show', $funcionario) }}" class="btn-secondary btn-sm" title="Ver perfil">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </a>
                        <a href="{{ route('funcionarios.edit', $funcionario) }}" class="btn-secondary btn-sm" title="Editar">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        </a>
                        @if($funcionario->funcao === 'tatuador')
                        <a href="{{ route('tatuadores.perfil', $funcionario) }}" class="btn-secondary btn-sm" title="Ver galeria">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                        </a>
                        @endif
                        <form method="POST" action="{{ route('funcionarios.destroy', $funcionario) }}" onsubmit="return confirm('Tem certeza? Esta ação não pode ser desfeita.')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-danger btn-sm" title="Excluir">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align:center;padding:48px;color:#4a4a6a;">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" style="margin:0 auto 16px;display:block;"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                    <div style="font-size:1.1rem;font-weight:600;margin-bottom:8px;">Nenhum funcionário encontrado</div>
                    <a href="{{ route('funcionarios.create') }}" class="btn-primary" style="display:inline-flex;margin-top:12px;">Cadastrar primeiro funcionário</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Paginação -->
@if($funcionarios->hasPages())
<div class="pagination">
    @if($funcionarios->onFirstPage())
        <span class="disabled">‹</span>
    @else
        <a href="{{ $funcionarios->previousPageUrl() }}">‹</a>
    @endif

    @foreach($funcionarios->getUrlRange(1, $funcionarios->lastPage()) as $page => $url)
        @if($page == $funcionarios->currentPage())
            <span class="active-page">{{ $page }}</span>
        @else
            <a href="{{ $url }}">{{ $page }}</a>
        @endif
    @endforeach

    @if($funcionarios->hasMorePages())
        <a href="{{ $funcionarios->nextPageUrl() }}">›</a>
    @else
        <span class="disabled">›</span>
    @endif
</div>
@endif

@endsection
