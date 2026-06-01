<?php

namespace App\Http\Controllers;

use App\Models\RoadReport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminReportController extends Controller
{
    public function index(Request $request): View
    {
        $reports = RoadReport::with('user')
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->status))
            ->when($request->filled('damage_level'), fn ($query) => $query->where('damage_level', $request->damage_level))
            ->when($request->filled('region'), fn ($query) => $query->where('region', $request->region))
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;

                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('location', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.reports.index', [
            'reports' => $reports,
            'statuses' => RoadReport::STATUSES,
            'damageLevels' => RoadReport::DAMAGE_LEVELS,
            'regions' => RoadReport::REGIONS,
            'filters' => $request->only(['status', 'damage_level', 'region', 'search']),
        ]);
    }

    public function show(RoadReport $report): View
    {
        return view('admin.reports.show', [
            'report' => $report->load('user'),
            'statuses' => RoadReport::STATUSES,
        ]);
    }

    public function updateStatus(Request $request, RoadReport $report): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'string', Rule::in(RoadReport::STATUSES)],
            'admin_note' => ['nullable', 'string', 'max:2000'],
        ]);

        $report->update($validated);

        return redirect()
            ->route('admin.reports.show', $report)
            ->with('status', 'Status laporan berhasil diperbarui.');
    }

    public function destroy(RoadReport $report): RedirectResponse
    {
        Storage::disk('public')->delete($report->photo);
        $report->delete();

        return redirect()
            ->route('admin.reports.index')
            ->with('status', 'Laporan berhasil dihapus.');
    }
}
