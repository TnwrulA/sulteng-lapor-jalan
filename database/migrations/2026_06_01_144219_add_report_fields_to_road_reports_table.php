<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('road_reports', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('location');
            $table->string('region');
            $table->string('maps_link')->nullable();
            $table->string('damage_type');
            $table->string('damage_level');
            $table->string('photo');
            $table->text('description')->nullable();
            $table->string('status')->default('Diterima');
            $table->text('admin_note')->nullable();
            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('road_reports', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'status']);
            $table->dropConstrainedForeignId('user_id');
            $table->dropColumn([
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
            ]);
        });
    }
};
