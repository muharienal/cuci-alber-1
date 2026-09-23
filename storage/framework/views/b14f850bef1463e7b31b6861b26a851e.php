<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="theme-color" content="#0a1628">
    <title><?php echo $__env->yieldContent('title', 'Admin'); ?> - Cuci Alber</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <?php echo $__env->yieldPushContent('styles'); ?>
    <style>
        :root {
            --brand: #15305e;
            --brand-dark: #0a1628;
            --brand-light: #eef2f9;
            --accent: #f97316;
            --accent-dark: #ea580c;
            --amber: #fbbf24;
            --ink: #1e2433;
            --muted: #6b7280;
            --topbar-h: 56px;
            --tabbar-h: 64px;
        }
        * { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; }
        html { -webkit-tap-highlight-color: transparent; zoom: 85%; }
        body { background: #f5f6fb; color: var(--ink); overscroll-behavior-y: none; }

        /* ===== Nav links (dipakai sidebar desktop & offcanvas mobile) ===== */
        .nav-links a {
            color: #93a2c2; text-decoration: none; display: flex; align-items: center; gap: .55rem;
            padding: .68rem 1rem; border-radius: 10px; font-size: .92rem; font-weight: 500;
        }
        .nav-links a.active, .nav-links a:hover { background: rgba(249,115,22,.16); color: #fff; }
        .nav-links a.active { border-left: 3px solid var(--accent); }

        /* ===== Sidebar (desktop, >= lg) ===== */
        .sidebar {
            min-height: 100vh; width: 250px; flex: none;
            background: linear-gradient(180deg, #0a1628, #0f2247);
        }
        .sidebar .brand {
            color: #fff; font-weight: 800; padding: 1.2rem 1rem .5rem;
            display: flex; align-items: center; gap: .5rem; font-size: 1rem;
        }
        .sidebar .brand-icon, .brand-icon {
            width: 34px; height: 34px; border-radius: 9px; background: linear-gradient(135deg, var(--accent), var(--amber));
            display: inline-flex; align-items: center; justify-content: center; color: #fff; flex: none;
        }

        .main-wrap { min-width: 0; flex: 1 1 auto; }
        main { padding: 1.75rem; max-width: 1400px; }
        .card, .card-soft { border: none; border-radius: 14px; box-shadow: 0 4px 16px rgba(30,36,51,.06); }
        .btn-primary { background: var(--accent); border-color: var(--accent); }
        .btn-primary:hover { background: var(--accent-dark); border-color: var(--accent-dark); }
        .table thead th { font-size: .78rem; text-transform: uppercase; color: var(--muted); border-bottom-width: 1px; }
        .page-title { font-weight: 800; color: var(--brand-dark); }

        /* ===== Mobile top app bar (native-app style) ===== */
        .mobile-topbar {
            position: sticky; top: 0; z-index: 1030; height: var(--topbar-h);
            background: linear-gradient(120deg, var(--brand-dark), var(--brand));
            display: flex; align-items: center; gap: .5rem; padding: 0 .5rem 0 .25rem;
            box-shadow: 0 2px 10px rgba(10,22,40,.2);
        }
        .mobile-topbar .btn-hamburger {
            background: transparent; border: none; color: #fff; font-size: 1.4rem;
            width: 44px; height: 44px; display: flex; align-items: center; justify-content: center;
        }
        .mobile-topbar .mobile-brand {
            color: #fff; font-weight: 800; font-size: 1rem; display: flex; align-items: center; gap: .5rem;
        }

        /* ===== Offcanvas drawer (mobile menu) ===== */
        #mobileDrawer { background: linear-gradient(180deg, #0a1628, #0f2247); width: 270px; }
        #mobileDrawer .offcanvas-header { padding: 1rem 1rem .5rem; }
        #mobileDrawer .offcanvas-body { padding: .5rem 1rem 1.25rem; }

        /* ===== Bottom tab bar (native-app style, mobile only) ===== */
        .bottom-tabbar {
            position: fixed; left: 0; right: 0; bottom: 0; z-index: 1030;
            height: var(--tabbar-h);
            padding-bottom: env(safe-area-inset-bottom, 0);
            background: #fff; border-top: 1px solid #e5e9f2;
            box-shadow: 0 -6px 20px rgba(10,22,40,.08);
            display: flex; align-items: stretch;
        }
        .tab-item {
            flex: 1 1 0; display: flex; flex-direction: column; align-items: center; justify-content: center;
            gap: .15rem; color: #94a3b8; text-decoration: none; font-size: .68rem; font-weight: 600;
            background: transparent; border: none; padding: .3rem 0;
        }
        .tab-item i { font-size: 1.22rem; line-height: 1; }
        .tab-item.active { color: var(--accent); }
        .tab-item.active i { transform: translateY(-1px); }

        /* Beri ruang konten paling bawah supaya tidak ketutup bottom tab bar */
        @media (max-width: 991.98px) {
            main { padding: 1.1rem .9rem calc(var(--tabbar-h) + 1.5rem); }
            .page-title { font-size: 1.15rem; }
            .card-body { padding: 1rem; }
            .table { font-size: .88rem; }
            .btn { font-size: .88rem; }
        }
    </style>
</head>
<body>
<div class="d-flex">
    
    <div class="sidebar d-none d-lg-flex flex-column p-2">
        <div class="brand"><span class="brand-icon"><i class="bi bi-truck-front"></i></span> Admin Cuci Alber</div>
        <div class="p-2">
            <?php echo $__env->make('admin.partials.nav-links', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    </div>

    <div class="main-wrap">
        
        <header class="mobile-topbar d-lg-none">
            <button class="btn-hamburger" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileDrawer" aria-label="Buka menu">
                <i class="bi bi-list"></i>
            </button>
            <span class="mobile-brand"><span class="brand-icon"><i class="bi bi-truck-front" style="font-size:.9rem;"></i></span> Cuci Alber</span>
        </header>

        <main>
            <h4 class="mb-3 page-title"><?php echo $__env->yieldContent('title'); ?></h4>

            <?php if(session('success')): ?>
                <div class="alert alert-success"><?php echo e(session('success')); ?></div>
            <?php endif; ?>
            <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>
</div>


<div class="offcanvas offcanvas-start" tabindex="-1" id="mobileDrawer">
    <div class="offcanvas-header">
        <div class="brand" style="padding:0;"><span class="brand-icon"><i class="bi bi-truck-front"></i></span> <span class="text-white fw-bold">Admin Cuci Alber</span></div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Tutup"></button>
    </div>
    <div class="offcanvas-body">
        <?php echo $__env->make('admin.partials.nav-links', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
</div>


<nav class="bottom-tabbar d-lg-none">
    <a href="<?php echo e(route('admin.dashboard')); ?>" class="tab-item <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
        <i class="bi bi-speedometer2"></i> Beranda
    </a>
    <a href="<?php echo e(route('admin.unitAlats.index')); ?>" class="tab-item <?php echo e(request()->routeIs('admin.unitAlats.*') ? 'active' : ''); ?>">
        <i class="bi bi-forklift"></i> Unit
    </a>
    <a href="<?php echo e(route('admin.operators.index')); ?>" class="tab-item <?php echo e(request()->routeIs('admin.operators.*') ? 'active' : ''); ?>">
        <i class="bi bi-people"></i> Operator
    </a>
    <a href="<?php echo e(route('admin.submissions.index')); ?>" class="tab-item <?php echo e(request()->routeIs('admin.submissions.*') ? 'active' : ''); ?>">
        <i class="bi bi-clipboard-data"></i> Data
    </a>
    <button type="button" class="tab-item" data-bs-toggle="offcanvas" data-bs-target="#mobileDrawer">
        <i class="bi bi-grid-3x3-gap-fill"></i> Menu
    </button>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH D:\cuci-alber\resources\views/layouts/admin.blade.php ENDPATH**/ ?>