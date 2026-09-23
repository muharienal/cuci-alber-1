<?php $__env->startSection('title', 'Master Area Kerja'); ?>

<?php $__env->startSection('content'); ?>
<div class="card shadow-sm mb-3">
    <div class="card-body">
        <h6 class="card-title">Tambah Area Kerja Baru</h6>
        <form method="POST" action="<?php echo e(route('admin.areaKerjas.store')); ?>" class="row g-2">
            <?php echo csrf_field(); ?>
            <div class="col-md-4">
                <select name="zona_id" class="form-select" required>
                    <option value="">-- Pilih Zona --</option>
                    <?php $__currentLoopData = $zonas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zona): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($zona->id); ?>"><?php echo e($zona->nama); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-5">
                <input type="text" name="nama" class="form-control" placeholder="Contoh: Gudang 1" required>
            </div>
            <div class="col-md-3">
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
                    <th>Zona</th>
                    <th>Nama Area Kerja</th>
                    <th>Jumlah Unit Kerja</th>
                    <th style="width:160px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $areaKerjas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($i + 1); ?></td>
                        <td><?php echo e($area->zona->nama ?? '-'); ?></td>
                        <td><?php echo e($area->nama); ?></td>
                        <td><?php echo e($area->unit_kerjas_count); ?></td>
                        <td>
                            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editArea<?php echo e($area->id); ?>">Edit</button>
                            <form action="<?php echo e(route('admin.areaKerjas.destroy', $area)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Hapus area kerja ini beserta unit kerja di dalamnya?')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>

                    <div class="modal fade" id="editArea<?php echo e($area->id); ?>" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST" action="<?php echo e(route('admin.areaKerjas.update', $area)); ?>">
                                    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                                    <div class="modal-header">
                                        <h6 class="modal-title">Edit Area Kerja</h6>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-2">
                                            <label class="form-label">Zona</label>
                                            <select name="zona_id" class="form-select" required>
                                                <?php $__currentLoopData = $zonas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zona): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($zona->id); ?>" <?php echo e($zona->id === $area->zona_id ? 'selected' : ''); ?>><?php echo e($zona->nama); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="form-label">Nama Area Kerja</label>
                                            <input type="text" name="nama" class="form-control" value="<?php echo e($area->nama); ?>" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="5" class="text-center text-muted">Belum ada data area kerja.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\cuci-alber\resources\views/admin/area_kerjas/index.blade.php ENDPATH**/ ?>