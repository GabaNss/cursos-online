@extends('layouts.app')

@section('title', 'Painel Administrativo')

@section('content')
<div class="page-header mb-4">
    <div>
        <h1 class="page-title"><i class="bi bi-speedometer2 me-2"></i>Painel Administrativo</h1>
        <p class="page-subtitle">Visão geral do sistema</p>
    </div>
</div>

{{-- Stat cards --}}
<div class="row g-4 mb-5">
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(255,137,6,.15);color:#ff8906">
                <i class="bi bi-people-fill"></i>
            </div>
            <div class="stat-value">{{ $stats['usuarios'] }}</div>
            <div class="stat-label">Usuários</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(242,95,76,.15);color:#f25f4c">
                <i class="bi bi-mortarboard-fill"></i>
            </div>
            <div class="stat-value">{{ $stats['cursos'] }}</div>
            <div class="stat-label">Cursos</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(229,49,112,.15);color:#e53170">
                <i class="bi bi-person-check-fill"></i>
            </div>
            <div class="stat-value">{{ $stats['inscricoes'] }}</div>
            <div class="stat-label">Inscrições</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(100,220,100,.15);color:#3ddc84">
                <i class="bi bi-journal-text"></i>
            </div>
            <div class="stat-value">{{ $stats['logs'] }}</div>
            <div class="stat-label">Registros de Log</div>
        </div>
    </div>
</div>

{{-- Quick access --}}
<div class="row g-4 mb-5">
    <div class="col-md-6">
        <a href="{{ route('admin.users') }}" class="text-decoration-none">
            <div class="admin-quick-card">
                <i class="bi bi-people-fill fs-2 mb-3 text-warning"></i>
                <h5 class="fw-bold">Gerenciar Usuários</h5>
                <p class="mb-0 opacity-75 small">Criar, editar e excluir contas. Definir permissões de administrador.</p>
            </div>
        </a>
    </div>
    <div class="col-md-6">
        <a href="{{ route('admin.logs') }}" class="text-decoration-none">
            <div class="admin-quick-card">
                <i class="bi bi-journal-text fs-2 mb-3 text-info"></i>
                <h5 class="fw-bold">Logs de Atividade</h5>
                <p class="mb-0 opacity-75 small">Histórico completo de ações realizadas no sistema.</p>
            </div>
        </a>
    </div>
</div>

{{-- Recent activity --}}
<div class="card-edu">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h5 class="fw-bold mb-0"><i class="bi bi-clock-history me-2"></i>Atividade Recente</h5>
        <a href="{{ route('admin.logs') }}" class="btn btn-sm btn-outline-secondary">Ver todos</a>
    </div>
    @if($recentLogs->isEmpty())
        <p class="text-muted text-center py-3">Nenhuma atividade registrada ainda.</p>
    @else
        <div class="table-responsive">
            <table class="table table-edu">
                <thead>
                    <tr>
                        <th>Ação</th>
                        <th>Usuário</th>
                        <th>Descrição</th>
                        <th>IP</th>
                        <th>Data</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentLogs as $log)
                    <tr>
                        <td>
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
                            <span class="badge bg-{{ $color }}">
                                <i class="bi {{ $icon }} me-1"></i>{{ ucfirst($log->action) }}
                            </span>
                        </td>
                        <td>{{ $log->user_name }}</td>
                        <td class="text-truncate" style="max-width:250px">{{ $log->description }}</td>
                        <td><code>{{ $log->ip_address }}</code></td>
                        <td class="text-nowrap">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
