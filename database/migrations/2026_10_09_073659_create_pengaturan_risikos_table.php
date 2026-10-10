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
        Schema::create('pengaturan_risiko', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tahun_ajaran_id')->unique()->constrained('tahun_ajaran');
            $table->decimal('bobot_absensi', 3, 2)->default(0.40);
            $table->decimal('bobot_kkm', 3, 2)->default(0.35);
            $table->decimal('bobot_penurunan', 3, 2)->default(0.25);
            $table->decimal('ambang_batas', 5, 2)->default(50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaturan_risiko');
    }
};
