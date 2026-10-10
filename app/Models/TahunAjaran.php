<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    protected $table = 'tahun_ajaran';

    protected $guarded = [];

    public function kelas()
    {
        return $this->hasMany(Kelas::class);
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class);
    }

    public function skorRisiko()
    {
        return $this->hasMany(SkorRisiko::class);
    }

    public function pengaturanRisiko()
    {
        return $this->hasOne(PengaturanRisiko::class);
    }
}
