<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TindakLanjut extends Model
{
    protected $table = 'tindak_lanjut';

    protected $guarded = [];

    public function skorRisiko()
    {
        return $this->belongsTo(SkorRisiko::class);
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }
}
