<?php

namespace App\Filament\Resources\Siswas\Pages;

use App\Filament\Resources\Siswas\Schemas\SiswaForm;
use App\Filament\Resources\Siswas\SiswaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSiswa extends EditRecord
{
    protected static string $resource = SiswaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        return SiswaForm::isiOrangTua($data, $this->record->orangTua);
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return SiswaForm::simpanOrangTua($data);
    }
}
