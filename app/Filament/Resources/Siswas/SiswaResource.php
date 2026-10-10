<?php

namespace App\Filament\Resources\Siswas;

use App\Filament\Resources\Siswas\Pages\CreateSiswa;
use App\Filament\Resources\Siswas\Pages\EditSiswa;
use App\Filament\Resources\Siswas\Pages\ListSiswas;
use App\Filament\Resources\Siswas\Pages\ViewSiswa;
use App\Filament\Resources\Siswas\Schemas\SiswaForm;
use App\Filament\Resources\Siswas\Tables\SiswasTable;
use App\Models\Siswa;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class SiswaResource extends Resource
{
    protected static ?string $model = Siswa::class;

    protected static ?string $modelLabel = 'siswa';

    protected static ?string $pluralModelLabel = 'siswa';

    protected static ?string $slug = 'siswa';

    protected static string | UnitEnum | null $navigationGroup = 'Data Master';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'nama';

    public static function form(Schema $schema): Schema
    {
        return SiswaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SiswasTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        return match ($user?->role) {
            'admin', 'kepala_sekolah' => $query,
            // Guru: siswa di kelas yang ia wali-i atau ia ajar menurut jadwal
            'guru' => $query->whereHas('kelas', fn (Builder $kelas) => $kelas
                ->where('wali_kelas_id', $user->guru?->id)
                ->orWhereHas('jadwal', fn (Builder $jadwal) => $jadwal->where('guru_id', $user->guru?->id))),
            // Orang tua: hanya anaknya sendiri
            'orang_tua' => $query->where('orang_tua_id', $user->orangTua?->id),
            default => $query->whereRaw('1 = 0'),
        };
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
            'index' => ListSiswas::route('/'),
            'create' => CreateSiswa::route('/create'),
            'view' => ViewSiswa::route('/{record}'),
            'edit' => EditSiswa::route('/{record}/edit'),
        ];
    }
}
