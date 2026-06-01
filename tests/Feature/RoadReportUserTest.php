<?php

namespace Tests\Feature;

use App\Models\RoadReport;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RoadReportUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_open_create_report_page(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->get('/reports/create');

        $response->assertOk();
        $response->assertSee('Buat Laporan Jalan Rusak');
    }

    public function test_user_can_store_road_report_with_photo(): void
    {
        Storage::fake('public');

        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->post('/reports', [
            'title' => 'Jalan Berlubang di Area Kampus',
            'location' => 'Jl. Soekarno Hatta, Kota Palu',
            'region' => 'Kota Palu',
            'maps_link' => 'https://maps.google.com/?q=-0.899,119.870',
            'damage_type' => 'Jalan berlubang',
            'damage_level' => 'Berat',
            'photo' => UploadedFile::fake()->create('jalan-rusak.jpg', 256, 'image/jpeg'),
            'description' => 'Lubang cukup dalam dan mengganggu pengendara.',
        ]);

        $report = RoadReport::first();

        $response->assertRedirect(route('reports.show', $report, absolute: false));
        $this->assertDatabaseHas('road_reports', [
            'user_id' => $user->id,
            'title' => 'Jalan Berlubang di Area Kampus',
            'status' => 'Diterima',
        ]);
        Storage::disk('public')->assertExists($report->photo);
    }

    public function test_user_can_only_view_own_report_detail(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $otherUser = User::factory()->create(['role' => 'user']);

        $ownReport = RoadReport::create([
            'user_id' => $user->id,
            'title' => 'Jalan retak dekat pasar',
            'location' => 'Pasar Inpres Palu',
            'region' => 'Kota Palu',
            'damage_type' => 'Jalan retak',
            'damage_level' => 'Sedang',
            'photo' => 'reports/test.jpg',
            'status' => 'Diterima',
        ]);

        $otherReport = RoadReport::create([
            'user_id' => $otherUser->id,
            'title' => 'Jalan amblas',
            'location' => 'Kabupaten Sigi',
            'region' => 'Kabupaten Sigi',
            'damage_type' => 'Jalan amblas',
            'damage_level' => 'Berat',
            'photo' => 'reports/test-2.jpg',
            'status' => 'Diterima',
        ]);

        $this->actingAs($user)->get(route('reports.show', $ownReport))->assertOk();
        $this->actingAs($user)->get(route('reports.show', $otherReport))->assertForbidden();
    }
}
