<?php $__env->startSection('title', 'Master Unit Kerja'); ?>

<?php $__env->startSection('content'); ?>
<div class="card shadow-sm mb-3">
    <div class="card-body">
        <h6 class="card-title">Tambah Unit Kerja Baru</h6>
        <form method="POST" action="<?php echo e(route('admin.unitKerjas.store')); ?>" class="row g-2">
            <?php echo csrf_field(); ?>
            <div class="col-12 col-md-5">
                <select name="area_kerja_id" class="form-select" required>
                    <option value="">-- Pilih Area Kerja --</option>
                    <?php $__currentLoopData = $areaKerjas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($area->id); ?>"><?php echo e($area->zona->nama); ?> - <?php echo e($area->nama); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-12 col-md-5">
                <input type="text" name="nama" class="form-control" placeholder="Contoh: Gd. Urea" required>
            </div>
            <div class="col-12 col-md-2">
                <button type="submit" class="btn btn-primary w-100">Tambah</button>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
        <table class="table table-striped align-middle mb-0">
            <thead>
                <tr>
                    <th style="width:50px">#</th>
                    <th>Zona</th>
                    <th>Area Kerja</th>
                    <th>Unit Kerja</th>
                    <th>Jml Unit Alat</th>
                    <th style="width:160px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $unitKerjas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $uk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($i + 1); ?></td>
                        <td><?php echo e($uk->areaKerja->zona->nama ?? '-'); ?></td>
                        <td><?php echo e($uk->areaKerja->nama ?? '-'); ?></td>
                        <td><?php echo e($uk->nama); ?></td>
                        <td><?php echo e($uk->unit_alats_count); ?></td>
                        <td class="text-nowrap">
                            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editUK<?php echo e($uk->id); ?>">Edit</button>
                            <form action="<?php echo e(route('admin.unitKerjas.destroy', $uk)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Hapus unit kerja ini beserta unit alat di dalamnya?')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>

                    <div class="modal fade" id="editUK<?php echo e($uk->id); ?>" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST" action="<?php echo e(route('admin.unitKerjas.update', $uk)); ?>">
                                    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                                    <div class="modal-header">
                                        <h6 class="modal-title">Edit Unit Kerja</h6>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-2">
                                            <label class="form-label">Area Kerja</label>
                                            <select name="area_kerja_id" class="form-select" required>
                                                <?php $__currentLoopData = $areaKerjas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($area->id); ?>" <?php echo e($area->id === $uk->area_kerja_id ? 'selected' : ''); ?>><?php echo e($area->zona->nama); ?> - <?php echo e($area->nama); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="form-label">Nama Unit Kerja</label>
                                            <input type="text" name="nama" class="form-control" value="<?php echo e($uk->nama); ?>" required>
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
                    <tr><td colspan="6" class="text-center text-muted">Belum ada data unit kerja.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\cuci-alber\resources\views/admin/unit_kerjas/index.blade.php ENDPATH**/ ?>