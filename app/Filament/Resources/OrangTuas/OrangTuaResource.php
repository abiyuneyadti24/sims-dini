<?php

namespace App\Filament\Resources\OrangTuas;

use App\Filament\Resources\OrangTuas\Pages\CreateOrangTua;
use App\Filament\Resources\OrangTuas\Pages\EditOrangTua;
use App\Filament\Resources\OrangTuas\Pages\ListOrangTuas;
use App\Filament\Resources\OrangTuas\Schemas\OrangTuaForm;
use App\Filament\Resources\OrangTuas\Tables\OrangTuasTable;
use App\Models\OrangTua;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class OrangTuaResource extends Resource
{
    protected static ?string $model = OrangTua::class;

    protected static ?string $modelLabel = 'orang tua';

    protected static ?string $pluralModelLabel = 'orang tua';

    protected static ?string $slug = 'orang-tua';

    protected static string | UnitEnum | null $navigationGroup = 'Data Master';

    protected static bool $shouldRegisterNavigation = false;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'nama';

    public static function form(Schema $schema): Schema
    {
        return OrangTuaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OrangTuasTable::configure($table);
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
            'index' => ListOrangTuas::route('/'),
            'create' => CreateOrangTua::route('/create'),
            'edit' => EditOrangTua::route('/{record}/edit'),
        ];
    }
}
