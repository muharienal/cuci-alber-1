<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AreaKerja;
use App\Models\Operator;
use App\Models\Pengawas;
use App\Models\Submission;
use App\Models\UnitAlat;
use App\Models\UnitKerja;
use App\Models\Zona;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalZona = Zona::count();
        $totalAreaKerja = AreaKerja::count();
        $totalUnitKerja = UnitKerja::count();
        $totalUnitAlat = UnitAlat::count();
        $totalOperator = Operator::count();
        $totalPengawas = Pengawas::count();
        $totalSubmissionHariIni = Submission::whereDate('created_at', now()->toDateString())->count();
        $totalSubmissionBulanIni = Submission::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)->count();

        // grafik: jumlah cuci alat per zona (30 hari terakhir)
        $perZona = Submission::select('zona_snapshot', DB::raw('count(*) as total'))
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('zona_snapshot')
            ->orderByDesc('total')
            ->get();

        // grafik: jumlah cuci alat per shift (30 hari terakhir)
        $perShift = Submission::select('shift', DB::raw('count(*) as total'))
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('shift')
            ->orderBy('shift')
            ->get();

        $submissionTerbaru = Submission::with(['unitAlat.jenisAlat', 'pengawas', 'photos'])
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalZona',
            'totalAreaKerja',
            'totalUnitKerja',
            'totalUnitAlat',
            'totalOperator',
            'totalPengawas',
            'totalSubmissionHariIni',
            'totalSubmissionBulanIni',
            'perZona',
            'perShift',
            'submissionTerbaru'
        ));
    }
}
