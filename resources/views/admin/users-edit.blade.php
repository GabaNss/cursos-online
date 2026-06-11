@extends('layouts.app')

@section('title', 'Editar Usuário')

@section('content')
<div class="page-header mb-4">
    <div>
        <h1 class="page-title"><i class="bi bi-pencil-square me-2"></i>Editar Usuário</h1>
        <p class="page-subtitle">{{ $user->name }}</p>
    </div>
    <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Voltar
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card-edu">
            <form method="POST" action="{{ route('admin.users.update', $user) }}">
                @csrf @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nome <span class="text-danger">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                           class="form-control @error('name') is-invalid @enderror"
                           placeholder="Nome completo" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">E-mail <span class="text-danger">*</span></label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="usuario@exemplo.com" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nova Senha</label>
                    <input type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Deixe em branco para manter a atual">
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Confirmar Nova Senha</label>
                    <input type="password" name="password_confirmation"
                           class="form-control"
                           placeholder="Repita a nova senha">
                </div>

                <div class="mb-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_admin" id="is_admin"
                               value="1" {{ old('is_admin', $user->is_admin) ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="is_admin">
                            <i class="bi bi-shield-fill-check text-warning me-1"></i>
                            Privilégios de administrador
                        </label>
                    </div>
                    <div class="form-text">Administradores têm acesso ao painel de controle e podem gerenciar usuários.</div>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        <i class="bi bi-calendar3 me-1"></i>
                        Cadastrado em {{ $user->created_at->format('d/m/Y') }}
                    </small>
                    <div class="d-flex gap-3">
                        <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn-primary-edu">
                            <i class="bi bi-check-lg me-2"></i>Salvar Alterações
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
