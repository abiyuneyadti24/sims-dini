<?php

namespace App\Filament\Resources\Nilais\Schemas;

use App\Filament\Resources\Siswas\SiswaResource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class NilaiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('siswa_id')
                    ->label('Siswa')
                    // Hanya siswa yang boleh dilihat pengguna (guru: siswa di kelasnya)
                    ->relationship('siswa', 'nama', modifyQueryUsing: fn (Builder $query) => $query
                        ->whereIn('siswa.id', SiswaResource::getEloquentQuery()->select('siswa.id')))
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('mata_pelajaran_id')
                    ->label('Mata Pelajaran')
                    ->relationship('mataPelajaran', 'nama')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('jenis')
                    ->options(['tugas' => 'Tugas', 'ulangan' => 'Ulangan', 'ujian' => 'Ujian'])
                    ->required(),
                TextInput::make('nilai')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100)
                    ->required(),
            ]);
    }
}
