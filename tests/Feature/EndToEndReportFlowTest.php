<?php

namespace Tests\Feature;

use App\Models\RoadReport;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class EndToEndReportFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_landing_page_has_project_identity_and_hero_asset(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Sulteng Lapor Jalan');
        $response->assertSee('Smart Mobility Sulawesi Tengah');
        $response->assertSee('images/road-report-hero.png');
    }

    public function test_user_report_can_be_processed_by_admin_and_seen_by_user(): void
    {
        Storage::fake('public');

        $user = User::factory()->create(['role' => 'user']);
        $admin = User::factory()->create(['role' => 'admin']);

        $storeResponse = $this->actingAs($user)->post('/reports', [
            'title' => 'Jalan Berlubang di Depan Kampus',
            'location' => 'Jl. Soekarno Hatta, Kota Palu',
            'region' => 'Kota Palu',
            'maps_link' => 'https://maps.google.com/?q=-0.899,119.870',
            'damage_type' => 'Jalan berlubang',
            'damage_level' => 'Berat',
            'photo' => UploadedFile::fake()->create('jalan-rusak.jpg', 256, 'image/jpeg'),
            'description' => 'Lubang besar membuat kendaraan harus melambat.',
        ]);

        $report = RoadReport::firstOrFail();

        $storeResponse->assertRedirect(route('reports.show', $report, absolute: false));
        $this->assertSame('Diterima', $report->status);
        Storage::disk('public')->assertExists($report->photo);

        $this->actingAs($admin)
            ->get(route('admin.reports.show', $report))
            ->assertOk()
            ->assertSee('Jalan Berlubang di Depan Kampus')
            ->assertSee($user->email);

        $this->actingAs($admin)->put(route('admin.reports.update-status', $report), [
            'status' => 'Diverifikasi',
            'admin_note' => 'Laporan sudah diterima dan akan dicek oleh petugas.',
        ])->assertRedirect(route('admin.reports.show', $report, absolute: false));

        $this->actingAs($user)
            ->get(route('reports.show', $report))
            ->assertOk()
            ->assertSee('Diverifikasi')
            ->assertSee('Laporan sudah diterima dan akan dicek oleh petugas.');
    }
}
