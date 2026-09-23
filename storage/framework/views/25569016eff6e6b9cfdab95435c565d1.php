<?php $__env->startSection('title', 'Unit Alat & Operator'); ?>

<?php $__env->startSection('content'); ?>
<div class="card shadow-sm mb-3">
    <div class="card-body">
        <h6 class="card-title">Tambah Unit Alat Baru</h6>
        <form method="POST" action="<?php echo e(route('admin.unitAlats.store')); ?>" class="row g-2">
            <?php echo csrf_field(); ?>
            <div class="col-md-4">
                <label class="form-label small">Unit Kerja</label>
                <select name="unit_kerja_id" class="form-select" required>
                    <option value="">-- Pilih Unit Kerja --</option>
                    <?php $__currentLoopData = $unitKerjas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $uk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($uk->id); ?>"><?php echo e($uk->areaKerja->zona->nama); ?> / <?php echo e($uk->areaKerja->nama); ?> / <?php echo e($uk->nama); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small">Jenis Alat</label>
                <select name="jenis_alat_id" class="form-select" required>
                    <option value="">-- Pilih --</option>
                    <?php $__currentLoopData = $jenisAlats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ja): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($ja->id); ?>"><?php echo e($ja->nama); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small">No. Lambung</label>
                <input type="text" name="no_lambung" class="form-control" required>
            </div>
            <div class="col-md-2">
                <label class="form-label small">Kepemilikan</label>
                <input type="text" name="kepemilikan" class="form-control" placeholder="PCS/WKK/YAYASAN">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Tambah</button>
            </div>

            <div class="col-md-3">
                <label class="form-label small">Operator Grup A</label>
                <select name="operator_a" class="form-select">
                    <option value="">-</option>
                    <?php $__currentLoopData = $operators; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $op): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($op->id); ?>"><?php echo e($op->nama); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small">Operator Grup B</label>
                <select name="operator_b" class="form-select">
                    <option value="">-</option>
                    <?php $__currentLoopData = $operators; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $op): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($op->id); ?>"><?php echo e($op->nama); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small">Operator Grup C</label>
                <select name="operator_c" class="form-select">
                    <option value="">-</option>
                    <?php $__currentLoopData = $operators; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $op): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($op->id); ?>"><?php echo e($op->nama); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small">Operator Grup D</label>
                <select name="operator_d" class="form-select">
                    <option value="">-</option>
                    <?php $__currentLoopData = $operators; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $op): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($op->id); ?>"><?php echo e($op->nama); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </form>
        <p class="text-muted small mt-2 mb-0">Tips: kelola daftar operator terlebih dahulu di menu <strong>Operator</strong> sebelum menugaskannya ke unit di sini.</p>
    </div>
</div>

<div class="card shadow-sm mb-3">
    <div class="card-body">
        <form method="GET" class="row g-2">
            <div class="col-md-3">
                <select name="unit_kerja_id" class="form-select" onchange="this.form.submit()">
                    <option value="">-- Semua Unit Kerja --</option>
                    <?php $__currentLoopData = $unitKerjas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $uk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($uk->id); ?>" <?php echo e(request('unit_kerja_id') == $uk->id ? 'selected' : ''); ?>><?php echo e($uk->nama); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-3">
                <select name="jenis_alat_id" class="form-select" onchange="this.form.submit()">
                    <option value="">-- Semua Jenis Alat --</option>
                    <?php $__currentLoopData = $jenisAlats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ja): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($ja->id); ?>" <?php echo e(request('jenis_alat_id') == $ja->id ? 'selected' : ''); ?>><?php echo e($ja->nama); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-3">
                <input type="text" name="q" class="form-control" placeholder="Cari no. lambung..." value="<?php echo e(request('q')); ?>">
            </div>
            <div class="col-md-3">
                <button class="btn btn-outline-secondary">Filter</button>
                <a href="<?php echo e(route('admin.unitAlats.index')); ?>" class="btn btn-outline-secondary">Reset</a>
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
                    <th>Zona / Area / Unit Kerja</th>
                    <th>Jenis</th>
                    <th>No. Lambung</th>
                    <th>Kepemilikan</th>
                    <th>Operator (A/B/C/D)</th>
                    <th style="width:140px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $unitAlats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ua): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $opByGrup = $ua->unitOperators->keyBy('grup');
                    ?>
                    <tr>
                        <td>
                            <div class="small text-muted"><?php echo e($ua->unitKerja->areaKerja->zona->nama ?? '-'); ?> / <?php echo e($ua->unitKerja->areaKerja->nama ?? '-'); ?></div>
                            <?php echo e($ua->unitKerja->nama ?? '-'); ?>

                        </td>
                        <td><?php echo e($ua->jenisAlat->nama ?? '-'); ?></td>
                        <td><?php echo e($ua->no_lambung); ?></td>
                        <td><?php echo e($ua->kepemilikan ?? '-'); ?></td>
                        <td class="small">
                            <?php $__currentLoopData = ['A','B','C','D']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div><strong><?php echo e($g); ?>:</strong> <?php echo e($opByGrup[$g]->operator->nama ?? '-'); ?></div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editUA<?php echo e($ua->id); ?>">Edit</button>
                            <form action="<?php echo e(route('admin.unitAlats.destroy', $ua)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Hapus unit alat ini?')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>

                    <div class="modal fade" id="editUA<?php echo e($ua->id); ?>" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form method="POST" action="<?php echo e(route('admin.unitAlats.update', $ua)); ?>">
                                    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                                    <div class="modal-header">
                                        <h6 class="modal-title">Edit Unit Alat - <?php echo e($ua->no_lambung); ?></h6>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row g-2 mb-2">
                                            <div class="col-md-6">
                                                <label class="form-label small">Unit Kerja</label>
                                                <select name="unit_kerja_id" class="form-select" required>
                                                    <?php $__currentLoopData = $unitKerjas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $uk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($uk->id); ?>" <?php echo e($uk->id === $ua->unit_kerja_id ? 'selected' : ''); ?>><?php echo e($uk->areaKerja->zona->nama); ?> / <?php echo e($uk->areaKerja->nama); ?> / <?php echo e($uk->nama); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label small">Jenis Alat</label>
                                                <select name="jenis_alat_id" class="form-select" required>
                                                    <?php $__currentLoopData = $jenisAlats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ja): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($ja->id); ?>" <?php echo e($ja->id === $ua->jenis_alat_id ? 'selected' : ''); ?>><?php echo e($ja->nama); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label small">No. Lambung</label>
                                                <input type="text" name="no_lambung" class="form-control" value="<?php echo e($ua->no_lambung); ?>" required>
                                            </div>
                                        </div>
                                        <div class="row g-2 mb-2">
                                            <div class="col-md-4">
                                                <label class="form-label small">Kepemilikan</label>
                                                <input type="text" name="kepemilikan" class="form-control" value="<?php echo e($ua->kepemilikan); ?>">
                                            </div>
                                            <div class="col-md-8">
                                                <label class="form-label small">Keterangan</label>
                                                <input type="text" name="keterangan" class="form-control" value="<?php echo e($ua->keterangan); ?>">
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row g-2">
                                            <?php $__currentLoopData = ['A','B','C','D']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="col-md-3">
                                                    <label class="form-label small">Operator Grup <?php echo e($g); ?></label>
                                                    <select name="operator_<?php echo e(strtolower($g)); ?>" class="form-select">
                                                        <option value="">-</option>
                                                        <?php $__currentLoopData = $operators; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $op): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($op->id); ?>" <?php echo e((optional($opByGrup[$g] ?? null)->operator_id) === $op->id ? 'selected' : ''); ?>><?php echo e($op->nama); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                    <tr><td colspan="6" class="text-center text-muted">Belum ada data unit alat.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        </div>
        <?php echo e($unitAlats->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\cuci-alber\resources\views/admin/unit_alats/index.blade.php ENDPATH**/ ?>