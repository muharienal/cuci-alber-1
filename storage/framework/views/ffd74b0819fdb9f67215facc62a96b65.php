<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="row g-3 mb-4">
    <div class="col-6 col-md-2">
        <div class="card shadow-sm text-center p-3">
            <div class="fs-3 fw-bold"><?php echo e($totalZona); ?></div>
            <div class="text-muted small">Zona</div>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="card shadow-sm text-center p-3">
            <div class="fs-3 fw-bold"><?php echo e($totalAreaKerja); ?></div>
            <div class="text-muted small">Area Kerja</div>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="card shadow-sm text-center p-3">
            <div class="fs-3 fw-bold"><?php echo e($totalUnitAlat); ?></div>
            <div class="text-muted small">Unit Alat</div>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="card shadow-sm text-center p-3">
            <div class="fs-3 fw-bold"><?php echo e($totalOperator); ?></div>
            <div class="text-muted small">Operator</div>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="card shadow-sm text-center p-3">
            <div class="fs-3 fw-bold"><?php echo e($totalPengawas); ?></div>
            <div class="text-muted small">Pengawas</div>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="card shadow-sm text-center p-3">
            <div class="fs-3 fw-bold text-primary"><?php echo e($totalSubmissionHariIni); ?></div>
            <div class="text-muted small">Isian Hari Ini</div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-7">
        <div class="card shadow-sm p-3">
            <h6>Cuci Alat per Zona (30 hari terakhir)</h6>
            <canvas id="chartZona" height="180"></canvas>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card shadow-sm p-3">
            <h6>Cuci Alat per Shift (30 hari terakhir)</h6>
            <canvas id="chartShift" height="180"></canvas>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <h6 class="card-title">10 Isian Terbaru</h6>
        <div class="table-responsive">
            <table class="table table-sm table-striped align-middle">
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>Zona</th>
                        <th>Unit Kerja</th>
                        <th>No Lambung</th>
                        <th>Jenis</th>
                        <th>Pengawas</th>
                        <th>Shift</th>
                        <th>Foto</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $submissionTerbaru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($s->created_at->format('d-m-Y H:i')); ?></td>
                            <td><?php echo e($s->zona_snapshot); ?></td>
                            <td><?php echo e($s->unit_kerja_snapshot); ?></td>
                            <td><?php echo e($s->no_lambung_snapshot); ?></td>
                            <td><?php echo e($s->jenis_alat_snapshot); ?></td>
                            <td><?php echo e($s->pengawas->nama ?? '-'); ?></td>
                            <td><span class="badge bg-secondary">Shift <?php echo e($s->shift); ?></span></td>
                            <td>
                                <?php if($s->photos->count()): ?>
                                    <a href="<?php echo e(Storage::url($s->photos->first()->path)); ?>" target="_blank">
                                        <i class="bi bi-image"></i> <?php echo e($s->photos->count()); ?>

                                    </a>
                                <?php else: ?> - <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="8" class="text-center text-muted">Belum ada data isian.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <a href="<?php echo e(route('admin.submissions.index')); ?>" class="btn btn-sm btn-outline-primary">Lihat Semua Data Cuci Alat</a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
const zonaLabels = <?php echo json_encode($perZona->pluck('zona_snapshot')); ?>;
const zonaData = <?php echo json_encode($perZona->pluck('total')); ?>;

new Chart(document.getElementById('chartZona'), {
    type: 'bar',
    data: {
        labels: zonaLabels,
        datasets: [{ label: 'Jumlah Cuci Alat', data: zonaData, backgroundColor: '#15305e', borderRadius: 6 }]
    },
    options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { precision: 0 } } } }
});

const shiftLabels = <?php echo json_encode($perShift->pluck('shift')->map(fn($s) => 'Shift ' . $s)); ?>;
const shiftData = <?php echo json_encode($perShift->pluck('total')); ?>;

new Chart(document.getElementById('chartShift'), {
    type: 'doughnut',
    data: {
        labels: shiftLabels,
        datasets: [{ data: shiftData, backgroundColor: ['#15305e', '#f97316', '#fbbf24'] }]
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\cuci-alber\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>