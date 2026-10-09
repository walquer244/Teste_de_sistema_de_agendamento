@extends('layouts.app')

@section('title', 'Editar Funcionário - ' . $funcionario->nome)
@section('page-title', 'Editar Funcionário')

@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Dashboard</a>
    <span>/</span>
    <a href="{{ route('funcionarios.index') }}">Funcionários</a>
    <span>/</span>
    <a href="{{ route('funcionarios.show', $funcionario) }}">{{ $funcionario->nome }}</a>
    <span>/</span>
    <span style="color:#e8e8f0;">Editar</span>
@endsection

@section('content')

<form method="POST" action="{{ route('funcionarios.update', $funcionario) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div style="display:grid;grid-template-columns:300px 1fr;gap:24px;align-items:start;">

        <!-- Foto de Perfil -->
        <div class="card" style="padding:24px;text-align:center;">
            <h3 style="font-weight:600;color:#e8e8f0;margin-bottom:20px;">Foto de Perfil</h3>

            <div style="position:relative;width:140px;height:140px;margin:0 auto 20px;">
                @if($funcionario->foto_perfil)
                    <img id="foto-preview" src="{{ asset('storage/' . $funcionario->foto_perfil) }}" alt="{{ $funcionario->nome }}"
                        style="width:140px;height:140px;border-radius:50%;object-fit:cover;display:block;border:3px solid #d4a853;">
                    <div id="foto-placeholder" style="display:none;"></div>
                @else
                    <img id="foto-preview" src="" alt="Preview"
                        style="width:140px;height:140px;border-radius:50%;object-fit:cover;display:none;border:3px solid #d4a853;">
                    <div id="foto-placeholder" style="width:140px;height:140px;border-radius:50%;background:#1a1a28;border:2px dashed #252535;display:flex;flex-direction:column;align-items:center;justify-content:center;color:#4a4a6a;">
                        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        <span style="font-size:0.75rem;margin-top:8px;">Sem foto</span>
                    </div>
                @endif
            </div>

            <label for="foto_perfil" style="display:block;cursor:pointer;">
                <div style="background:#1a1a28;border:1px solid #252535;border-radius:10px;padding:10px 16px;color:#9898b8;font-size:0.85rem;transition:all 0.2s;text-align:center;" onmouseover="this.style.borderColor='rgba(212,168,83,0.4)';this.style.color='#d4a853'" onmouseout="this.style.borderColor='#252535';this.style.color='#9898b8'">
                    Alterar foto
                </div>
            </label>
            <input type="file" name="foto_perfil" id="foto_perfil" accept="image/*" class="sr-only" onchange="previewFoto(this)">
            <p style="font-size:0.75rem;color:#4a4a6a;margin-top:8px;">JPG, PNG, WEBP até 5MB</p>
        </div>

        <!-- Dados -->
        <div class="card" style="padding:24px;">
            <h3 style="font-weight:600;color:#e8e8f0;margin-bottom:24px;">Informações Pessoais</h3>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                <div class="form-group" style="grid-column:span 2;">
                    <label for="nome" class="form-label">Nome Completo *</label>
                    <input type="text" name="nome" id="nome" value="{{ old('nome', $funcionario->nome) }}" class="form-input" required>
                </div>

                <div class="form-group">
                    <label for="idade" class="form-label">Idade *</label>
                    <input type="number" name="idade" id="idade" value="{{ old('idade', $funcionario->idade) }}" min="18" max="80" class="form-input" required>
                </div>

                <div class="form-group">
                    <label for="data_admissao" class="form-label">Data de Admissão *</label>
                    <input type="date" name="data_admissao" id="data_admissao" value="{{ old('data_admissao', $funcionario->data_admissao->format('Y-m-d')) }}" class="form-input" required>
                </div>

                <div class="form-group">
                    <label for="salario" class="form-label">Salário (R$) *</label>
                    <input type="number" name="salario" id="salario" value="{{ old('salario', $funcionario->salario) }}" min="0" step="0.01" class="form-input" required>
                </div>

                <div class="form-group">
                    <label for="funcao" class="form-label">Função *</label>
                    <select name="funcao" id="funcao" class="form-select" required onchange="toggleEspecialidade()">
                        <option value="tatuador" {{ old('funcao', $funcionario->funcao) === 'tatuador' ? 'selected' : '' }}>Tatuador(a)</option>
                        <option value="atendente" {{ old('funcao', $funcionario->funcao) === 'atendente' ? 'selected' : '' }}>Atendente</option>
                        <option value="gerente" {{ old('funcao', $funcionario->funcao) === 'gerente' ? 'selected' : '' }}>Gerente</option>
                        <option value="auxiliar" {{ old('funcao', $funcionario->funcao) === 'auxiliar' ? 'selected' : '' }}>Auxiliar</option>
                        <option value="recepcionista" {{ old('funcao', $funcionario->funcao) === 'recepcionista' ? 'selected' : '' }}>Recepcionista</option>
                    </select>
                </div>

                <div class="form-group" id="especialidade-group" style="grid-column:span 2;">
                    <label for="especialidade" class="form-label">Especialidade / Estilo de Tatuagem</label>
                    <input type="text" name="especialidade" id="especialidade" value="{{ old('especialidade', $funcionario->especialidade) }}" placeholder="Ex: Realismo, Blackwork..." class="form-input">
                </div>

                <div class="form-group" style="grid-column:span 2;">
                    <label for="instagram" class="form-label">Instagram</label>
                    <div style="position:relative;">
                        <span style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#6b6b8f;font-size:0.9rem;">@</span>
                        <input type="text" name="instagram" id="instagram" value="{{ old('instagram', $funcionario->instagram) }}" class="form-input" style="padding-left:30px;">
                    </div>
                </div>

                <div class="form-group" style="grid-column:span 2;">
                    <label for="bio" class="form-label">Biografia / Sobre</label>
                    <textarea name="bio" id="bio" rows="3" class="form-input">{{ old('bio', $funcionario->bio) }}</textarea>
                </div>

                <div class="form-group" style="grid-column:span 2;">
                    <label style="display:flex;align-items:center;gap:10px;cursor:pointer;">
                        <input type="checkbox" name="ativo" value="1" {{ $funcionario->ativo ? 'checked' : '' }} style="width:18px;height:18px;accent-color:#d4a853;">
                        <span style="color:#c4c4d8;font-weight:500;">Funcionário ativo</span>
                    </label>
                </div>
            </div>

            <hr class="divider">

            <div style="display:flex;gap:12px;justify-content:end;">
                <a href="{{ route('funcionarios.show', $funcionario) }}" class="btn-secondary">Cancelar</a>
                <button type="submit" class="btn-primary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Salvar Alterações
                </button>
            </div>
        </div>

    </div>
</form>

@endsection

@section('scripts')
<script>
function previewFoto(input) {
    const preview = document.getElementById('foto-preview');
    const placeholder = document.getElementById('foto-placeholder');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = (e) => {
            preview.src = e.target.result;
            preview.style.display = 'block';
            if (placeholder) placeholder.style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function toggleEspecialidade() {
    const funcao = document.getElementById('funcao').value;
    const group = document.getElementById('especialidade-group');
    group.style.display = funcao === 'tatuador' ? 'block' : 'none';
}

toggleEspecialidade();
</script>
@endsection
