<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrangTua extends Model
{
    protected $table = 'orang_tua';

    protected $guarded = [];

    /**
     * Cari orang tua berdasarkan nomor WhatsApp, buat baru kalau belum ada.
     * Nomor dipakai sebagai penanda supaya kakak-adik memakai data yang sama.
     */
    public static function cariAtauBuat(?string $nama, ?string $noWhatsapp): ?self
    {
        if (blank($noWhatsapp)) {
            return null;
        }

        return static::firstOrCreate(
            ['no_whatsapp' => trim($noWhatsapp)],
            ['nama' => trim($nama)],
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }

    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class);
    }
}
