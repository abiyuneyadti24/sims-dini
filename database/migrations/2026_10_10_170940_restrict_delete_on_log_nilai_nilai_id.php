<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Nilai yang sudah punya riwayat tidak boleh dihapus,
     * supaya riwayat perubahannya tidak ikut hilang.
     */
    public function up(): void
    {
        Schema::table('log_nilai', function (Blueprint $table) {
            $table->dropForeign(['nilai_id']);
            $table->foreign('nilai_id')->references('id')->on('nilai')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('log_nilai', function (Blueprint $table) {
            $table->dropForeign(['nilai_id']);
            $table->foreign('nilai_id')->references('id')->on('nilai')->cascadeOnDelete();
        });
    }
};
