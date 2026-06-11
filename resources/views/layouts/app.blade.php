<!DOCTYPE html>
<html lang="pt-BR" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'EduCursos') — EduCursos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="/css/app.css" rel="stylesheet">
    {{-- Aplica tema salvo antes do render para evitar flash --}}
    <script>
        (function() {
            const t = localStorage.getItem('edu-theme') || 'light';
            document.documentElement.setAttribute('data-theme', t);
        })();
    </script>
</head>
<body>

<nav class="navbar navbar-edu navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="{{ route('cursos.index') }}">
            <span class="brand-icon"><i class="bi bi-mortarboard-fill"></i></span>
            EduCursos
        </a>

        <div class="d-flex align-items-center gap-2 d-lg-none">
            <button class="btn-theme-toggle" id="themeToggleMobile" title="Alternar tema">
                <i class="bi bi-moon-fill" id="themeIconMobile"></i>
            </button>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-2">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('cursos.index','cursos.show') ? 'active' : '' }}"
                       href="{{ route('cursos.index') }}">
                        <i class="bi bi-grid-fill"></i> Cursos
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('inscricoes.index') ? 'active' : '' }}"
                       href="{{ route('inscricoes.index') }}">
                        <i class="bi bi-people-fill"></i> Inscrições
                    </a>
                </li>
                @auth
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('cursos.create') ? 'active' : '' }}"
                       href="{{ route('cursos.create') }}">
                        <i class="bi bi-plus-circle-fill"></i> Novo Curso
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('inscricoes.create') ? 'active' : '' }}"
                       href="{{ route('inscricoes.create') }}">
                        <i class="bi bi-person-plus-fill"></i> Nova Inscrição
                    </a>
                </li>
                @if(Auth::user()->isAdmin())
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('admin.*') ? 'active' : '' }}"
                       href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-shield-fill-check"></i> Admin
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-speedometer2 me-2"></i>Dashboard
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.users') }}">
                                <i class="bi bi-people-fill me-2"></i>Usuários
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.logs') }}">
                                <i class="bi bi-journal-text me-2"></i>Logs
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
                @endauth
            </ul>


            <ul class="navbar-nav ms-auto align-items-center gap-2">
                {{-- Toggle tema desktop --}}
                <li class="nav-item d-none d-lg-block">
                    <button class="btn-theme-toggle" id="themeToggleDesktop" title="Alternar tema">
                        <i class="bi bi-moon-fill" id="themeIconDesktop"></i>
                    </button>
                </li>

                @auth
                    <li class="nav-item dropdown">
                        <div class="user-pill dropdown-toggle" data-bs-toggle="dropdown">
                            <span class="user-avatar"><i class="bi bi-person-fill"></i></span>
                            {{ Auth::user()->name }}
                            <i class="bi bi-chevron-down" style="font-size:.6rem;opacity:.7"></i>
                        </div>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <span class="dropdown-item" style="font-size:.78rem;cursor:default;opacity:.6">
                                    {{ Auth::user()->email }}
                                </span>
                            </li>
                            <li><hr class="dropdown-divider my-1"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right"></i> Sair
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="btn-login">
                            <i class="bi bi-box-arrow-in-right me-1"></i>Entrar
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-3">
    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center gap-2 alert-dismissible fade show">
            <i class="bi bi-check-circle-fill"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger d-flex align-items-center gap-2 alert-dismissible fade show">
            <i class="bi bi-exclamation-circle-fill"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
</div>

<main class="main-content">
    <div class="container">
        @yield('content')
    </div>
</main>

<footer class="site-footer">
    <i class="bi bi-mortarboard-fill me-1"></i>
    <strong style="color:rgba(255,255,255,.6)">EduCursos</strong> &copy; {{ date('Y') }}
    &nbsp;·&nbsp; Sistema de Gestão de Cursos Online
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
(function () {
    const html    = document.documentElement;
    const KEY     = 'edu-theme';
    const icons   = [
        document.getElementById('themeIconDesktop'),
        document.getElementById('themeIconMobile'),
    ].filter(Boolean);
    const buttons = [
        document.getElementById('themeToggleDesktop'),
        document.getElementById('themeToggleMobile'),
    ].filter(Boolean);

    function applyTheme(theme) {
        html.setAttribute('data-theme', theme);
        localStorage.setItem(KEY, theme);
        icons.forEach(icon => {
            icon.className = theme === 'dark' ? 'bi bi-sun-fill' : 'bi bi-moon-fill';
        });
        buttons.forEach(btn => {
            btn.title = theme === 'dark' ? 'Modo claro' : 'Modo escuro';
        });
    }

    // Inicializa com o tema salvo
    applyTheme(localStorage.getItem(KEY) || 'light');

    // Listeners nos botões
    buttons.forEach(btn => {
        btn.addEventListener('click', () => {
            const next = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
            applyTheme(next);
        });
    });
})();
</script>

@stack('scripts')
</body>
</html>
