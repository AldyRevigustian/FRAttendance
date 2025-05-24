<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {

        $totalSiswa = Siswa::count();
        $totalGuru = Guru::count();
        $totalKelas = Kelas::count();
        $totalAbsensiHariIni = Absensi::whereDate('tanggal', Carbon::today())->count();

        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : Carbon::now()->subDays(6);
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : Carbon::now();

        $selectedKelasId = $request->input('kelas_id');

        $recentAbsensiQuery = Absensi::with(['siswa', 'kelas'])
            ->orderBy('tanggal', 'desc');

        if ($selectedKelasId) {
            $recentAbsensiQuery->where('kelas_id', $selectedKelasId);
        }

        $recentAbsensi = $recentAbsensiQuery->take(5)->get();

        $allKelas = Kelas::orderBy('nama')->get();

        $absensiByKelas = Kelas::withCount(['absensies' => function ($query) use ($startDate, $endDate) {
            $query->whereBetween('tanggal', [$startDate->startOfDay(), $endDate->endOfDay()]);
        }])
            ->get()
            ->sortByDesc('absensies_count');


        $absensiTrend = [];
        $dateRange = $endDate->diffInDays($startDate) + 1;
        $dateRange = min($dateRange, 30);

        for ($i = $dateRange - 1; $i >= 0; $i--) {
            $date = clone $endDate;
            $date = $date->subDays($i);

            $query = Absensi::whereDate('tanggal', $date);
            if ($selectedKelasId) {
                $query->where('kelas_id', $selectedKelasId);
            }

            $count = $query->count();
            $absensiTrend[] = [
                'date' => $date->format('Y-m-d'),
                'label' => $date->format('d M'),
                'count' => $count
            ];
        }

        if ($request->ajax()) {
            return response()->json([
                'totalSiswa' => $totalSiswa,
                'totalGuru' => $totalGuru,
                'totalKelas' => $totalKelas,
                'totalAbsensiHariIni' => $totalAbsensiHariIni,
                'absensiTrend' => $absensiTrend,
                'absensiByKelas' => $absensiByKelas->map(function ($kelas) {
                    return [
                        'nama' => $kelas->nama,
                        'count' => $kelas->absensies_count
                    ];
                }),
                'recentAbsensi' => $recentAbsensi->map(function ($absensi) {
                    return [
                        'tanggal' => Carbon::parse($absensi->tanggal)->format('d M Y H:i'),
                        'siswa' => $absensi->siswa->nama,
                        'kelas' => $absensi->kelas->nama
                    ];
                }),
            ]);
        }

        return view('admin.dashboard', compact(
            'totalSiswa',
            'totalGuru',
            'totalKelas',
            'totalAbsensiHariIni',
            'recentAbsensi',
            'absensiByKelas',
            'absensiTrend',
            'allKelas',
            'selectedKelasId',
            'startDate',
            'endDate'
        ));
    }

    public function exportAbsensi(Request $request)
    {
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : Carbon::now()->subDays(30);
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : Carbon::now();
        $kelasId = $request->input('kelas_id');

        $query = Absensi::with(['siswa', 'kelas'])
            ->whereBetween('tanggal', [$startDate->startOfDay(), $endDate->endOfDay()])
            ->orderBy('tanggal', 'desc');

        if ($kelasId) {
            $query->where('kelas_id', $kelasId);
        }

        $absensi = $query->get();


        $filename = "absensi_{$startDate->format('Y-m-d')}_{$endDate->format('Y-m-d')}.csv";

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = ['Tanggal', 'Siswa', 'Kelas'];

        $callback = function () use ($absensi, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($absensi as $record) {
                fputcsv($file, [
                    Carbon::parse($record->tanggal)->format('Y-m-d H:i:s'),
                    $record->siswa->nama,
                    $record->kelas->nama
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
