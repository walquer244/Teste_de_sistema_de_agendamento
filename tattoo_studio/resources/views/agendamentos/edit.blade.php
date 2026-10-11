@extends('layouts.app')

@section('title', 'Editar Agendamento')
@section('page-title', 'Editar Agendamento')

@section('content')

<div class="breadcrumb">
    <a href="{{ route('dashboard') }}">Dashboard</a>
    <span>/</span>
    <a href="{{ route('agendamentos.index') }}">Agendamentos</a>
    <span>/</span>
    <a href="{{ route('agendamentos.show', $agendamento) }}">{{ $agendamento->nome_cliente }}</a>
    <span>/</span>
    <span style="color:#e8e8f0;">Editar</span>
</div>

<div class="page-header">
    <h1>Editar Agendamento</h1>
    <p>Atualize as informações do agendamento de {{ $agendamento->nome_cliente }}</p>
</div>

<div class="card" style="padding:32px;max-width:900px;">
    <form action="{{ route('agendamentos.update', $agendamento) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Status do Agendamento -->
        <div style="background:#1a1a28;padding:20px;border-radius:12px;margin-bottom:24px;border:1px solid #252535;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:16px;">
            <div>
                <label class="form-label" style="color:#d4a853;margin-bottom:4px;">Status da Sessão</label>
                <div style="font-size:0.85rem;color:#9898b8;">Altere o andamento atual do atendimento</div>
            </div>
            <div style="min-width:200px;">
                <select name="status" class="form-select" required>
                    <option value="pendente" {{ old('status', $agendamento->status) === 'pendente' ? 'selected' : '' }}>Pendente</option>
                    <option value="confirmado" {{ old('status', $agendamento->status) === 'confirmado' ? 'selected' : '' }}>Confirmado</option>
                    <option value="concluido" {{ old('status', $agendamento->status) === 'concluido' ? 'selected' : '' }}>Concluído</option>
                    <option value="cancelado" {{ old('status', $agendamento->status) === 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                </select>
            </div>
        </div>

        <!-- Dados do Cliente -->
        <h3 style="color:#d4a853;font-size:1.1rem;margin-bottom:20px;display:flex;align-items:center;gap:8px;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            1. Dados do Cliente
        </h3>

        <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(250px, 1fr));gap:20px;">
            <div class="form-group">
                <label class="form-label">Nome Completo *</label>
                <input type="text" name="nome_cliente" value="{{ old('nome_cliente', $agendamento->nome_cliente) }}" class="form-input" required>
                @error('nome_cliente') <span style="color:#f87171;font-size:0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Idade *</label>
                <input type="number" name="idade_cliente" value="{{ old('idade_cliente', $agendamento->idade_cliente) }}" min="18" max="100" class="form-input" required>
                @error('idade_cliente') <span style="color:#f87171;font-size:0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Telefone</label>
                <input type="text" name="telefone" value="{{ old('telefone', $agendamento->telefone) }}" class="form-input">
                @error('telefone') <span style="color:#f87171;font-size:0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">E-mail</label>
                <input type="email" name="email" value="{{ old('email', $agendamento->email) }}" class="form-input">
                @error('email') <span style="color:#f87171;font-size:0.8rem;">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Foto de Perfil do Cliente</label>
            @if($agendamento->foto_perfil)
                <div style="display:flex;align-items:center;gap:12px;margin-bottom:8px;">
                    <img src="{{ $agendamento->foto_perfil_url }}" alt="" class="avatar" style="width:40px;height:40px;">
                    <span style="font-size:0.85rem;color:#9898b8;">Foto atual cadastrada</span>
                </div>
            @endif
            <input type="file" name="foto_perfil" accept="image/*" class="form-input">
            @error('foto_perfil') <span style="color:#f87171;font-size:0.8rem;">{{ $message }}</span> @enderror
        </div>

        <hr class="divider">

        <!-- Detalhes do Procedimento e Artista -->
        <h3 style="color:#d4a853;font-size:1.1rem;margin-bottom:20px;display:flex;align-items:center;gap:8px;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            2. Sessão & Tatuador
        </h3>

        <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(250px, 1fr));gap:20px;">
            <div class="form-group">
                <label class="form-label">Tatuador Responsável *</label>
                <select name="funcionario_id" class="form-select" required>
                    @foreach($tatuadores as $t)
                        <option value="{{ $t->id }}" {{ old('funcionario_id', $agendamento->funcionario_id) == $t->id ? 'selected' : '' }}>
                            {{ $t->nome }} ({{ $t->especialidade ?? 'Geral' }})
                        </option>
                    @endforeach
                </select>
                @error('funcionario_id') <span style="color:#f87171;font-size:0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Data da Sessão *</label>
                <input type="date" name="data_agendamento" value="{{ old('data_agendamento', \Carbon\Carbon::parse($agendamento->data_agendamento)->format('Y-m-d')) }}" class="form-input" required>
                @error('data_agendamento') <span style="color:#f87171;font-size:0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Horário *</label>
                <input type="time" name="hora_agendamento" value="{{ old('hora_agendamento', \Carbon\Carbon::parse($agendamento->hora_agendamento)->format('H:i')) }}" class="form-input" required>
                @error('hora_agendamento') <span style="color:#f87171;font-size:0.8rem;">{{ $message }}</span> @enderror
            </div>
        </div>

        <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(250px, 1fr));gap:20px;">
            <div class="form-group">
                <label class="form-label">Local no Corpo</label>
                <input type="text" name="local_corpo" value="{{ old('local_corpo', $agendamento->local_corpo) }}" class="form-input">
            </div>

            <div class="form-group">
                <label class="form-label">Tamanho Estimado</label>
                <input type="text" name="tamanho" value="{{ old('tamanho', $agendamento->tamanho) }}" class="form-input">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Descrição da Ideia / Projeto</label>
            <textarea name="descricao_tatuagem" rows="3" class="form-input">{{ old('descricao_tatuagem', $agendamento->descricao_tatuagem) }}</textarea>
        </div>

        <div class="form-group">
            <label class="form-label">Imagem de Referência / Arte</label>
            @if($agendamento->imagem_tatuagem)
                <div style="display:flex;align-items:center;gap:12px;margin-bottom:8px;">
                    <img src="{{ $agendamento->imagem_tatuagem_url }}" alt="" style="width:60px;height:60px;object-fit:cover;border-radius:8px;border:1px solid #252535;">
                    <span style="font-size:0.85rem;color:#9898b8;">Imagem atual cadastrada</span>
                </div>
            @endif
            <input type="file" name="imagem_tatuagem" accept="image/*" class="form-input">
            @error('imagem_tatuagem') <span style="color:#f87171;font-size:0.8rem;">{{ $message }}</span> @enderror
        </div>

        <hr class="divider">

        <!-- Financeiro -->
        <h3 style="color:#d4a853;font-size:1.1rem;margin-bottom:20px;display:flex;align-items:center;gap:8px;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
            3. Pagamento & Observações
        </h3>

        <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));gap:20px;">
            <div class="form-group">
                <label class="form-label">Valor Estimado (R$)</label>
                <input type="number" step="0.01" name="valor_estimado" value="{{ old('valor_estimado', $agendamento->valor_estimado) }}" class="form-input">
                @error('valor_estimado') <span style="color:#f87171;font-size:0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Forma de Pagamento *</label>
                <select name="forma_pagamento" class="form-select" required>
                    <option value="pix" {{ old('forma_pagamento', $agendamento->forma_pagamento) === 'pix' ? 'selected' : '' }}>PIX</option>
                    <option value="cartao_credito" {{ old('forma_pagamento', $agendamento->forma_pagamento) === 'cartao_credito' ? 'selected' : '' }}>Cartão de Crédito</option>
                    <option value="cartao_debito" {{ old('forma_pagamento', $agendamento->forma_pagamento) === 'cartao_debito' ? 'selected' : '' }}>Cartão de Débito</option>
                    <option value="dinheiro" {{ old('forma_pagamento', $agendamento->forma_pagamento) === 'dinheiro' ? 'selected' : '' }}>Dinheiro</option>
                    <option value="transferencia" {{ old('forma_pagamento', $agendamento->forma_pagamento) === 'transferencia' ? 'selected' : '' }}>Transferência</option>
                </select>
                @error('forma_pagamento') <span style="color:#f87171;font-size:0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Parcelas</label>
                <input type="number" name="parcelas" value="{{ old('parcelas', $agendamento->parcelas) }}" min="1" max="24" class="form-input">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Observações</label>
            <textarea name="observacoes" rows="2" class="form-input">{{ old('observacoes', $agendamento->observacoes) }}</textarea>
        </div>

        <div style="display:flex;gap:12px;justify-content:flex-end;margin-top:24px;">
            <a href="{{ route('agendamentos.show', $agendamento) }}" class="btn-secondary">Cancelar</a>
            <button type="submit" class="btn-primary">Atualizar Agendamento</button>
        </div>
    </form>
</div>

@endsection
