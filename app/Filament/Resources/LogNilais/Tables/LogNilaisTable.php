<?php

namespace App\Filament\Resources\LogNilais\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LogNilaisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('diubah_pada', 'desc')
            ->columns([
                TextColumn::make('nilai.siswa.nama')
                    ->label('Siswa')
                    ->searchable(),
                TextColumn::make('nilai.mataPelajaran.nama')
                    ->label('Mata Pelajaran'),
                TextColumn::make('nilai.jenis')
                    ->label('Jenis')
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                TextColumn::make('nilai_lama')
                    ->label('Nilai lama')
                    ->numeric(),
                TextColumn::make('nilai_baru')
                    ->label('Nilai baru')
                    ->numeric(),
                TextColumn::make('user.name')
                    ->label('Diubah oleh')
                    ->searchable(),
                TextColumn::make('diubah_pada')
                    ->label('Diubah pada')
                    ->dateTime()
                    ->sortable(),
            ]);
    }
}
