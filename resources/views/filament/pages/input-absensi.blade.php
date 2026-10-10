<x-filament-panels::page>
    <x-filament::section>
        <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
            <div style="flex: 2; min-width: 16rem;">
                <x-filament::input.wrapper>
                    <x-filament::input.select wire:model.live="jadwalId">
                        <option value="">Pilih jadwal</option>
                        @foreach ($this->daftarJadwal() as $jadwal)
                            <option value="{{ $jadwal->id }}">
                                {{ $jadwal->kelas->nama }} · {{ $jadwal->mataPelajaran->nama }} · {{ $jadwal->hari }}
                            </option>
                        @endforeach
                    </x-filament::input.select>
                </x-filament::input.wrapper>
            </div>

            <div style="flex: 1; min-width: 10rem;">
                <x-filament::input.wrapper>
                    <x-filament::input type="date" wire:model.live="tanggal" />
                </x-filament::input.wrapper>
            </div>
        </div>
    </x-filament::section>

    @if ($jadwalId)
        <x-filament::section>
            <table style="width: 100%;">
                <thead>
                    <tr>
                        <th style="text-align: left; padding: 0.5rem 0;">Nama siswa</th>
                        <th style="text-align: left; width: 12rem;">Kehadiran</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($this->daftarSiswa() as $siswa)
                        <tr wire:key="siswa-{{ $siswa->id }}">
                            <td style="padding: 0.5rem 0;">{{ $siswa->nama }}</td>
                            <td>
                                <x-filament::input.wrapper>
                                    <x-filament::input.select wire:model="status.{{ $siswa->id }}">
                                        <option value="hadir">Hadir</option>
                                        <option value="sakit">Sakit</option>
                                        <option value="izin">Izin</option>
                                        <option value="alpa">Alpa</option>
                                    </x-filament::input.select>
                                </x-filament::input.wrapper>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="margin-top: 1rem;">
                <x-filament::button wire:click="simpan">Simpan absensi</x-filament::button>
            </div>
        </x-filament::section>
    @endif
</x-filament-panels::page>