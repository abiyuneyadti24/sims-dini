<?php

namespace App\Filament\Resources\LogNilais;

use App\Filament\Resources\LogNilais\Pages\ListLogNilais;
use App\Filament\Resources\LogNilais\Tables\LogNilaisTable;
use App\Models\LogNilai;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class LogNilaiResource extends Resource
{
    protected static ?string $model = LogNilai::class;

    protected static ?string $modelLabel = 'riwayat nilai';

    protected static ?string $pluralModelLabel = 'riwayat nilai';

    protected static ?string $slug = 'riwayat-nilai';

    protected static string | UnitEnum | null $navigationGroup = 'Akademik';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function table(Table $table): Table
    {
        return LogNilaisTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLogNilais::route('/'),
        ];
    }
}
