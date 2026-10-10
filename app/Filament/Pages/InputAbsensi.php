<?php

namespace App\Filament\Pages;

use App\Models\Absensi;
use App\Models\Jadwal;
use App\Models\Siswa;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use UnitEnum;

class InputAbsensi extends Page
{
    protected string $view = 'filament.pages.input-absensi';
    protected static ?string $title = 'Input Absensi';
    protected static string | UnitEnum | null $navigationGroup = 'Akademik';

    public ?int $jadwalId = null;
    public string $tanggal = '';
    public array $status = []; // [siswa_id => status]

    public static function canAccess(): bool
    {
        return in_array(auth()->user()->role, ['admin', 'guru']);
    }

    public function mount(): void
    {
        $this->tanggal = now()->toDateString();
    }

    public function daftarJadwal()
    {
        $user = auth()->user();

        return Jadwal::with(['kelas', 'mataPelajaran'])
            ->when($user->role === 'guru', fn ($q) => $q->where('guru_id', $user->guru?->id))
            ->get();
    }

    public function daftarSiswa()
    {
        $jadwal = $this->daftarJadwal()->firstWhere('id', $this->jadwalId);

        return $jadwal
            ? Siswa::where('kelas_id', $jadwal->kelas_id)->orderBy('nama')->get()
            : collect();
    }

    public function updatedJadwalId(): void { $this->muat(); }
    public function updatedTanggal(): void  { $this->muat(); }

    public function muat(): void
    {
        $tersimpan = Absensi::where('jadwal_id', $this->jadwalId)
            ->whereDate('tanggal', $this->tanggal)
            ->pluck('status', 'siswa_id');

        $this->status = [];
        foreach ($this->daftarSiswa() as $siswa) {
            $this->status[$siswa->id] = $tersimpan[$siswa->id] ?? 'hadir';
        }
    }

    public function simpan(): void
    {
        $siswaIds = $this->daftarSiswa()->pluck('id');

        if ($siswaIds->isEmpty()) {
            return; // jadwal belum dipilih atau bukan milik guru ini
        }

        foreach ($this->status as $siswaId => $status) {
            if (! $siswaIds->contains($siswaId) || ! in_array($status, ['hadir', 'sakit', 'izin', 'alpa'])) {
                continue;
            }

            Absensi::updateOrCreate(
                ['siswa_id' => $siswaId, 'jadwal_id' => $this->jadwalId, 'tanggal' => $this->tanggal],
                ['status' => $status],
            );
        }

        Notification::make()->title('Absensi tersimpan')->success()->send();
    }
}