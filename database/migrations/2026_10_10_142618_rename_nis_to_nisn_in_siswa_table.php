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
        Schema::table('siswa', function (Blueprint $table) {
            $table->renameColumn('nis', 'nisn');
            $table->renameIndex('siswa_nis_unique', 'siswa_nisn_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->renameColumn('nisn', 'nis');
            $table->renameIndex('siswa_nisn_unique', 'siswa_nis_unique');
        });
    }
};
