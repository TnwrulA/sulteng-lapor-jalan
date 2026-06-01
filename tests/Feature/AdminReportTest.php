<?php

namespace Tests\Feature;

use App\Models\RoadReport;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_reports_index(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'user']);
        $report = $this->createReport($user);

        $response = $this->actingAs($admin)->get('/admin/reports');

        $response->assertOk();
        $response->assertSee($report->title);
        $response->assertSee($user->name);
    }

    public function test_admin_can_view_report_detail(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'user']);
        $report = $this->createReport($user);

        $response = $this->actingAs($admin)->get(route('admin.reports.show', $report));

        $response->assertOk();
        $response->assertSee($report->title);
        $response->assertSee($user->email);
    }

    public function test_admin_can_update_report_status_and_note(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'user']);
        $report = $this->createReport($user);

        $response = $this->actingAs($admin)->put(route('admin.reports.update-status', $report), [
            'status' => 'Diproses',
            'admin_note' => 'Laporan masuk daftar prioritas karena tingkat kerusakan berat.',
        ]);

        $response->assertRedirect(route('admin.reports.show', $report, absolute: false));
        $this->assertDatabaseHas('road_reports', [
            'id' => $report->id,
            'status' => 'Diproses',
            'admin_note' => 'Laporan masuk daftar prioritas karena tingkat kerusakan berat.',
        ]);
    }

    public function test_admin_can_delete_report(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'user']);
        Storage::disk('public')->put('reports/test.jpg', 'photo');
        $report = $this->createReport($user, ['photo' => 'reports/test.jpg']);

        $response = $this->actingAs($admin)->delete(route('admin.reports.destroy', $report));

        $response->assertRedirect(route('admin.reports.index', absolute: false));
        $this->assertDatabaseMissing('road_reports', ['id' => $report->id]);
        Storage::disk('public')->assertMissing('reports/test.jpg');
    }

    public function test_user_cannot_access_admin_reports(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->get('/admin/reports');

        $response->assertRedirect(route('dashboard', absolute: false));
    }

    private function createReport(User $user, array $overrides = []): RoadReport
    {
        return RoadReport::create(array_merge([
            'user_id' => $user->id,
            'title' => 'Jalan Berlubang di Area Kampus',
            'location' => 'Jl. Soekarno Hatta, Kota Palu',
            'region' => 'Kota Palu',
            'maps_link' => 'https://maps.google.com/?q=-0.899,119.870',
            'damage_type' => 'Jalan berlubang',
            'damage_level' => 'Berat',
            'photo' => 'reports/test.jpg',
            'description' => 'Lubang cukup dalam dan mengganggu pengendara.',
            'status' => 'Diterima',
        ], $overrides));
    }
}
