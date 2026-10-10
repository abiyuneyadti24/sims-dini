<?php

namespace App\Filament\Resources\Siswas\Schemas;

use App\Models\OrangTua;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SiswaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('kelas_id')
                    ->label('Kelas')
                    ->relationship('kelas', 'nama')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('nisn')
                    ->label('NISN')
                    ->required(),
                TextInput::make('nama')
                    ->required(),
                Select::make('jenis_kelamin')
                    ->options([
                        'L' => 'Laki-laki',
                        'P' => 'Perempuan',
                    ])
                    ->required(),
                // Diisi manual; disimpan ke tabel orang_tua lewat OrangTua::cariAtauBuat()
                TextInput::make('nama_orang_tua')
                    ->label('Nama Orang Tua/Wali')
                    ->requiredWith('no_whatsapp_orang_tua')
                    ->maxLength(255),
                TextInput::make('no_whatsapp_orang_tua')
                    ->label('No. WhatsApp Orang Tua/Wali')
                    ->tel()
                    ->requiredWith('nama_orang_tua')
                    ->maxLength(255),
            ]);
    }

    /**
     * Isi kolom orang tua saat form dibuka (Edit / View).
     */
    public static function isiOrangTua(array $data, ?OrangTua $orangTua): array
    {
        $data['nama_orang_tua'] = $orangTua?->nama;
        $data['no_whatsapp_orang_tua'] = $orangTua?->no_whatsapp;

        return $data;
    }

    /**
     * Ubah kolom orang tua menjadi orang_tua_id sebelum siswa disimpan.
     */
    public static function simpanOrangTua(array $data): array
    {
        $data['orang_tua_id'] = OrangTua::cariAtauBuat(
            $data['nama_orang_tua'] ?? null,
            $data['no_whatsapp_orang_tua'] ?? null,
        )?->id;

        unset($data['nama_orang_tua'], $data['no_whatsapp_orang_tua']);

        return $data;
    }
}
