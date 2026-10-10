<?php

namespace App\Observers;

use App\Models\Nilai;

class NilaiObserver
{
    /**
     * Catat perubahan nilai ke log_nilai sebelum disimpan.
     */
    public function updating(Nilai $nilai): void
    {
        // Hanya catat kalau angka nilainya berubah, dan ada pengguna yang login
        // (perubahan dari seeder/tinker tidak punya user_id untuk dicatat)
        if (! $nilai->isDirty('nilai') || ! auth()->check()) {
            return;
        }

        $nilai->logNilai()->create([
            'user_id' => auth()->id(),
            'nilai_lama' => $nilai->getOriginal('nilai'),
            'nilai_baru' => $nilai->nilai,
            'diubah_pada' => now(),
        ]);
    }
}
