@extends('layouts.app')

@section('title', 'Gerenciar Usuários')

@section('content')
<div class="page-header mb-4">
    <div>
        <h1 class="page-title"><i class="bi bi-people-fill me-2"></i>Usuários</h1>
        <p class="page-subtitle">{{ $users->count() }} {{ $users->count() === 1 ? 'usuário encontrado' : 'usuários encontrados' }}</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="btn-primary-edu">
        <i class="bi bi-person-plus-fill me-2"></i>Novo Usuário
    </a>
</div>

{{-- Filtros --}}
<div class="card-edu mb-4">
    <form method="GET" action="{{ route('admin.users') }}" class="row g-3 align-items-end">
        <div class="col-md-6">
            <label class="form-label fw-semibold small">Buscar por nome ou e-mail</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
                <input type="text" name="search" value="{{ request('search') }}"
                       class="form-control" placeholder="Ex: João ou joao@email.com"
                       autofocus>
            </div>
        </div>
        <div class="col-md-3">
            <label class="form-label fw-semibold small">Perfil</label>
            <select name="role" class="form-select">
                <option value="">Todos os perfis</option>
                <option value="admin"  {{ request('role') === 'admin'  ? 'selected' : '' }}>Admin</option>
                <option value="comum"  {{ request('role') === 'comum'  ? 'selected' : '' }}>Comum</option>
            </select>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn-primary-edu flex-fill">
                <i class="bi bi-search me-1"></i>Buscar
            </button>
            @if(request('search') || request('role'))
            <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary flex-fill text-center">
                <i class="bi bi-x-lg"></i>
            </a>
            @endif
        </div>
    </form>
</div>

<div class="card-edu">
    @if($users->isEmpty())
        <div class="text-center py-5">
            <i class="bi bi-people" style="font-size:3rem;opacity:.3"></i>
            <p class="mt-3 opacity-50">Nenhum usuário cadastrado.</p>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-edu">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Perfil</th>
                        <th>Cadastro</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td class="text-muted" style="font-size:.8rem">{{ $user->id }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <span class="user-avatar-sm">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </span>
                                <span class="fw-semibold">{{ $user->name }}</span>
                                @if($user->id === auth()->id())
                                    <span class="badge bg-secondary" style="font-size:.65rem">Você</span>
                                @endif
                            </div>
                        </td>
                        <td><code style="font-size:.82rem">{{ $user->email }}</code></td>
                        <td>
                            @if($user->is_admin)
                                <span class="badge" style="background:var(--gradient);color:#fff">
                                    <i class="bi bi-shield-fill-check me-1"></i>Admin
                                </span>
                            @else
                                <span class="badge bg-secondary">
                                    <i class="bi bi-person-fill me-1"></i>Comum
                                </span>
                            @endif
                        </td>
                        <td class="text-muted" style="font-size:.82rem">{{ $user->created_at->format('d/m/Y') }}</td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn-icon-edu" title="Editar">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                @if($user->id !== auth()->id())
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                      onsubmit="return confirm('Excluir o usuário {{ addslashes($user->name) }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-icon-edu btn-icon-danger" title="Excluir">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
