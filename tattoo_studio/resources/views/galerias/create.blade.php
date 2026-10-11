@extends('layouts.app')

@section('title', 'Novo Trabalho na Galeria')
@section('page-title', 'Novo Trabalho na Galeria')

@section('content')

<div class="breadcrumb">
    <a href="{{ route('dashboard') }}">Dashboard</a>
    <span>/</span>
    <a href="{{ route('galerias.index') }}">Galeria</a>
    <span>/</span>
    <span style="color:#e8e8f0;">Novo Trabalho</span>
</div>

<div class="page-header">
    <h1>Publicar na Galeria</h1>
    <p>Adicione uma nova foto de tatuagem finalizada ao portfólio</p>
</div>

@if($agendamento)
    <div class="card-gold" style="padding:16px 20px;margin-bottom:24px;display:flex;align-items:center;gap:12px;">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#d4a853" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        <div>
            <div style="font-weight:600;color:#d4a853;">Importando do Agendamento #{{ $agendamento->id }}</div>
            <div style="font-size:0.85rem;color:#c4c4d8;">Cliente: {{ $agendamento->nome_cliente }} • Tatuador: {{ $agendamento->funcionario->nome ?? 'Tatuador' }}</div>
        </div>
    </div>
@endif

<div class="card" style="padding:32px;max-width:850px;">
    <form action="{{ route('galerias.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        @if($agendamento)
            <input type="hidden" name="agendamento_id" value="{{ $agendamento->id }}">
        @endif

        <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(250px, 1fr));gap:20px;">
            <div class="form-group">
                <label class="form-label">Tatuador Responsável *</label>
                <select name="funcionario_id" class="form-select" required>
                    <option value="">Selecione o tatuador...</option>
                    @foreach($tatuadores as $t)
                        <option value="{{ $t->id }}" {{ old('funcionario_id', $agendamento ? $agendamento->funcionario_id : '') == $t->id ? 'selected' : '' }}>
                            {{ $t->nome }} ({{ $t->especialidade ?? 'Geral' }})
                        </option>
                    @endforeach
                </select>
                @error('funcionario_id') <span style="color:#f87171;font-size:0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Estilo da Tatuagem *</label>
                <select name="estilo_tatuagem" class="form-select" required>
                    <option value="">Selecione o estilo...</option>
                    @php
                        $estilos = ['realismo', 'blackwork', 'aquarela', 'old_school', 'new_school', 'geometrico', 'minimalista', 'tribal', 'japones', 'dotwork', 'fineline', 'trash_polka', 'neotradicional', 'lettering', 'outro'];
                    @endphp
                    @foreach($estilos as $estilo)
                        <option value="{{ $estilo }}" {{ old('estilo_tatuagem') === $estilo ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $estilo)) }}
                        </option>
                    @endforeach
                </select>
                @error('estilo_tatuagem') <span style="color:#f87171;font-size:0.8rem;">{{ $message }}</span> @enderror
            </div>
        </div>

        <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(250px, 1fr));gap:20px;">
            <div class="form-group">
                <label class="form-label">Nome do Cliente *</label>
                <input type="text" name="nome_cliente" value="{{ old('nome_cliente', $agendamento ? $agendamento->nome_cliente : '') }}" class="form-input" placeholder="Ex: Larissa Souza" required>
                @error('nome_cliente') <span style="color:#f87171;font-size:0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Foto de Perfil do Cliente (Opcional)</label>
                <input type="file" name="foto_perfil_cliente" accept="image/*" class="form-input">
                @error('foto_perfil_cliente') <span style="color:#f87171;font-size:0.8rem;">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Upload da Imagem da Tatuagem -->
        <div class="form-group">
            <label class="form-label">Foto da Tatuagem Finalizada *</label>
            <input type="file" name="imagem_tatuagem" accept="image/*" class="form-input" required>
            <div style="font-size:0.8rem;color:#6b6b8f;margin-top:4px;">Formatos aceitos: JPG, PNG, WEBP. Tamanho máximo: 10MB.</div>
            @error('imagem_tatuagem') <span style="color:#f87171;font-size:0.8rem;">{{ $message }}</span> @enderror
        </div>

        <hr class="divider">

        <!-- Avaliações & Depoimento -->
        <h3 style="color:#d4a853;font-size:1.1rem;margin-bottom:20px;display:flex;align-items:center;gap:8px;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            Feedback do Cliente
        </h3>

        <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));gap:20px;">
            <div class="form-group">
                <label class="form-label">Avaliação do Atendimento (1 a 5 estrelas) *</label>
                <select name="avaliacao_atendimento" class="form-select" required>
                    <option value="5" {{ old('avaliacao_atendimento', '5') == '5' ? 'selected' : '' }}>★★★★★ 5 estrelas (Excelente)</option>
                    <option value="4" {{ old('avaliacao_atendimento') == '4' ? 'selected' : '' }}>★★★★☆ 4 estrelas (Muito Bom)</option>
                    <option value="3" {{ old('avaliacao_atendimento') == '3' ? 'selected' : '' }}>★★★☆☆ 3 estrelas (Regular)</option>
                    <option value="2" {{ old('avaliacao_atendimento') == '2' ? 'selected' : '' }}>★★☆☆☆ 2 estrelas (Ruim)</option>
                    <option value="1" {{ old('avaliacao_atendimento') == '1' ? 'selected' : '' }}>★☆☆☆☆ 1 estrela (Péssimo)</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Avaliação do Resultado / Arte (1 a 5 estrelas) *</label>
                <select name="avaliacao_resultado" class="form-select" required>
                    <option value="5" {{ old('avaliacao_resultado', '5') == '5' ? 'selected' : '' }}>★★★★★ 5 estrelas (Perfeito)</option>
                    <option value="4" {{ old('avaliacao_resultado') == '4' ? 'selected' : '' }}>★★★★☆ 4 estrelas (Ótimo)</option>
                    <option value="3" {{ old('avaliacao_resultado') == '3' ? 'selected' : '' }}>★★★☆☆ 3 estrelas (Bom)</option>
                    <option value="2" {{ old('avaliacao_resultado') == '2' ? 'selected' : '' }}>★★☆☆☆ 2 estrelas (Regular)</option>
                    <option value="1" {{ old('avaliacao_resultado') == '1' ? 'selected' : '' }}>★☆☆☆☆ 1 estrela (Insatisfeito)</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Depoimento / Comentário do Cliente</label>
            <textarea name="comentario" rows="3" class="form-input" placeholder="O que o cliente achou da sessão, do ambiente e da arte...">{{ old('comentario') }}</textarea>
        </div>

        <div style="display:flex;align-items:center;gap:10px;margin-bottom:24px;">
            <input type="checkbox" name="destaque" id="destaque_input" value="1" {{ old('destaque') ? 'checked' : '' }} style="accent-color:#d4a853;width:20px;height:20px;">
            <label for="destaque_input" class="form-label" style="margin:0;cursor:pointer;font-size:0.95rem;">
                Destacar no Topo da Galeria e Página Inicial ★
            </label>
        </div>

        <div style="display:flex;gap:12px;justify-content:flex-end;">
            <a href="{{ route('galerias.index') }}" class="btn-secondary">Cancelar</a>
            <button type="submit" class="btn-primary">Publicar Trabalho</button>
        </div>
    </form>
</div>

@endsection
