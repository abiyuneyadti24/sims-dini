<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogNilai extends Model
{
    protected $table = 'log_nilai';

    protected $guarded = [];

    public $timestamps = false;

    public function nilai()
    {
        return $this->belongsTo(Nilai::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
