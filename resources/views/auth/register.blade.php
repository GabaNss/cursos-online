<!DOCTYPE html>
<html lang="pt-BR" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Conta — EduCursos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="/css/app.css" rel="stylesheet">
    <script>(function(){const t=localStorage.getItem('edu-theme')||'light';document.documentElement.setAttribute('data-theme',t);})();</script>
</head>
<body>
<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-header">
            <div class="brand-logo"><i class="bi bi-person-plus-fill"></i></div>
            <h2>Criar Conta</h2>
            <p>Cadastre-se para gerenciar o sistema</p>
        </div>
        <div class="auth-body">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nome</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}" autofocus>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">E-mail</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Senha</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label">Confirmar Senha</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
                    <i class="bi bi-check2-circle me-1"></i> Criar Conta
                </button>
            </form>
            <hr class="my-4">
            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('login') }}" class="text-muted" style="font-size:.875rem">
                    Já tem conta? <strong>Entrar</strong>
                </a>
                <button onclick="toggleTheme()" class="btn-theme-toggle" style="border-color:var(--border)" title="Alternar tema">
                    <i class="bi bi-moon-fill" id="themeIcon"></i>
                </button>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function toggleTheme() {
    const html = document.documentElement;
    const next = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
    html.setAttribute('data-theme', next);
    localStorage.setItem('edu-theme', next);
    document.getElementById('themeIcon').className = next === 'dark' ? 'bi bi-sun-fill' : 'bi bi-moon-fill';
}
(function(){
    const t = localStorage.getItem('edu-theme') || 'light';
    document.getElementById('themeIcon').className = t === 'dark' ? 'bi bi-sun-fill' : 'bi bi-moon-fill';
})();
</script>
</body>
</html>
