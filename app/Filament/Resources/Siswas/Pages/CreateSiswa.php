<?php

namespace App\Filament\Resources\Siswas\Pages;

use App\Filament\Resources\Siswas\Schemas\SiswaForm;
use App\Filament\Resources\Siswas\SiswaResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSiswa extends CreateRecord
{
    protected static string $resource = SiswaResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return SiswaForm::simpanOrangTua($data);
    }
}
