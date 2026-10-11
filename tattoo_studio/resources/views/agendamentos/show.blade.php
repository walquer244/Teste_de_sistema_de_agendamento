@extends('layouts.app')

@section('title', 'Detalhes do Agendamento')
@section('page-title', 'Detalhes do Agendamento')

@section('content')

<div class="breadcrumb">
    <a href="{{ route('dashboard') }}">Dashboard</a>
    <span>/</span>
    <a href="{{ route('agendamentos.index') }}">Agendamentos</a>
    <span>/</span>
    <span style="color:#e8e8f0;">{{ $agendamento->nome_cliente }}</span>
</div>

<div class="page-header" style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:16px;">
    <div>
        <h1>Agendamento #{{ $agendamento->id }}</h1>
        <p>Sessão de {{ $agendamento->nome_cliente }} com {{ $agendamento->funcionario->nome ?? 'Tatuador' }}</p>
    </div>
    <div style="display:flex;gap:10px;">
        <a href="{{ route('agendamentos.edit', $agendamento) }}" class="btn-primary">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            Editar Agendamento
        </a>
        <a href="{{ route('agendamentos.index') }}" class="btn-secondary">Voltar</a>
    </div>
</div>

<div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(320px, 1fr));gap:24px;">
    <!-- Coluna 1: Informações do Cliente & Status -->
    <div style="display:flex;flex-direction:column;gap:24px;">
        <!-- Card do Cliente -->
        <div class="card" style="padding:28px;">
            <div style="display:flex;align-items:center;gap:16px;margin-bottom:24px;">
                <img src="{{ $agendamento->foto_perfil_url }}" alt="{{ $agendamento->nome_cliente }}" class="avatar" style="width:64px;height:64px;">
                <div>
                    <h2 style="font-size:1.3rem;font-weight:700;color:#e8e8f0;margin:0;">{{ $agendamento->nome_cliente }}</h2>
                    <div style="color:#d4a853;font-size:0.9rem;margin-top:4px;">{{ $agendamento->idade_cliente }} anos</div>
                </div>
            </div>

            <div style="display:flex;flex-direction:column;gap:12px;font-size:0.9rem;">
                <div style="display:flex;justify-content:space-between;padding:10px 0;border-bottom:1px solid #1a1a28;">
                    <span style="color:#6b6b8f;">Telefone:</span>
                    <span style="color:#e8e8f0;font-weight:500;">{{ $agendamento->telefone ?? 'Não informado' }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;padding:10px 0;border-bottom:1px solid #1a1a28;">
                    <span style="color:#6b6b8f;">E-mail:</span>
                    <span style="color:#e8e8f0;font-weight:500;">{{ $agendamento->email ?? 'Não informado' }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;padding:10px 0;">
                    <span style="color:#6b6b8f;">Cadastrado em:</span>
                    <span style="color:#e8e8f0;font-weight:500;">{{ $agendamento->created_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
        </div>

        <!-- Card de Status e Controle -->
        <div class="card" style="padding:28px;">
            <h3 style="color:#d4a853;font-size:1rem;margin-bottom:16px;">Status do Atendimento</h3>
            <div style="margin-bottom:20px;display:flex;align-items:center;gap:12px;">
                <span class="badge badge-{{ $agendamento->status_color }}" style="font-size:0.9rem;padding:6px 16px;">
                    {{ $agendamento->status_label }}
                </span>
            </div>

            <!-- Form de Atualização Rápida de Status -->
            <form action="{{ route('agendamentos.update-status', $agendamento) }}" method="POST" style="display:flex;gap:10px;align-items:center;">
                @csrf
                @method('PATCH')
                <select name="status" class="form-select" style="flex:1;">
                    <option value="pendente" {{ $agendamento->status === 'pendente' ? 'selected' : '' }}>Pendente</option>
                    <option value="confirmado" {{ $agendamento->status === 'confirmado' ? 'selected' : '' }}>Confirmado</option>
                    <option value="concluido" {{ $agendamento->status === 'concluido' ? 'selected' : '' }}>Concluído</option>
                    <option value="cancelado" {{ $agendamento->status === 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                </select>
                <button type="submit" class="btn-primary btn-sm">Atualizar</button>
            </form>

            @if($agendamento->status === 'concluido')
                <div style="margin-top:20px;padding:16px;background:rgba(212,168,83,0.08);border:1px solid rgba(212,168,83,0.25);border-radius:10px;">
                    <div style="color:#d4a853;font-weight:600;font-size:0.9rem;margin-bottom:6px;">Sessão Concluída!</div>
                    <p style="font-size:0.85rem;color:#c4c4d8;margin-bottom:12px;">Adicione o resultado final à galeria do tatuador com fotos e depoimento do cliente.</p>
                    <a href="{{ route('galerias.create', ['agendamento_id' => $agendamento->id]) }}" class="btn-primary btn-sm" style="width:100%;justify-content:center;">
                        + Publicar na Galeria
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Coluna 2: Detalhes da Sessão & Pagamento -->
    <div style="display:flex;flex-direction:column;gap:24px;">
        <div class="card" style="padding:28px;">
            <h3 style="color:#d4a853;font-size:1.1rem;margin-bottom:20px;">Detalhes do Procedimento</h3>

            <div style="display:flex;flex-direction:column;gap:16px;">
                <div style="background:#1a1a28;padding:16px;border-radius:10px;border:1px solid #252535;">
                    <div style="font-size:0.8rem;color:#6b6b8f;text-transform:uppercase;margin-bottom:4px;">Tatuador(a)</div>
                    <div style="font-size:1.1rem;font-weight:600;color:#e8e8f0;">
                        <a href="{{ route('funcionarios.show', $agendamento->funcionario_id) }}" style="color:#d4a853;text-decoration:none;">
                            {{ $agendamento->funcionario->nome ?? 'Não informado' }}
                        </a>
                    </div>
                    <div style="font-size:0.85rem;color:#9898b8;">{{ $agendamento->funcionario->especialidade ?? 'Especialista' }}</div>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                    <div style="background:#1a1a28;padding:14px;border-radius:10px;border:1px solid #252535;">
                        <div style="font-size:0.75rem;color:#6b6b8f;text-transform:uppercase;">Data Marcada</div>
                        <div style="font-size:1rem;font-weight:600;color:#e8e8f0;margin-top:4px;">
                            {{ \Carbon\Carbon::parse($agendamento->data_agendamento)->format('d/m/Y') }}
                        </div>
                    </div>
                    <div style="background:#1a1a28;padding:14px;border-radius:10px;border:1px solid #252535;">
                        <div style="font-size:0.75rem;color:#6b6b8f;text-transform:uppercase;">Horário</div>
                        <div style="font-size:1rem;font-weight:600;color:#d4a853;margin-top:4px;">
                            {{ \Carbon\Carbon::parse($agendamento->hora_agendamento)->format('H:i') }}
                        </div>
                    </div>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                    <div>
                        <div style="font-size:0.8rem;color:#6b6b8f;">Local no Corpo:</div>
                        <div style="color:#c4c4d8;font-weight:500;">{{ $agendamento->local_corpo ?? 'Não informado' }}</div>
                    </div>
                    <div>
                        <div style="font-size:0.8rem;color:#6b6b8f;">Tamanho:</div>
                        <div style="color:#c4c4d8;font-weight:500;">{{ $agendamento->tamanho ?? 'Não informado' }}</div>
                    </div>
                </div>

                @if($agendamento->descricao_tatuagem)
                    <div>
                        <div style="font-size:0.8rem;color:#6b6b8f;margin-bottom:6px;">Descrição do Projeto:</div>
                        <div style="background:#1a1a28;padding:14px;border-radius:10px;border:1px solid #252535;color:#c4c4d8;font-size:0.9rem;line-height:1.5;">
                            {{ $agendamento->descricao_tatuagem }}
                        </div>
                    </div>
                @endif

                @if($agendamento->imagem_tatuagem)
                    <div>
                        <div style="font-size:0.8rem;color:#6b6b8f;margin-bottom:8px;">Imagem de Referência / Arte:</div>
                        <img src="{{ $agendamento->imagem_tatuagem_url }}" alt="Arte de Referência" style="max-width:100%;max-height:300px;border-radius:12px;border:1px solid #252535;object-fit:cover;">
                    </div>
                @endif
            </div>
        </div>

        <!-- Card Financeiro -->
        <div class="card" style="padding:28px;">
            <h3 style="color:#d4a853;font-size:1.1rem;margin-bottom:16px;">Financeiro & Pagamento</h3>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">
                <div>
                    <div style="font-size:0.8rem;color:#6b6b8f;">Valor Estimado:</div>
                    <div style="font-size:1.4rem;font-weight:700;color:#e8e8f0;margin-top:4px;">
                        R$ {{ number_format($agendamento->valor_estimado ?? 0, 2, ',', '.') }}
                    </div>
                </div>
                <div>
                    <div style="font-size:0.8rem;color:#6b6b8f;">Forma de Pagamento:</div>
                    <div style="font-size:1.1rem;font-weight:600;color:#d4a853;margin-top:4px;">
                        {{ $agendamento->forma_pagamento_label }}
                        @if($agendamento->parcelas > 1) ({{ $agendamento->parcelas }}x) @endif
                    </div>
                </div>
            </div>

            @if($agendamento->observacoes)
                <div style="border-top:1px solid #1a1a28;padding-top:14px;margin-top:14px;">
                    <div style="font-size:0.8rem;color:#6b6b8f;margin-bottom:4px;">Observações Clínicas / Adicionais:</div>
                    <div style="color:#9898b8;font-size:0.85rem;line-height:1.4;">{{ $agendamento->observacoes }}</div>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
