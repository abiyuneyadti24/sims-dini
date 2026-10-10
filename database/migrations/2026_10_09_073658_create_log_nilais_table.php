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
        Schema::create('log_nilai', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nilai_id')->constrained('nilai')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users');
            $table->decimal('nilai_lama', 5, 2);
            $table->decimal('nilai_baru', 5, 2);
            $table->timestamp('diubah_pada');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_nilai');
    }
};
