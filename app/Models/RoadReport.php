<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoadReport extends Model
{
    public const REGIONS = [
        'Kota Palu',
        'Kabupaten Sigi',
        'Kabupaten Donggala',
        'Kabupaten Parigi Moutong',
        'Kabupaten Poso',
        'Kabupaten Tojo Una-Una',
        'Kabupaten Morowali',
        'Kabupaten Morowali Utara',
        'Kabupaten Banggai',
        'Kabupaten Banggai Kepulauan',
        'Kabupaten Banggai Laut',
        'Kabupaten Tolitoli',
        'Kabupaten Buol',
    ];

    public const DAMAGE_TYPES = [
        'Jalan berlubang',
        'Jalan retak',
        'Jalan bergelombang',
        'Jalan amblas',
        'Lainnya',
    ];

    public const DAMAGE_LEVELS = [
        'Ringan',
        'Sedang',
        'Berat',
    ];

    public const STATUSES = [
        'Menunggu Verifikasi',
        'Diterima',
        'Diverifikasi',
        'Diproses',
        'Selesai',
        'Ditolak',
    ];

    protected $fillable = [
        'user_id',
        'title',
        'location',
        'region',
        'maps_link',
        'damage_type',
        'damage_level',
        'photo',
        'description',
        'status',
        'admin_note',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function statusBadgeClass(): string
    {
        return match ($this->status) {
            'Menunggu Verifikasi' => 'border border-stone-300 bg-stone-100 text-stone-800',
            'Diterima' => 'border border-stone-300 bg-stone-100 text-stone-800',
            'Diverifikasi' => 'border border-amber-300 bg-amber-100 text-amber-900',
            'Diproses' => 'border border-orange-300 bg-orange-100 text-orange-900',
            'Selesai' => 'border border-green-300 bg-green-100 text-green-900',
            'Ditolak' => 'border border-red-300 bg-red-100 text-red-900',
            default => 'border border-stone-300 bg-stone-100 text-stone-800',
        };
    }

    /**
     * Get latitude and longitude from maps_link
     */
    public function getCoordinates(): ?array
    {
        if (! $this->maps_link) {
            return null;
        }

        // Decode HTML entities and URL encoding first (converts %2C to comma, +/space properly)
        $link = urldecode(html_entity_decode($this->maps_link));

        // Match any standard coordinates format: lat,lng (e.g. -0.8917, 119.8707)
        if (preg_match('/(-?\d+\.\d+)\s*,\s*(-?\d+\.\d+)/', $link, $matches)) {
            return [
                'lat' => floatval($matches[1]),
                'lng' => floatval($matches[2]),
            ];
        }

        return null;
    }
}

