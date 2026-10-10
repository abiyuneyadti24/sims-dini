<?php

namespace App\Filament\Imports;

use App\Models\OrangTua;
use App\Models\Siswa;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Number;

class SiswaImporter extends Importer
{
    protected static ?string $model = Siswa::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('kelas')
                ->relationship(resolveUsing: 'nama')
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('nisn')
                ->label('NISN')
                ->validationAttribute('NISN')
                ->requiredMapping()
                ->rules(['required', 'max:255', 'unique:siswa,nisn']),
            ImportColumn::make('nama')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('jenis_kelamin')
                ->requiredMapping()
                ->rules(['required', 'max:1']),
            ImportColumn::make('nama_orang_tua')
                ->label('Nama Orang Tua/Wali')
                ->fillRecordUsing(fn () => null),
            ImportColumn::make('no_whatsapp_orang_tua')
                ->label('No. WhatsApp Orang Tua/Wali')
                ->fillRecordUsing(fn () => null),
        ];
    }

    public function resolveRecord(): Siswa
    {
        return new Siswa();
    }

    protected function beforeSave(): void
    {
        $orangTua = OrangTua::cariAtauBuat(
            filled($this->data['nama_orang_tua'] ?? null) ? $this->data['nama_orang_tua'] : 'Orang Tua/Wali ' . $this->data['nama'],
            $this->data['no_whatsapp_orang_tua'] ?? null,
        );

        if ($orangTua) {
            $this->record->orang_tua_id = $orangTua->id;
        }
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Impor siswa selesai, ' . Number::format($import->successful_rows) . ' baris berhasil diimpor.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' baris gagal diimpor.';
        }

        return $body;
    }
}
