<?php $__env->startSection('title', 'Data Cuci Alat'); ?>

<?php $__env->startSection('content'); ?>
<div class="card shadow-sm mb-3">
    <div class="card-body">
        <form method="GET" class="row g-2">
            <div class="col-md-3">
                <select name="zona" class="form-select">
                    <option value="">-- Semua Zona --</option>
                    <?php $__currentLoopData = $zonas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zona): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($zona->nama); ?>" <?php echo e(request('zona') === $zona->nama ? 'selected' : ''); ?>><?php echo e($zona->nama); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-2">
                <select name="shift" class="form-select">
                    <option value="">-- Semua Shift --</option>
                    <?php $__currentLoopData = ['1','2','3']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sh): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($sh); ?>" <?php echo e(request('shift') === $sh ? 'selected' : ''); ?>>Shift <?php echo e($sh); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" name="tanggal_dari" class="form-control" value="<?php echo e(request('tanggal_dari')); ?>">
            </div>
            <div class="col-md-2">
                <input type="date" name="tanggal_sampai" class="form-control" value="<?php echo e(request('tanggal_sampai')); ?>">
            </div>
            <div class="col-md-3">
                <button class="btn btn-outline-secondary">Filter</button>
                <a href="<?php echo e(route('admin.submissions.index')); ?>" class="btn btn-outline-secondary">Reset</a>
                <a href="<?php echo e(route('admin.submissions.export', request()->query())); ?>" class="btn btn-success">Export CSV</a>
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
                    <th>Waktu</th>
                    <th>Zona / Area</th>
                    <th>Unit Kerja</th>
                    <th>Jenis / No. Lambung</th>
                    <th>Pengawas</th>
                    <th>Shift</th>
                    <th>Operator</th>
                    <th>Foto</th>
                    <th style="width:70px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $submissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="small"><?php echo e($s->created_at->format('d-m-Y H:i')); ?></td>
                        <td class="small"><?php echo e($s->zona_snapshot); ?><br><span class="text-muted"><?php echo e($s->area_kerja_snapshot); ?></span></td>
                        <td class="small"><?php echo e($s->unit_kerja_snapshot); ?></td>
                        <td class="small"><?php echo e($s->jenis_alat_snapshot); ?><br><strong><?php echo e($s->no_lambung_snapshot); ?></strong></td>
                        <td class="small"><?php echo e($s->pengawas->nama ?? '-'); ?></td>
                        <td><span class="badge bg-secondary">Shift <?php echo e($s->shift); ?></span></td>
                        <td class="small"><?php echo e($s->operator_summary); ?></td>
                        <td>
                            <?php if($s->foto_tampak_samping): ?>
                                <a href="<?php echo e(Storage::url($s->foto_tampak_samping)); ?>" target="_blank">
                                    <img src="<?php echo e(Storage::url($s->foto_tampak_samping)); ?>" style="width:48px;height:48px;object-fit:cover;border-radius:8px;">
                                </a>
                            <?php else: ?> - <?php endif; ?>
                        </td>
                        <td>
                            <form action="<?php echo e(route('admin.submissions.destroy', $s)); ?>" method="POST" onsubmit="return confirm('Hapus data isian ini?')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="9" class="text-center text-muted">Belum ada data isian.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        </div>
        <?php echo e($submissions->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\cuci-alber\resources\views/admin/submissions/index.blade.php ENDPATH**/ ?>