<?php

namespace App\Http\Controllers;

use App\Models\RoadReport;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function user(Request $request): View
    {
        $user = $request->user();

        $stats = [
            'total' => $user->roadReports()->count(),
            'menunggu' => $user->roadReports()->where('status', 'Menunggu Verifikasi')->count(),
            'diterima' => $user->roadReports()->where('status', 'Diterima')->count(),
            'diverifikasi' => $user->roadReports()->where('status', 'Diverifikasi')->count(),
            'diproses' => $user->roadReports()->where('status', 'Diproses')->count(),
            'selesai' => $user->roadReports()->where('status', 'Selesai')->count(),
        ];

        $recentReports = $user->roadReports()
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', [
            'stats' => $stats,
            'recentReports' => $recentReports,
            'statuses' => RoadReport::STATUSES,
        ]);
    }

    public function admin(): View
    {
        $stats = [
            'total' => RoadReport::count(),
            'menunggu' => RoadReport::where('status', 'Menunggu Verifikasi')->count(),
            'diterima' => RoadReport::where('status', 'Diterima')->count(),
            'diverifikasi' => RoadReport::where('status', 'Diverifikasi')->count(),
            'diproses' => RoadReport::where('status', 'Diproses')->count(),
            'selesai' => RoadReport::where('status', 'Selesai')->count(),
            'ditolak' => RoadReport::where('status', 'Ditolak')->count(),
            'berat' => RoadReport::where('damage_level', 'Berat')->count(),
        ];

        $recentReports = RoadReport::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', [
            'stats' => $stats,
            'recentReports' => $recentReports,
        ]);
    }
}
