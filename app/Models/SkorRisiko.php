<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkorRisiko extends Model
{
    protected $table = 'skor_risiko';

    protected $guarded = [];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public function tindakLanjut()
    {
        return $this->hasMany(TindakLanjut::class);
    }
}
