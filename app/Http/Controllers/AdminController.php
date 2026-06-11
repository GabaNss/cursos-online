<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Curso;
use App\Models\Inscricao;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'usuarios'  => User::count(),
            'cursos'    => Curso::count(),
            'inscricoes'=> Inscricao::count(),
            'logs'      => ActivityLog::count(),
        ];

        $recentLogs = ActivityLog::orderByDesc('created_at')->limit(10)->get();

        return view('admin.dashboard', compact('stats', 'recentLogs'));
    }

    public function users(Request $request)
    {
        $query = User::orderBy('name');

        if ($request->filled('search')) {
            $term = '%' . $request->search . '%';
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', $term)
                  ->orWhere('email', 'like', $term);
            });
        }

        if ($request->filled('role')) {
            $query->where('is_admin', $request->role === 'admin');
        }

        $users = $query->get();
        return view('admin.users', compact('users'));
    }

    public function createUser()
    {
        return view('admin.users-create');
    }

    public function storeUser(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'is_admin' => ['nullable', 'boolean'],
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'is_admin' => $request->boolean('is_admin'),
        ]);

        ActivityLog::record('create', "Usuário criado: {$user->email}", 'User', $user->id);

        return redirect()->route('admin.users')->with('success', 'Usuário criado com sucesso.');
    }

    public function editUser(User $user)
    {
        return view('admin.users-edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'is_admin' => ['nullable', 'boolean'],
        ]);

        $user->name     = $data['name'];
        $user->email    = $data['email'];
        $user->is_admin = $request->boolean('is_admin');

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        ActivityLog::record('update', "Usuário atualizado: {$user->email}", 'User', $user->id);

        return redirect()->route('admin.users')->with('success', 'Usuário atualizado com sucesso.');
    }

    public function destroyUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users')->with('error', 'Você não pode excluir sua própria conta.');
        }

        $email = $user->email;
        $id    = $user->id;
        $user->delete();

        ActivityLog::record('delete', "Usuário excluído: {$email}", 'User', $id);

        return redirect()->route('admin.users')->with('success', 'Usuário excluído com sucesso.');
    }

    public function logs(Request $request)
    {
        $query = ActivityLog::with('user')->orderByDesc('created_at');

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('entity')) {
            $query->where('entity', $request->entity);
        }

        if ($request->filled('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        $logs = $query->paginate(20)->withQueryString();

        $actions  = ActivityLog::distinct()->pluck('action');
        $entities = ActivityLog::distinct()->whereNotNull('entity')->pluck('entity');

        return view('admin.logs', compact('logs', 'actions', 'entities'));
    }
}
