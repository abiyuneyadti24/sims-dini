<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengaturanRisiko extends Model
{
    protected $table = 'pengaturan_risiko';

    protected $guarded = [];

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }
}
