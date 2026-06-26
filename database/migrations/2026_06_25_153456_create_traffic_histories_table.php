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
        Schema::create('traffic_histories', function (Blueprint $table) {
            $table->id();

            // Identitas CCTV / simpang
            $table->string('key')->index();
            $table->string('nama');

            // Window waktu agregasi, misalnya 20:00:00 - 20:00:30
            $table->timestamp('window_start')->index();
            $table->timestamp('window_end')->index();

            // Rata-rata kendaraan selama window
            $table->decimal('avg_total_kendaraan', 8, 2)->default(0);
            $table->decimal('avg_motor', 8, 2)->default(0);
            $table->decimal('avg_mobil', 8, 2)->default(0);
            $table->decimal('avg_bus', 8, 2)->default(0);
            $table->decimal('avg_truk', 8, 2)->default(0);

            // Nilai tertinggi selama window
            $table->unsignedInteger('max_total_kendaraan')->default(0);

            // Status dominan dalam 30 detik
            $table->string('dominant_status')->nullable();

            // Status paling parah dalam 30 detik
            $table->string('peak_status')->nullable();

            // Untuk nanti kalau sudah pakai congestion score
            $table->decimal('avg_congestion_score', 5, 2)->nullable();
            $table->decimal('max_congestion_score', 5, 2)->nullable();

            $table->timestamps();

            // Biar query grafik per CCTV dan waktu lebih cepat
            $table->index(['key', 'window_start']);
            $table->index(['key', 'window_end']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('traffic_histories');
    }
};
