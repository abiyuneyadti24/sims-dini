<?php

namespace App\Filament\Resources\Nilais\Pages;

use App\Filament\Resources\Nilais\NilaiResource;
use App\Models\TahunAjaran;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateNilai extends CreateRecord
{
    protected static string $resource = NilaiResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['guru_id'] = auth()->user()->guru?->id;
        $data['tahun_ajaran_id'] = TahunAjaran::where('aktif', true)->value('id');

        // Hentikan dengan pesan yang jelas, bukan error database
        if (! $data['guru_id'] || ! $data['tahun_ajaran_id']) {
            Notification::make()
                ->title('Nilai tidak dapat disimpan')
                ->body(! $data['guru_id']
                    ? 'Akun ini tidak terhubung ke data guru.'
                    : 'Belum ada tahun ajaran yang aktif.')
                ->danger()
                ->send();

            $this->halt();
        }

        return $data;
    }
}
