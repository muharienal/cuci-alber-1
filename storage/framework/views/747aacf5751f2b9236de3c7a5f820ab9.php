<?php $__env->startSection('title', 'Master Zona'); ?>

<?php $__env->startSection('content'); ?>
<div class="card shadow-sm mb-3">
    <div class="card-body">
        <h6 class="card-title">Tambah Zona Baru</h6>
        <form method="POST" action="<?php echo e(route('admin.zonas.store')); ?>" class="row g-2">
            <?php echo csrf_field(); ?>
            <div class="col-md-8">
                <input type="text" name="nama" class="form-control" placeholder="Contoh: ZONA 1A" required>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100">Tambah</button>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th style="width:60px">#</th>
                    <th>Nama Zona</th>
                    <th>Jumlah Area Kerja</th>
                    <th style="width:160px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $zonas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $zona): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($i + 1); ?></td>
                        <td><?php echo e($zona->nama); ?></td>
                        <td><?php echo e($zona->area_kerjas_count); ?></td>
                        <td>
                            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editZona<?php echo e($zona->id); ?>">Edit</button>
                            <form action="<?php echo e(route('admin.zonas.destroy', $zona)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Hapus zona ini? Semua area kerja & unit di bawahnya juga akan terhapus.')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>

                    <div class="modal fade" id="editZona<?php echo e($zona->id); ?>" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST" action="<?php echo e(route('admin.zonas.update', $zona)); ?>">
                                    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                                    <div class="modal-header">
                                        <h6 class="modal-title">Edit Zona</h6>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="text" name="nama" class="form-control" value="<?php echo e($zona->nama); ?>" required>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="4" class="text-center text-muted">Belum ada data zona.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\cuci-alber\resources\views/admin/zonas/index.blade.php ENDPATH**/ ?>