<?php

namespace App\Filament\Resources\Siswas\Pages;

use App\Filament\Imports\SiswaImporter;
use App\Filament\Resources\Siswas\SiswaResource;
use Filament\Actions\CreateAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;

class ListSiswas extends ListRecords
{
    protected static string $resource = SiswaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ImportAction::make()
                ->importer(SiswaImporter::class)
                ->label('Impor siswa'),
            CreateAction::make()
                ->label('Tambah Siswa'),
        ];
    }
}
