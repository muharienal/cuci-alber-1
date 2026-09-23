<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Cuci Alber'); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
    <style>
        :root {
            --navy-900: #0a1628;
            --navy-800: #0f2247;
            --navy-700: #15305e;
            --navy-600: #1d3f7a;
            --navy-500: #2c5299;
            --orange-500: #f97316;
            --orange-600: #ea580c;
            --amber-400: #fbbf24;
            --ink: #101827;
            --muted: #64748b;
            --bg: #eef1f7;
            --radius: 20px;
        }
        * { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; }
        html { zoom: 85%; }
        html, body { height: 100%; }
        body {
            margin: 0;
            background:
                radial-gradient(circle at 15% -10%, rgba(249,115,22,.18), transparent 45%),
                radial-gradient(circle at 100% 0%, rgba(29,63,122,.25), transparent 45%),
                var(--bg);
            color: var(--ink);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.9rem 1rem;
        }
        .page-wrap { width: 100%; max-width: 620px; }
        footer.site-footer {
            text-align: center;
            color: var(--muted);
            font-size: .78rem;
            margin-top: .6rem;
            line-height: 1.4;
        }

        .admin-login-fab {
            position: fixed;
            right: 1rem;
            bottom: 1rem;
            z-index: 40;
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            background: var(--navy-900);
            color: #fff;
            text-decoration: none;
            font-size: .8rem;
            font-weight: 700;
            padding: .55rem 1rem;
            border-radius: 999px;
            box-shadow: 0 10px 25px -6px rgba(10,22,40,.5);
            border: 1px solid rgba(255,255,255,.08);
            transition: all .15s;
        }
        .admin-login-fab:hover { background: var(--orange-500); color: #fff; transform: translateY(-2px); }
        .admin-login-fab i { color: var(--amber-400); font-size: .95rem; }
        .admin-login-fab:hover i { color: #fff; }
        @media (max-width: 420px) {
            .admin-login-fab span { display: none; }
            .admin-login-fab { padding: .6rem; }
        }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <div class="page-wrap">
        <?php echo $__env->yieldContent('content'); ?>
        <footer class="site-footer">
            &copy; <?php echo e(date('Y')); ?> IT - AB Wilayah 1 PT Petrokopindo Cipta Selaras
        </footer>
    </div>

    <a href="<?php echo e(route('admin.login')); ?>" class="admin-login-fab" target="_blank" rel="noopener">
        <i class="bi bi-shield-lock-fill"></i> <span>Login Admin</span>
    </a>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH D:\cuci-alber\resources\views/layouts/public.blade.php ENDPATH**/ ?>