@extends('layouts.app')

@section('title', 'Logs de Atividade')

@section('content')
<div class="page-header mb-4">
    <div>
        <h1 class="page-title"><i class="bi bi-journal-text me-2"></i>Logs de Atividade</h1>
        <p class="page-subtitle">{{ $logs->total() }} registros encontrados</p>
    </div>
</div>

{{-- Filtros --}}
<div class="card-edu mb-4">
    <form method="GET" action="{{ route('admin.logs') }}" class="row g-3 align-items-end">
        <div class="col-md-3">
            <label class="form-label fw-semibold small">Ação</label>
            <select name="action" class="form-select">
                <option value="">Todas as ações</option>
                @foreach($actions as $action)
                    <option value="{{ $action }}" {{ request('action') === $action ? 'selected' : '' }}>
                        {{ ucfirst($action) }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label fw-semibold small">Entidade</label>
            <select name="entity" class="form-select">
                <option value="">Todas as entidades</option>
                @foreach($entities as $entity)
                    <option value="{{ $entity }}" {{ request('entity') === $entity ? 'selected' : '' }}>
                        {{ $entity }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label fw-semibold small">Buscar na descrição</label>
            <input type="text" name="search" value="{{ request('search') }}"
                   class="form-control" placeholder="Ex: nome do curso...">
        </div>
        <div class="col-md-2 d-flex gap-2">
            <button type="submit" class="btn-primary-edu flex-fill">
                <i class="bi bi-search"></i>
            </button>
            <a href="{{ route('admin.logs') }}" class="btn btn-outline-secondary flex-fill text-center">
                <i class="bi bi-x-lg"></i>
            </a>
        </div>
    </form>
</div>

<div class="card-edu">
    @if($logs->isEmpty())
        <div class="text-center py-5">
            <i class="bi bi-journal-x" style="font-size:3rem;opacity:.3"></i>
            <p class="mt-3 opacity-50">Nenhum log encontrado para os filtros aplicados.</p>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-edu">
                <thead>
                    <tr>
                        <th>Ação</th>
                        <th>Usuário</th>
                        <th>Entidade</th>
                        <th>Descrição</th>
                        <th>IP</th>
                        <th>Data/Hora</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $log)
                    @php
                        $actionMap = [
                            'create'   => ['success','bi-plus-circle-fill'],
                            'update'   => ['warning','bi-pencil-fill'],
                            'delete'   => ['danger','bi-trash-fill'],
                            'login'    => ['info','bi-box-arrow-in-right'],
                            'logout'   => ['secondary','bi-box-arrow-right'],
                            'register' => ['primary','bi-person-plus-fill'],
                        ];
                        [$color,$icon] = $actionMap[$log->action] ?? ['secondary','bi-circle'];
                    @endphp
                    <tr>
                        <td>
                            <span class="badge bg-{{ $color }}">
                                <i class="bi {{ $icon }} me-1"></i>{{ ucfirst($log->action) }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <span class="user-avatar-sm" style="width:28px;height:28px;font-size:.7rem">
                                    {{ strtoupper(substr($log->user_name ?? 'S', 0, 1)) }}
                                </span>
                                {{ $log->user_name ?? '—' }}
                            </div>
                        </td>
                        <td>
                            @if($log->entity)
                                <span class="badge bg-light text-dark border">
                                    {{ $log->entity }}
                                    @if($log->entity_id) <span class="opacity-50">#{{ $log->entity_id }}</span>@endif
                                </span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>{{ $log->description }}</td>
                        <td><code style="font-size:.78rem">{{ $log->ip_address ?? '—' }}</code></td>
                        <td class="text-nowrap text-muted" style="font-size:.82rem">
                            {{ $log->created_at->format('d/m/Y H:i:s') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $logs->links() }}
        </div>
    @endif
</div>
@endsection
