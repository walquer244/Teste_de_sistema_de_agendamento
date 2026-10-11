@extends('layouts.app')

@section('title', 'Editar Trabalho da Galeria')
@section('page-title', 'Editar Trabalho da Galeria')

@section('content')

<div class="breadcrumb">
    <a href="{{ route('dashboard') }}">Dashboard</a>
    <span>/</span>
    <a href="{{ route('galerias.index') }}">Galeria</a>
    <span>/</span>
    <a href="{{ route('galerias.show', $galeria) }}">Trabalho #{{ $galeria->id }}</a>
    <span>/</span>
    <span style="color:#e8e8f0;">Editar</span>
</div>

<div class="page-header">
    <h1>Editar Publicação</h1>
    <p>Atualize a foto, estilo, avaliações ou informações desta tatuagem</p>
</div>

<div class="card" style="padding:32px;max-width:850px;">
    <form action="{{ route('galerias.update', $galeria) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(250px, 1fr));gap:20px;">
            <div class="form-group">
                <label class="form-label">Tatuador Responsável *</label>
                <select name="funcionario_id" class="form-select" required>
                    @foreach($tatuadores as $t)
                        <option value="{{ $t->id }}" {{ old('funcionario_id', $galeria->funcionario_id) == $t->id ? 'selected' : '' }}>
                            {{ $t->nome }} ({{ $t->especialidade ?? 'Geral' }})
                        </option>
                    @endforeach
                </select>
                @error('funcionario_id') <span style="color:#f87171;font-size:0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Estilo da Tatuagem *</label>
                <select name="estilo_tatuagem" class="form-select" required>
                    @php
                        $estilos = ['realismo', 'blackwork', 'aquarela', 'old_school', 'new_school', 'geometrico', 'minimalista', 'tribal', 'japones', 'dotwork', 'fineline', 'trash_polka', 'neotradicional', 'lettering', 'outro'];
                    @endphp
                    @foreach($estilos as $estilo)
                        <option value="{{ $estilo }}" {{ old('estilo_tatuagem', $galeria->estilo_tatuagem) === $estilo ? 'selected' : '' }}>
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
                <input type="text" name="nome_cliente" value="{{ old('nome_cliente', $galeria->nome_cliente) }}" class="form-input" required>
                @error('nome_cliente') <span style="color:#f87171;font-size:0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Foto de Perfil do Cliente</label>
                @if($galeria->foto_perfil_cliente)
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;">
                        <img src="{{ $galeria->foto_perfil_cliente_url }}" alt="" class="avatar" style="width:36px;height:36px;">
                        <span style="font-size:0.8rem;color:#9898b8;">Foto atual cadastrada</span>
                    </div>
                @endif
                <input type="file" name="foto_perfil_cliente" accept="image/*" class="form-input">
            </div>
        </div>

        <!-- Foto da Tatuagem -->
        <div class="form-group">
            <label class="form-label">Foto da Tatuagem</label>
            @if($galeria->imagem_tatuagem)
                <div style="margin-bottom:10px;">
                    <img src="{{ $galeria->imagem_tatuagem_url }}" alt="" style="max-height:160px;border-radius:10px;border:1px solid #252535;">
                </div>
            @endif
            <input type="file" name="imagem_tatuagem" accept="image/*" class="form-input">
            <div style="font-size:0.8rem;color:#6b6b8f;margin-top:4px;">Deixe em branco para manter a imagem atual.</div>
            @error('imagem_tatuagem') <span style="color:#f87171;font-size:0.8rem;">{{ $message }}</span> @enderror
        </div>

        <hr class="divider">

        <h3 style="color:#d4a853;font-size:1.1rem;margin-bottom:20px;">Feedback do Cliente</h3>

        <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));gap:20px;">
            <div class="form-group">
                <label class="form-label">Avaliação do Atendimento *</label>
                <select name="avaliacao_atendimento" class="form-select" required>
                    <option value="5" {{ old('avaliacao_atendimento', $galeria->avaliacao_atendimento) == 5 ? 'selected' : '' }}>★★★★★ 5 estrelas</option>
                    <option value="4" {{ old('avaliacao_atendimento', $galeria->avaliacao_atendimento) == 4 ? 'selected' : '' }}>★★★★☆ 4 estrelas</option>
                    <option value="3" {{ old('avaliacao_atendimento', $galeria->avaliacao_atendimento) == 3 ? 'selected' : '' }}>★★★☆☆ 3 estrelas</option>
                    <option value="2" {{ old('avaliacao_atendimento', $galeria->avaliacao_atendimento) == 2 ? 'selected' : '' }}>★★☆☆☆ 2 estrelas</option>
                    <option value="1" {{ old('avaliacao_atendimento', $galeria->avaliacao_atendimento) == 1 ? 'selected' : '' }}>★☆☆☆☆ 1 estrela</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Avaliação do Resultado *</label>
                <select name="avaliacao_resultado" class="form-select" required>
                    <option value="5" {{ old('avaliacao_resultado', $galeria->avaliacao_resultado) == 5 ? 'selected' : '' }}>★★★★★ 5 estrelas</option>
                    <option value="4" {{ old('avaliacao_resultado', $galeria->avaliacao_resultado) == 4 ? 'selected' : '' }}>★★★★☆ 4 estrelas</option>
                    <option value="3" {{ old('avaliacao_resultado', $galeria->avaliacao_resultado) == 3 ? 'selected' : '' }}>★★★☆☆ 3 estrelas</option>
                    <option value="2" {{ old('avaliacao_resultado', $galeria->avaliacao_resultado) == 2 ? 'selected' : '' }}>★★☆☆☆ 2 estrelas</option>
                    <option value="1" {{ old('avaliacao_resultado', $galeria->avaliacao_resultado) == 1 ? 'selected' : '' }}>★☆☆☆☆ 1 estrela</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Depoimento / Comentário</label>
            <textarea name="comentario" rows="3" class="form-input">{{ old('comentario', $galeria->comentario) }}</textarea>
        </div>

        <div style="display:flex;align-items:center;gap:10px;margin-bottom:24px;">
            <input type="checkbox" name="destaque" id="destaque_edit" value="1" {{ old('destaque', $galeria->destaque) ? 'checked' : '' }} style="accent-color:#d4a853;width:20px;height:20px;">
            <label for="destaque_edit" class="form-label" style="margin:0;cursor:pointer;font-size:0.95rem;">
                Destacar no Topo da Galeria e Portfólio ★
            </label>
        </div>

        <div style="display:flex;gap:12px;justify-content:flex-end;">
            <a href="{{ route('galerias.show', $galeria) }}" class="btn-secondary">Cancelar</a>
            <button type="submit" class="btn-primary">Salvar Alterações</button>
        </div>
    </form>
</div>

@endsection
