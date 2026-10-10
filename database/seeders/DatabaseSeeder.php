<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\OrangTua;
use App\Models\PengaturanRisiko;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $ta = TahunAjaran::create(['nama' => '2026/2027', 'semester' => 'ganjil', 'aktif' => true]);
        PengaturanRisiko::create(['tahun_ajaran_id' => $ta->id]);

        User::create([
            'name' => 'Admin', 'email' => 'admin@sims.test',
            'password' => bcrypt('password'), 'role' => 'admin',
        ]);

        $userGuru = User::create([
            'name' => 'Bu Rina', 'email' => 'rina@sims.test',
            'password' => bcrypt('password'), 'role' => 'guru',
        ]);
        $guru = Guru::create(['user_id' => $userGuru->id, 'nama' => 'Rina', 'nip' => '1987001']);

        $kelas = Kelas::create([
            'tahun_ajaran_id' => $ta->id, 'wali_kelas_id' => $guru->id,
            'nama' => 'X-1', 'tingkat' => 10,
        ]);

        $ortu = OrangTua::create(['nama' => 'Pak Budi', 'no_whatsapp' => '6281200000000']);
        Siswa::create([
            'kelas_id' => $kelas->id, 'orang_tua_id' => $ortu->id,
            'nis' => '2026001', 'nama' => 'Andi', 'jenis_kelamin' => 'L',
        ]);

        MataPelajaran::create(['kode' => 'MTK', 'nama' => 'Matematika', 'kkm' => 75]);
    }
}