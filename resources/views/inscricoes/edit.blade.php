@extends('layouts.app')
@section('title', 'Editar Inscrição')
@section('content')
<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('inscricoes.index') }}">Inscrições</a></li>
        <li class="breadcrumb-item active">Editar Inscrição #{{ $inscricao->id }}</li>
    </ol>
</nav>
<div class="page-header">
    <div>
        <h1><i class="bi bi-pencil-fill me-2 text-warning"></i>Editar Inscrição</h1>
        <p>Atualize os dados da inscrição de <strong>{{ $inscricao->aluno }}</strong>.</p>
    </div>
    <a href="{{ route('inscricoes.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Voltar
    </a>
</div>
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="form-card">
            <div class="form-section">
                <div class="section-title"><i class="bi bi-book-fill text-primary"></i> Dados da Inscrição</div>
                <form action="{{ route('inscricoes.update', $inscricao) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Curso <span class="text-danger">*</span></label>
                        <select name="curso_id" class="form-select @error('curso_id') is-invalid @enderror">
                            @foreach($cursos as $curso)
                            <option value="{{ $curso->id }}"
                                {{ old('curso_id', $inscricao->curso_id) == $curso->id ? 'selected' : '' }}>
                                {{ $curso->nome }} — {{ $curso->nivel }}
                            </option>
                            @endforeach
                        </select>
                        @error('curso_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nome do Aluno <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                            <input type="text" name="aluno" class="form-control @error('aluno') is-invalid @enderror"
                                   value="{{ old('aluno', $inscricao->aluno) }}">
                        </div>
                        @error('aluno')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">E-mail</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', $inscricao->email) }}">
                        </div>
                        @error('email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Data de Inscrição <span class="text-danger">*</span></label>
                            <input type="date" name="data_inscricao"
                                   class="form-control @error('data_inscricao') is-invalid @enderror"
                                   value="{{ old('data_inscricao', $inscricao->data_inscricao) }}">
                            @error('data_inscricao')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror">
                                @foreach(['Pendente','Confirmada','Cancelada'] as $s)
                                    <option value="{{ $s }}" {{ old('status',$inscricao->status) == $s ? 'selected' : '' }}>{{ $s }}</option>
                                @endforeach
                            </select>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="d-flex gap-2 pt-2 border-top">
                        <button type="submit" class="btn btn-warning fw-bold px-4">
                            <i class="bi bi-check2-circle me-1"></i> Atualizar Inscrição
                        </button>
                        <a href="{{ route('inscricoes.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
