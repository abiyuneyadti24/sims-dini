<?php

namespace App\Filament\Resources\Siswas\Schemas;

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
                Select::make('orang_tua_id')
                    ->label('Orang Tua')
                    ->relationship('orangTua', 'nama')
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        TextInput::make('nama')->required(),
                        TextInput::make('no_whatsapp')->label('No. WhatsApp')->required(),
                    ]),
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
            ]);
    }
}
