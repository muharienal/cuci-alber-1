<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Models\Zona;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SubmissionController extends Controller
{
    private const RELATIONS = [
        'unitAlat.jenisAlat', 'pengawas', 'operatorNd',
        'operatorGrupA', 'operatorGrupB', 'operatorGrupC', 'operatorGrupD', 'photos',
    ];

    public function index(Request $request)
    {
        $query = Submission::with(self::RELATIONS);

        if ($request->filled('zona')) {
            $query->where('zona_snapshot', $request->zona);
        }
        if ($request->filled('shift')) {
            $query->where('shift', $request->shift);
        }
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('created_at', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_sampai);
        }

        $submissions = $query->latest()->paginate(20)->withQueryString();
        $zonas = Zona::orderBy('nama')->get();

        return view('admin.submissions.index', compact('submissions', 'zonas'));
    }

    public function destroy(Submission $submission)
    {
        $submission->delete();

        return back()->with('success', 'Data isian berhasil dihapus.');
    }

    /**
     * Export hasil isian ke CSV (bisa dibuka di Excel).
     */
    public function export(Request $request): StreamedResponse
    {
        $query = Submission::with(self::RELATIONS);

        if ($request->filled('zona')) {
            $query->where('zona_snapshot', $request->zona);
        }
        if ($request->filled('shift')) {
            $query->where('shift', $request->shift);
        }
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('created_at', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_sampai);
        }

        $submissions = $query->latest()->get();

        $filename = 'laporan-cuci-alat-' . now()->format('Ymd-His') . '.csv';

        $callback = function () use ($submissions) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [
                'Tanggal', 'Jam', 'Zona', 'Area Kerja', 'Unit Kerja', 'Jenis Alat', 'No Lambung',
                'Pengawas', 'Shift', 'Operator ND', 'Operator Grup A', 'Operator Grup B',
                'Operator Grup C', 'Operator Grup D', 'Jumlah Foto', 'Link Foto',
            ]);

            foreach ($submissions as $s) {
                fputcsv($handle, [
                    $s->created_at->format('Y-m-d'),
                    $s->created_at->format('H:i'),
                    $s->zona_snapshot,
                    $s->area_kerja_snapshot,
                    $s->unit_kerja_snapshot,
                    $s->jenis_alat_snapshot,
                    $s->no_lambung_snapshot,
                    $s->pengawas->nama ?? '-',
                    $s->shift,
                    $s->operatorNd->nama ?? '-',
                    $s->operatorGrupA->nama ?? '-',
                    $s->operatorGrupB->nama ?? '-',
                    $s->operatorGrupC->nama ?? '-',
                    $s->operatorGrupD->nama ?? '-',
                    $s->photos->count(),
                    $s->photos->map(fn ($p) => url('storage/' . $p->path))->implode(' | ') ?: '-',
                ]);
            }

            fclose($handle);
        };

        return response()->streamDownload($callback, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }
}
