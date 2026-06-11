@extends('layouts.app')
@section('title', 'Novo Curso')
@section('content')
<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('cursos.index') }}">Cursos</a></li>
        <li class="breadcrumb-item active">Novo Curso</li>
    </ol>
</nav>
<div class="page-header">
    <div>
        <h1><i class="bi bi-plus-circle-fill me-2 text-primary"></i>Novo Curso</h1>
        <p>Preencha as informações abaixo para cadastrar um novo curso.</p>
    </div>
    <a href="{{ route('cursos.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Voltar
    </a>
</div>
<form action="{{ route('cursos.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="form-card">
                <div class="form-section">
                    <div class="section-title"><i class="bi bi-info-circle-fill text-primary"></i> Informações Básicas</div>
                    <div class="mb-3">
                        <label class="form-label">Nome do Curso <span class="text-danger">*</span></label>
                        <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror"
                               value="{{ old('nome') }}" placeholder="Ex: Desenvolvimento Web com Laravel">
                        @error('nome')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-0">
                        <label class="form-label">Descrição <span class="text-danger">*</span></label>
                        <textarea name="descricao" rows="4" class="form-control @error('descricao') is-invalid @enderror"
                                  placeholder="Descreva os objetivos, conteúdo e público-alvo do curso...">{{ old('descricao') }}</textarea>
                        @error('descricao')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="form-section">
                    <div class="section-title"><i class="bi bi-sliders text-primary"></i> Configurações</div>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Carga Horária (h) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-clock"></i></span>
                                <input type="number" name="carga_horaria" min="1"
                                       class="form-control @error('carga_horaria') is-invalid @enderror"
                                       value="{{ old('carga_horaria') }}" placeholder="40">
                            </div>
                            @error('carga_horaria')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Nível <span class="text-danger">*</span></label>
                            <select name="nivel" class="form-select @error('nivel') is-invalid @enderror">
                                <option value="">Selecione...</option>
                                @foreach(['Iniciante','Intermediário','Avançado'] as $n)
                                    <option value="{{ $n }}" {{ old('nivel') == $n ? 'selected' : '' }}>{{ $n }}</option>
                                @endforeach
                            </select>
                            @error('nivel')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Preço (R$) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">R$</span>
                                <input type="number" step="0.01" min="0" name="preco"
                                       class="form-control @error('preco') is-invalid @enderror"
                                       value="{{ old('preco', '0.00') }}" placeholder="0.00">
                            </div>
                            @error('preco')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror">
                                @foreach(['Ativo','Inativo','Em breve'] as $s)
                                    <option value="{{ $s }}" {{ old('status','Ativo') == $s ? 'selected' : '' }}>{{ $s }}</option>
                                @endforeach
                            </select>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-card">
                <div class="form-section">
                    <div class="section-title"><i class="bi bi-image text-primary"></i> Imagem do Curso</div>
                    <div class="upload-zone" id="upload-zone" onclick="document.getElementById('imagem-input').click()">
                        <input type="file" name="imagem" id="imagem-input" accept="image/*"
                               class="@error('imagem') is-invalid @enderror" onchange="previewImg(this)">
                        <div id="upload-placeholder">
                            <i class="bi bi-cloud-arrow-up-fill upload-icon"></i>
                            <p><strong>Clique para enviar</strong><br><span style="font-size:.75rem">JPG, PNG ou WEBP — máx. 2MB</span></p>
                        </div>
                        <img id="img-preview" src="" alt="Preview">
                    </div>
                    @error('imagem')<div class="text-danger mt-1" style="font-size:.8rem">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="mt-3 d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-lg fw-bold">
                    <i class="bi bi-check2-circle me-1"></i> Salvar Curso
                </button>
                <a href="{{ route('cursos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </div>
    </div>
</form>
@push('scripts')
<script>
function previewImg(input) {
    const preview = document.getElementById('img-preview');
    const placeholder = document.getElementById('upload-placeholder');
    if (input.files && input.files[0]) {
        preview.src = URL.createObjectURL(input.files[0]);
        preview.style.display = 'block';
        placeholder.style.display = 'none';
    }
}
</script>
@endpush
@endsection
