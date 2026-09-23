<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Cuci Alber</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        :root {
            --navy-900: #0a1628; --navy-800: #0f2247; --navy-700: #15305e; --navy-500: #2c5299;
            --orange-500: #f97316; --orange-600: #ea580c; --amber-400: #fbbf24;
        }
        * { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; }
        html { zoom: 85%; }
        html, body { height: 100%; margin: 0; }
        body {
            background:
                radial-gradient(circle at 15% -10%, rgba(249,115,22,.22), transparent 45%),
                radial-gradient(circle at 100% 110%, rgba(44,82,153,.35), transparent 45%),
                linear-gradient(160deg, var(--navy-900), var(--navy-800) 60%, var(--navy-700));
            min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 1rem;
        }
        .login-card {
            max-width: 400px; width: 100%; border: none; border-radius: 20px;
            box-shadow: 0 25px 60px -15px rgba(0,0,0,.5);
        }
        .login-card::before { content: none; }
        .brand-icon {
            width: 58px; height: 58px; border-radius: 16px;
            background: linear-gradient(135deg, var(--orange-500), var(--amber-400));
            display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;
            box-shadow: 0 10px 22px -6px rgba(249,115,22,.5);
        }
        .form-control { border-radius: 12px; padding: .65rem .9rem; border: 1.6px solid #dbe2ee; }
        .form-control:focus { border-color: var(--navy-500); box-shadow: 0 0 0 .2rem rgba(29,63,122,.14); }
        .btn-login {
            background: var(--navy-800); border-color: var(--navy-800); border-radius: 12px;
            font-weight: 700; padding: .7rem; color: #fff;
        }
        .btn-login:hover { background: var(--navy-900); border-color: var(--navy-900); color: #fff; }
    </style>
</head>
<body>
    <div class="login-card card">
        <div class="card-body p-4 p-sm-5">
            <div class="brand-icon"><i class="bi bi-truck-front fs-4 text-white"></i></div>
            <h5 class="card-title mb-1 text-center fw-bold" style="color: var(--navy-900);">Login Admin</h5>
            <p class="text-muted text-center small">Cuci Alber — Form Cuci Alat Berat</p>

            @if ($errors->any())
                <div class="alert alert-danger py-2 small">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label small fw-semibold" style="color: var(--navy-800);">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-semibold" style="color: var(--navy-800);">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="form-check mb-3">
                    <input type="checkbox" name="remember" class="form-check-input" id="remember">
                    <label class="form-check-label small" for="remember">Ingat saya</label>
                </div>
                <button type="submit" class="btn btn-login w-100">Login</button>
            </form>
            <div class="text-center mt-3">
                <a href="{{ route('form.index') }}" class="small text-decoration-none" style="color: var(--navy-600);">&larr; Kembali ke form publik</a>
            </div>
        </div>
    </div>
</body>
</html>
