@extends('layouts.app')
@section('title', $curso->nome)
@section('content')
<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('cursos.index') }}"><i class="bi bi-house-fill"></i> Cursos</a></li>
        <li class="breadcrumb-item active">{{ Str::limit($curso->nome, 40) }}</li>
    </ol>
</nav>
<div class="row g-4">
    <div class="col-lg-8">
        <div class="detail-card">
            @if($curso->imagem)
                <div class="detail-thumb"><img src="{{ Storage::url($curso->imagem) }}" alt="{{ $curso->nome }}"></div>
            @else
                <div class="detail-thumb-placeholder"><i class="bi bi-play-circle-fill"></i></div>
            @endif
            <div class="detail-body">
                @php
                    $nivelClass = match($curso->nivel) { 'Iniciante' => 'badge-iniciante', 'Intermediário' => 'badge-intermediario', 'Avançado' => 'badge-avancado', default => 'badge-iniciante' };
                    $statusClass = match($curso->status) { 'Ativo' => 'badge-ativo', 'Inativo' => 'badge-inativo', 'Em breve' => 'badge-embreve', default => 'badge-inativo' };
                @endphp
                <div class="d-flex flex-wrap gap-2 mb-3">
                    <span class="badge-edu {{ $nivelClass }}"><i class="bi bi-bar-chart-fill"></i> {{ $curso->nivel }}</span>
                    <span class="badge-edu {{ $statusClass }}">{{ $curso->status }}</span>
                </div>
                <h1 class="detail-title mb-3">{{ $curso->nome }}</h1>
                <p class="text-muted" style="font-size:.95rem;line-height:1.7">{{ $curso->descricao }}</p>
                <div class="row g-3 mt-1">
                    <div class="col-4">
                        <div class="info-box">
                            <div class="info-value">{{ $curso->carga_horaria }}h</div>
                            <div class="info-label">Carga Horária</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="info-box">
                            <div class="info-value">{{ $inscricoes->count() }}</div>
                            <div class="info-label">Inscritos</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="info-box">
                            @if($curso->preco > 0)
                                <div class="info-value">R$ {{ number_format($curso->preco, 2, ',', '.') }}</div>
                            @else
                                <div class="info-value" style="color:var(--success)">Grátis</div>
                            @endif
                            <div class="info-label">Investimento</div>
                        </div>
                    </div>
                </div>
                @auth
                <div class="d-flex gap-2 mt-4 pt-3 border-top">
                    @if(Auth::user()->isAdmin())
                    <a href="{{ route('cursos.edit', $curso) }}" class="btn btn-warning fw-semibold">
                        <i class="bi bi-pencil-fill me-1"></i> Editar Curso
                    </a>
                    <form action="{{ route('cursos.destroy', $curso) }}" method="POST"
                          onsubmit="return confirm('Excluir este curso e todas as inscrições?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-outline-danger fw-semibold">
                            <i class="bi bi-trash-fill me-1"></i> Excluir
                        </button>
                    </form>
                    @endif
                    <a href="{{ route('inscricoes.create') }}?curso_id={{ $curso->id }}"
                       class="btn btn-primary fw-semibold ms-auto">
                        <i class="bi bi-person-plus-fill me-1"></i> Inscrever-se
                    </a>
                </div>
                @endauth
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="detail-card">
            <div class="detail-body" style="padding:1.25rem 1.5rem">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0"><i class="bi bi-list-check me-1 text-primary"></i> Inscrições</h6>
                    <span class="badge-edu badge-ativo">{{ $inscricoes->count() }} total</span>
                </div>
                @forelse($inscricoes as $inscricao)
                <div class="inscricao-item">
                    <div>
                        <div class="fw-semibold" style="font-size:.875rem">{{ $inscricao->aluno }}</div>
                        <div style="font-size:.75rem;color:var(--muted)">
                            <i class="bi bi-calendar3 me-1"></i>
                            {{ \Carbon\Carbon::parse($inscricao->data_inscricao)->format('d/m/Y') }}
                        </div>
                    </div>
                    @php $sc = match($inscricao->status) { 'Confirmada' => 'badge-confirmada', 'Cancelada' => 'badge-cancelada', default => 'badge-pendente' }; @endphp
                    <span class="badge-edu {{ $sc }}">{{ $inscricao->status }}</span>
                </div>
                @empty
                <div class="empty-state" style="padding:2rem 1rem">
                    <i class="bi bi-inbox" style="font-size:2rem;opacity:.3;display:block;margin-bottom:.5rem"></i>
                    <p style="font-size:.85rem;margin:0">Nenhuma inscrição ainda.</p>
                </div>
                @endforelse
                @auth
                <div class="mt-3 pt-3 border-top">
                    <a href="{{ route('inscricoes.create') }}?curso_id={{ $curso->id }}"
                       class="btn btn-primary btn-sm w-100 fw-semibold">
                        <i class="bi bi-plus-lg me-1"></i> Inscrever Aluno
                    </a>
                </div>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection
