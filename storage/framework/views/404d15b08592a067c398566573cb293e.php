<nav class="nav-links d-flex flex-column gap-1">
    <a href="<?php echo e(route('admin.dashboard')); ?>" class="<?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="<?php echo e(route('admin.zonas.index')); ?>" class="<?php echo e(request()->routeIs('admin.zonas.*') ? 'active' : ''); ?>"><i class="bi bi-map"></i> Zona</a>
    <a href="<?php echo e(route('admin.areaKerjas.index')); ?>" class="<?php echo e(request()->routeIs('admin.areaKerjas.*') ? 'active' : ''); ?>"><i class="bi bi-geo-alt"></i> Area Kerja</a>
    <a href="<?php echo e(route('admin.unitKerjas.index')); ?>" class="<?php echo e(request()->routeIs('admin.unitKerjas.*') ? 'active' : ''); ?>"><i class="bi bi-diagram-3"></i> Unit Kerja</a>
    <a href="<?php echo e(route('admin.jenisAlats.index')); ?>" class="<?php echo e(request()->routeIs('admin.jenisAlats.*') ? 'active' : ''); ?>"><i class="bi bi-truck"></i> Jenis Alat</a>
    <a href="<?php echo e(route('admin.unitAlats.index')); ?>" class="<?php echo e(request()->routeIs('admin.unitAlats.*') ? 'active' : ''); ?>"><i class="bi bi-forklift"></i> Unit Alat &amp; Operator</a>
    <a href="<?php echo e(route('admin.operators.index')); ?>" class="<?php echo e(request()->routeIs('admin.operators.*') ? 'active' : ''); ?>"><i class="bi bi-people"></i> Operator</a>
    <a href="<?php echo e(route('admin.pengawas.index')); ?>" class="<?php echo e(request()->routeIs('admin.pengawas.*') ? 'active' : ''); ?>"><i class="bi bi-person-badge"></i> Pengawas</a>
    <a href="<?php echo e(route('admin.submissions.index')); ?>" class="<?php echo e(request()->routeIs('admin.submissions.*') ? 'active' : ''); ?>"><i class="bi bi-clipboard-data"></i> Data Cuci Alat</a>
    <hr class="border-secondary opacity-25 my-2">
    <a href="<?php echo e(route('form.index')); ?>" target="_blank"><i class="bi bi-box-arrow-up-right"></i> Lihat Form Publik</a>
    <form method="POST" action="<?php echo e(route('admin.logout')); ?>" class="mt-2 px-1">
        <?php echo csrf_field(); ?>
        <button type="submit" class="btn btn-sm btn-outline-light w-100"><i class="bi bi-box-arrow-right"></i> Logout (<?php echo e(auth()->user()->name); ?>)</button>
    </form>
</nav>
<?php /**PATH D:\cuci-alber\resources\views/admin/partials/nav-links.blade.php ENDPATH**/ ?>