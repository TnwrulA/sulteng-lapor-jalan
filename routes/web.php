<?php

use App\Http\Controllers\AdminReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoadReportController;
use Illuminate\Support\Facades\Route;

use App\Models\RoadReport;

Route::get('/', function () {
    $allReports = RoadReport::with('user')->latest()->get();
    
    // Filter reports that have coordinates for Leaflet map
    $mapReports = $allReports->filter(fn($r) => $r->getCoordinates() !== null)->values();
    
    // Recent reports for highlights list
    $recentReports = $allReports->take(5);

    return view('welcome', compact('mapReports', 'recentReports'));
});

Route::middleware(['auth', 'verified', 'role:user'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'user'])->name('dashboard');
    Route::resource('reports', RoadReportController::class)->only(['index', 'create', 'store', 'show']);
});

Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
    Route::get('/reports/export', [AdminReportController::class, 'export'])->name('reports.export');
    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/{report}', [AdminReportController::class, 'show'])->name('reports.show');
    Route::put('/reports/{report}/status', [AdminReportController::class, 'updateStatus'])->name('reports.update-status');
    Route::delete('/reports/{report}', [AdminReportController::class, 'destroy'])->name('reports.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
