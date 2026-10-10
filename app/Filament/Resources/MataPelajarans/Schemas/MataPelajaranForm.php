<?php

namespace App\Filament\Resources\MataPelajarans\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MataPelajaranForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('kode')
                    ->label('Kode')
                    ->required(),
                TextInput::make('nama')
                    ->required(),
                TextInput::make('kkm')
                    ->label('KKM')
                    ->required()
                    ->numeric()
                    ->default(75),
            ]);
    }
}
