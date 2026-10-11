@extends('layouts.app')

@section('title', 'Novo Agendamento')
@section('page-title', 'Novo Agendamento')

@section('content')

<div class="breadcrumb">
    <a href="{{ route('dashboard') }}">Dashboard</a>
    <span>/</span>
    <a href="{{ route('agendamentos.index') }}">Agendamentos</a>
    <span>/</span>
    <span style="color:#e8e8f0;">Novo</span>
</div>

<div class="page-header">
    <h1>Agendar Sessão</h1>
    <p>Cadastre um novo agendamento vinculando cliente e profissional tatuador</p>
</div>

<div class="card" style="padding:32px;max-width:900px;">
    <form action="{{ route('agendamentos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Dados do Cliente -->
        <h3 style="color:#d4a853;font-size:1.1rem;margin-bottom:20px;display:flex;align-items:center;gap:8px;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            1. Dados do Cliente
        </h3>

        <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(250px, 1fr));gap:20px;">
            <div class="form-group">
                <label class="form-label">Nome Completo *</label>
                <input type="text" name="nome_cliente" value="{{ old('nome_cliente') }}" class="form-input" placeholder="Ex: Larissa Souza" required>
                @error('nome_cliente') <span style="color:#f87171;font-size:0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Idade (mín. 18 anos) *</label>
                <input type="number" name="idade_cliente" value="{{ old('idade_cliente') }}" min="18" max="100" class="form-input" placeholder="Ex: 26" required>
                @error('idade_cliente') <span style="color:#f87171;font-size:0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Telefone / WhatsApp</label>
                <input type="text" name="telefone" value="{{ old('telefone') }}" class="form-input" placeholder="(11) 99999-9999">
                @error('telefone') <span style="color:#f87171;font-size:0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">E-mail</label>
                <input type="email" name="email" value="{{ old('email') }}" class="form-input" placeholder="cliente@email.com">
                @error('email') <span style="color:#f87171;font-size:0.8rem;">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Foto de Perfil do Cliente (Opcional)</label>
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
                    <option value="">Selecione um profissional...</option>
                    @foreach($tatuadores as $t)
                        <option value="{{ $t->id }}" {{ old('funcionario_id') == $t->id ? 'selected' : '' }}>
                            {{ $t->nome }} ({{ $t->especialidade ?? 'Geral' }})
                        </option>
                    @endforeach
                </select>
                @error('funcionario_id') <span style="color:#f87171;font-size:0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Data da Sessão *</label>
                <input type="date" name="data_agendamento" value="{{ old('data_agendamento', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}" class="form-input" required>
                @error('data_agendamento') <span style="color:#f87171;font-size:0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Horário *</label>
                <input type="time" name="hora_agendamento" value="{{ old('hora_agendamento', '14:00') }}" class="form-input" required>
                @error('hora_agendamento') <span style="color:#f87171;font-size:0.8rem;">{{ $message }}</span> @enderror
            </div>
        </div>

        <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(250px, 1fr));gap:20px;">
            <div class="form-group">
                <label class="form-label">Local no Corpo</label>
                <input type="text" name="local_corpo" value="{{ old('local_corpo') }}" class="form-input" placeholder="Ex: Antebraço, Costelas, Perna">
            </div>

            <div class="form-group">
                <label class="form-label">Tamanho Estimado</label>
                <input type="text" name="tamanho" value="{{ old('tamanho') }}" class="form-input" placeholder="Ex: 15cm, Fechamento de braço">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Descrição da Ideia / Projeto</label>
            <textarea name="descricao_tatuagem" rows="3" class="form-input" placeholder="Detalhes do estilo, cores, referências visuais...">{{ old('descricao_tatuagem') }}</textarea>
        </div>

        <div class="form-group">
            <label class="form-label">Imagem de Referência / Arte Final (Opcional)</label>
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
                <input type="number" step="0.01" name="valor_estimado" value="{{ old('valor_estimado') }}" class="form-input" placeholder="0,00">
                @error('valor_estimado') <span style="color:#f87171;font-size:0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Forma de Pagamento *</label>
                <select name="forma_pagamento" class="form-select" required>
                    <option value="pix" {{ old('forma_pagamento') === 'pix' ? 'selected' : '' }}>PIX</option>
                    <option value="cartao_credito" {{ old('forma_pagamento') === 'cartao_credito' ? 'selected' : '' }}>Cartão de Crédito</option>
                    <option value="cartao_debito" {{ old('forma_pagamento') === 'cartao_debito' ? 'selected' : '' }}>Cartão de Débito</option>
                    <option value="dinheiro" {{ old('forma_pagamento') === 'dinheiro' ? 'selected' : '' }}>Dinheiro</option>
                    <option value="transferencia" {{ old('forma_pagamento') === 'transferencia' ? 'selected' : '' }}>Transferência</option>
                </select>
                @error('forma_pagamento') <span style="color:#f87171;font-size:0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Parcelas</label>
                <input type="number" name="parcelas" value="{{ old('parcelas', 1) }}" min="1" max="24" class="form-input">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Observações Clínicas / Gerais</label>
            <textarea name="observacoes" rows="2" class="form-input" placeholder="Alergias, medicamentos, recomendações pré-sessão...">{{ old('observacoes') }}</textarea>
        </div>

        <div style="display:flex;gap:12px;justify-content:flex-end;margin-top:24px;">
            <a href="{{ route('agendamentos.index') }}" class="btn-secondary">Cancelar</a>
            <button type="submit" class="btn-primary">Salvar Agendamento</button>
        </div>
    </form>
</div>

@endsection
