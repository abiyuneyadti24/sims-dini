<?php

namespace App\Filament\Resources\Kelas\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class KelasForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('tahun_ajaran_id')
                    ->label('Tahun Ajaran')
                    ->relationship('tahunAjaran', 'nama')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('wali_kelas_id')
                    ->label('Wali Kelas')
                    ->relationship('waliKelas', 'nama')
                    ->searchable()
                    ->preload(),
                TextInput::make('nama')
                    ->required(),
                TextInput::make('tingkat')
                    ->required()
                    ->numeric(),
            ]);
    }
}
