<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Curso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CursoController extends Controller
{
    public function index()
    {
        $cursos = Curso::latest()->paginate(9);
        return view('cursos.index', compact('cursos'));
    }

    public function show(Curso $curso)
    {
        $inscricoes = $curso->inscricoes()->latest()->get();
        return view('cursos.show', compact('curso', 'inscricoes'));
    }

    public function create()
    {
        return view('cursos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome'          => 'required|string|max:255',
            'descricao'     => 'required|string',
            'carga_horaria' => 'required|integer|min:1',
            'nivel'         => 'required|in:Iniciante,Intermediário,Avançado',
            'preco'         => 'required|numeric|min:0',
            'imagem'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'        => 'required|in:Ativo,Inativo,Em breve',
        ]);

        if ($request->hasFile('imagem')) {
            $validated['imagem'] = $request->file('imagem')->store('cursos', 'public');
        }

        $curso = Curso::create($validated);
        ActivityLog::record('create', "Curso criado: {$curso->nome}", 'Curso', $curso->id);

        return redirect()->route('cursos.index')->with('success', 'Curso cadastrado com sucesso!');
    }

    public function edit(Curso $curso)
    {
        return view('cursos.edit', compact('curso'));
    }

    public function update(Request $request, Curso $curso)
    {
        $validated = $request->validate([
            'nome'          => 'required|string|max:255',
            'descricao'     => 'required|string',
            'carga_horaria' => 'required|integer|min:1',
            'nivel'         => 'required|in:Iniciante,Intermediário,Avançado',
            'preco'         => 'required|numeric|min:0',
            'imagem'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'        => 'required|in:Ativo,Inativo,Em breve',
        ]);

        if ($request->hasFile('imagem')) {
            if ($curso->imagem) {
                Storage::disk('public')->delete($curso->imagem);
            }
            $validated['imagem'] = $request->file('imagem')->store('cursos', 'public');
        }

        $curso->update($validated);
        ActivityLog::record('update', "Curso atualizado: {$curso->nome}", 'Curso', $curso->id);

        return redirect()->route('cursos.index')->with('success', 'Curso atualizado com sucesso!');
    }

    public function destroy(Curso $curso)
    {
        $nome = $curso->nome;
        $id   = $curso->id;

        if ($curso->imagem) {
            Storage::disk('public')->delete($curso->imagem);
        }

        $curso->delete();
        ActivityLog::record('delete', "Curso excluído: {$nome}", 'Curso', $id);

        return redirect()->route('cursos.index')->with('success', 'Curso excluído com sucesso!');
    }
}
