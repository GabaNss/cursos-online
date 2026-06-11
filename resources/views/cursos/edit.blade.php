@extends('layouts.app')
@section('title', 'Editar Curso')
@section('content')
<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('cursos.index') }}">Cursos</a></li>
        <li class="breadcrumb-item"><a href="{{ route('cursos.show', $curso) }}">{{ Str::limit($curso->nome,30) }}</a></li>
        <li class="breadcrumb-item active">Editar</li>
    </ol>
</nav>
<div class="page-header">
    <div>
        <h1><i class="bi bi-pencil-fill me-2 text-warning"></i>Editar Curso</h1>
        <p>Atualize as informações do curso abaixo.</p>
    </div>
    <a href="{{ route('cursos.show', $curso) }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Voltar
    </a>
</div>
<form action="{{ route('cursos.update', $curso) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="form-card">
                <div class="form-section">
                    <div class="section-title"><i class="bi bi-info-circle-fill text-primary"></i> Informações Básicas</div>
                    <div class="mb-3">
                        <label class="form-label">Nome do Curso <span class="text-danger">*</span></label>
                        <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror"
                               value="{{ old('nome', $curso->nome) }}">
                        @error('nome')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-0">
                        <label class="form-label">Descrição <span class="text-danger">*</span></label>
                        <textarea name="descricao" rows="4" class="form-control @error('descricao') is-invalid @enderror">{{ old('descricao', $curso->descricao) }}</textarea>
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
                                       value="{{ old('carga_horaria', $curso->carga_horaria) }}">
                            </div>
                            @error('carga_horaria')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Nível <span class="text-danger">*</span></label>
                            <select name="nivel" class="form-select @error('nivel') is-invalid @enderror">
                                @foreach(['Iniciante','Intermediário','Avançado'] as $n)
                                    <option value="{{ $n }}" {{ old('nivel',$curso->nivel) == $n ? 'selected' : '' }}>{{ $n }}</option>
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
                                       value="{{ old('preco', $curso->preco) }}">
                            </div>
                            @error('preco')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror">
                                @foreach(['Ativo','Inativo','Em breve'] as $s)
                                    <option value="{{ $s }}" {{ old('status',$curso->status) == $s ? 'selected' : '' }}>{{ $s }}</option>
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
                    @if($curso->imagem)
                    <div class="mb-3 text-center">
                        <img src="{{ Storage::url($curso->imagem) }}" alt="Atual" class="img-fluid rounded" style="max-height:140px;object-fit:cover">
                        <p class="text-muted mt-1" style="font-size:.75rem">Imagem atual</p>
                    </div>
                    @endif
                    <div class="upload-zone" id="upload-zone" onclick="document.getElementById('imagem-input').click()">
                        <input type="file" name="imagem" id="imagem-input" accept="image/*"
                               class="@error('imagem') is-invalid @enderror" onchange="previewImg(this)">
                        <div id="upload-placeholder">
                            <i class="bi bi-cloud-arrow-up-fill upload-icon"></i>
                            <p><strong>Enviar nova imagem</strong><br><span style="font-size:.75rem">Substituirá a atual</span></p>
                        </div>
                        <img id="img-preview" src="" alt="Preview">
                    </div>
                    @error('imagem')<div class="text-danger mt-1" style="font-size:.8rem">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="mt-3 d-grid gap-2">
                <button type="submit" class="btn btn-warning btn-lg fw-bold">
                    <i class="bi bi-check2-circle me-1"></i> Atualizar Curso
                </button>
                <a href="{{ route('cursos.show', $curso) }}" class="btn btn-outline-secondary">Cancelar</a>
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
