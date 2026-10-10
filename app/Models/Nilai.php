<?php

namespace App\Models;

use App\Observers\NilaiObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(NilaiObserver::class)]
class Nilai extends Model
{
    protected $table = 'nilai';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'nilai' => 'decimal:2',
        ];
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function logNilai()
    {
        return $this->hasMany(LogNilai::class);
    }
}
