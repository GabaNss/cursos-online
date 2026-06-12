@extends('layouts.app')
@section('title', 'Catálogo de Cursos')
@section('content')
<div class="hero-banner">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h1 class="mb-2"><i class="bi bi-mortarboard me-2"></i>Catálogo de Cursos</h1>
            <p class="mb-0">Encontre o curso ideal e desenvolva suas habilidades.</p>
        </div>
        @auth
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <a href="{{ route('cursos.create') }}" class="btn btn-light fw-bold px-4">
                <i class="bi bi-plus-lg me-1"></i> Novo Curso
            </a>
        </div>
        @endauth
    </div>
</div>
@php
    $total    = \App\Models\Curso::count();
    $ativos   = \App\Models\Curso::where('status','Ativo')->count();
    $inscritos = \App\Models\Inscricao::count();
@endphp
<div class="row g-3 mb-4">
    <div class="col-sm-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:#eef2ff;color:#4f46e5"><i class="bi bi-collection-fill"></i></div>
            <div><div class="stat-value">{{ $total }}</div><div class="stat-label">Total de Cursos</div></div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:#d1fae5;color:#059669"><i class="bi bi-check-circle-fill"></i></div>
            <div><div class="stat-value">{{ $ativos }}</div><div class="stat-label">Cursos Ativos</div></div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fef3c7;color:#d97706"><i class="bi bi-people-fill"></i></div>
            <div><div class="stat-value">{{ $inscritos }}</div><div class="stat-label">Inscrições Realizadas</div></div>
        </div>
    </div>
</div>
<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
    @forelse($cursos as $curso)
    <div class="col">
        <div class="curso-card">
            <div class="card-thumb">
                @if($curso->imagem)
                    <img src="{{ Storage::url($curso->imagem) }}" alt="{{ $curso->nome }}">
                @else
                    <div class="thumb-placeholder"><i class="bi bi-play-circle-fill"></i><span>SEM IMAGEM</span></div>
                @endif
            </div>
            <div class="card-body">
                @php
                    $nivelClass = match($curso->nivel) { 'Iniciante' => 'badge-iniciante', 'Intermediário' => 'badge-intermediario', 'Avançado' => 'badge-avancado', default => 'badge-iniciante' };
                    $statusClass = match($curso->status) { 'Ativo' => 'badge-ativo', 'Inativo' => 'badge-inativo', 'Em breve' => 'badge-embreve', default => 'badge-inativo' };
                @endphp
                <div class="meta-row">
                    <span class="badge-edu {{ $nivelClass }}"><i class="bi bi-bar-chart-fill"></i> {{ $curso->nivel }}</span>
                    <span class="badge-edu {{ $statusClass }}">{{ $curso->status }}</span>
                </div>
                <div class="card-title">{{ $curso->nome }}</div>
                <div class="card-desc">{{ Str::limit($curso->descricao, 95) }}</div>
                <div class="card-footer-area">
                    <div>
                        @if($curso->preco > 0)
                            <div class="price">R$ {{ number_format($curso->preco, 2, ',', '.') }}</div>
                        @else
                            <div class="price-free"><i class="bi bi-gift-fill me-1"></i>Gratuito</div>
                        @endif
                        <div style="font-size:.78rem;color:var(--muted)"><i class="bi bi-clock me-1"></i>{{ $curso->carga_horaria }}h</div>
                    </div>
                    <div class="d-flex gap-1">
                        <a href="{{ route('cursos.show', $curso) }}" class="btn-action view" title="Ver detalhes"><i class="bi bi-eye-fill"></i></a>
                        @auth
                        @if(Auth::user()->isAdmin())
                        <a href="{{ route('cursos.edit', $curso) }}" class="btn-action edit" title="Editar"><i class="bi bi-pencil-fill"></i></a>
                        <form action="{{ route('cursos.destroy', $curso) }}" method="POST" onsubmit="return confirm('Excluir este curso?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-action del" title="Excluir"><i class="bi bi-trash-fill"></i></button>
                        </form>
                        @endif
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="empty-state">
            <i class="bi bi-collection"></i>
            <h5>Nenhum curso cadastrado</h5>
            <p>Comece adicionando o primeiro curso ao catálogo.</p>
        </div>
    </div>
    @endforelse
</div>
@if($cursos->hasPages())
<div class="d-flex justify-content-center mt-4">{{ $cursos->links() }}</div>
@endif
@endsection
