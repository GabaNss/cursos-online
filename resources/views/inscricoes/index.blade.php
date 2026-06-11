@extends('layouts.app')
@section('title', 'Inscrições')
@section('content')
<div class="page-header">
    <div>
        <h1><i class="bi bi-people-fill me-2 text-primary"></i>Inscrições</h1>
        <p>{{ $inscricoes->total() }} inscrição(ões) registrada(s) no sistema.</p>
    </div>
    @auth
    <a href="{{ route('inscricoes.create') }}" class="btn btn-primary fw-semibold">
        <i class="bi bi-person-plus-fill me-1"></i> Nova Inscrição
    </a>
    @endauth
</div>

<div class="table-card">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Aluno</th>
                <th>Curso</th>
                <th>Data</th>
                <th>Status</th>
                @auth<th class="text-center">Ações</th>@endauth
            </tr>
        </thead>
        <tbody>
            @forelse($inscricoes as $inscricao)
            <tr>
                <td class="text-muted" style="font-size:.8rem">{{ $inscricao->id }}</td>
                <td>
                    <div class="fw-semibold">{{ $inscricao->aluno }}</div>
                    @if($inscricao->email)
                        <div style="font-size:.78rem;color:var(--muted)"><i class="bi bi-envelope me-1"></i>{{ $inscricao->email }}</div>
                    @endif
                </td>
                <td>
                    <a href="{{ route('cursos.show', $inscricao->curso) }}" class="fw-semibold" style="color:var(--primary)">
                        {{ $inscricao->curso->nome }}
                    </a>
                    <div style="font-size:.78rem;color:var(--muted)">{{ $inscricao->curso->nivel }}</div>
                </td>
                <td>
                    <i class="bi bi-calendar3 me-1 text-muted"></i>
                    {{ \Carbon\Carbon::parse($inscricao->data_inscricao)->format('d/m/Y') }}
                </td>
                <td>
                    @php $sc = match($inscricao->status) { 'Confirmada' => 'badge-confirmada', 'Cancelada' => 'badge-cancelada', default => 'badge-pendente' }; @endphp
                    <span class="badge-edu {{ $sc }}">{{ $inscricao->status }}</span>
                </td>
                @auth
                <td>
                    <div class="d-flex gap-1 justify-content-center">
                        <a href="{{ route('inscricoes.edit', $inscricao) }}" class="btn-action edit" title="Editar">
                            <i class="bi bi-pencil-fill"></i>
                        </a>
                        <form action="{{ route('inscricoes.destroy', $inscricao) }}" method="POST"
                              onsubmit="return confirm('Excluir esta inscrição?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-action del" title="Excluir">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </form>
                    </div>
                </td>
                @endauth
            </tr>
            @empty
            <tr>
                <td colspan="6">
                    <div class="empty-state">
                        <i class="bi bi-inbox"></i>
                        <h5>Nenhuma inscrição encontrada</h5>
                        <p>As inscrições aparecerão aqui.</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($inscricoes->hasPages())
<div class="d-flex justify-content-center mt-4">{{ $inscricoes->links() }}</div>
@endif
@endsection
