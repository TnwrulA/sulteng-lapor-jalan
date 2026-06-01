<?php

namespace App\Http\Controllers;

use App\Models\RoadReport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RoadReportController extends Controller
{
    public function index(Request $request): View
    {
        $reports = $request->user()
            ->roadReports()
            ->latest()
            ->paginate(10);

        return view('reports.index', compact('reports'));
    }

    public function create(): View
    {
        return view('reports.create', [
            'regions' => RoadReport::REGIONS,
            'damageTypes' => RoadReport::DAMAGE_TYPES,
            'damageLevels' => RoadReport::DAMAGE_LEVELS,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'region' => ['required', 'string', Rule::in(RoadReport::REGIONS)],
            'maps_link' => ['nullable', 'string', 'max:500'],
            'damage_type' => ['required', 'string', Rule::in(RoadReport::DAMAGE_TYPES)],
            'damage_level' => ['required', 'string', Rule::in(RoadReport::DAMAGE_LEVELS)],
            'photo' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'description' => ['nullable', 'string', 'max:2000'],
        ]);

        $validated['maps_link'] = $this->normalizeMapsLink($validated['maps_link'] ?? null);
        $validated['photo'] = $request->file('photo')->store('reports', 'public');
        $validated['status'] = 'Menunggu Verifikasi';

        $report = $request->user()->roadReports()->create($validated);

        return redirect()
            ->route('reports.show', $report)
            ->with('status', 'Laporan jalan rusak berhasil dikirim.');
    }

    public function show(Request $request, RoadReport $report): View
    {
        abort_unless($report->user_id === $request->user()->id, 403);

        return view('reports.show', [
            'report' => $report,
        ]);
    }

    private function normalizeMapsLink(?string $mapsLink): ?string
    {
        if (! $mapsLink) {
            return null;
        }

        $mapsLink = trim($mapsLink);

        if (preg_match('/^-?\d+(\.\d+)?\s*,\s*-?\d+(\.\d+)?$/', $mapsLink)) {
            return 'https://www.google.com/maps/search/?api=1&query='.urlencode($mapsLink);
        }

        if (str_starts_with($mapsLink, 'http://') || str_starts_with($mapsLink, 'https://')) {
            return $mapsLink;
        }

        if (str_contains($mapsLink, 'maps.google.') || str_contains($mapsLink, 'google.com/maps') || str_contains($mapsLink, 'maps.app.goo.gl')) {
            return 'https://'.$mapsLink;
        }

        return 'https://www.google.com/maps/search/?api=1&query='.urlencode($mapsLink);
    }
}
