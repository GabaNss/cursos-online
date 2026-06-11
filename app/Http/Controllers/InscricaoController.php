<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Curso;
use App\Models\Inscricao;
use Illuminate\Http\Request;

class InscricaoController extends Controller
{
    public function index()
    {
        $inscricoes = Inscricao::with('curso')->latest()->paginate(15);
        return view('inscricoes.index', compact('inscricoes'));
    }

    public function create()
    {
        $cursos = Curso::where('status', 'Ativo')->orderBy('nome')->get();
        return view('inscricoes.create', compact('cursos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'curso_id'       => 'required|exists:cursos,id',
            'aluno'          => 'required|string|max:255',
            'email'          => 'nullable|email|max:255',
            'data_inscricao' => 'required|date',
            'status'         => 'required|in:Pendente,Confirmada,Cancelada',
        ]);

        $inscricao = Inscricao::create($validated);
        ActivityLog::record('create', "Inscrição criada: {$inscricao->aluno} em curso #{$inscricao->curso_id}", 'Inscricao', $inscricao->id);

        return redirect()->route('inscricoes.index')->with('success', 'Inscrição realizada com sucesso!');
    }

    public function edit(Inscricao $inscricao)
    {
        $cursos = Curso::where('status', 'Ativo')->orderBy('nome')->get();
        return view('inscricoes.edit', compact('inscricao', 'cursos'));
    }

    public function update(Request $request, Inscricao $inscricao)
    {
        $validated = $request->validate([
            'curso_id'       => 'required|exists:cursos,id',
            'aluno'          => 'required|string|max:255',
            'email'          => 'nullable|email|max:255',
            'data_inscricao' => 'required|date',
            'status'         => 'required|in:Pendente,Confirmada,Cancelada',
        ]);

        $inscricao->update($validated);
        ActivityLog::record('update', "Inscrição atualizada: {$inscricao->aluno}", 'Inscricao', $inscricao->id);

        return redirect()->route('inscricoes.index')->with('success', 'Inscrição atualizada com sucesso!');
    }

    public function destroy(Inscricao $inscricao)
    {
        $aluno = $inscricao->aluno;
        $id    = $inscricao->id;
        $inscricao->delete();
        ActivityLog::record('delete', "Inscrição excluída: {$aluno}", 'Inscricao', $id);

        return redirect()->route('inscricoes.index')->with('success', 'Inscrição excluída com sucesso!');
    }
}
