<?php

namespace App\Filament\Resources\Nilais;

use App\Filament\Resources\Nilais\Pages\CreateNilai;
use App\Filament\Resources\Nilais\Pages\EditNilai;
use App\Filament\Resources\Nilais\Pages\ListNilais;
use App\Filament\Resources\Nilais\Pages\ViewNilai;
use App\Filament\Resources\Nilais\Schemas\NilaiForm;
use App\Filament\Resources\Nilais\Tables\NilaisTable;
use App\Filament\Resources\Siswas\SiswaResource;
use App\Models\Nilai;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class NilaiResource extends Resource
{
    protected static ?string $model = Nilai::class;

    protected static ?string $modelLabel = 'nilai';

    protected static ?string $pluralModelLabel = 'nilai';

    protected static ?string $slug = 'nilai';

    protected static string | UnitEnum | null $navigationGroup = 'Akademik';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return NilaiForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return NilaisTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        return match ($user?->role) {
            'admin', 'kepala_sekolah' => $query,
            // Guru: nilai yang ia input, plus nilai siswa yang boleh ia lihat
            'guru' => $query->where(fn (Builder $q) => $q
                ->where('guru_id', $user->guru?->id)
                ->orWhereIn('siswa_id', SiswaResource::getEloquentQuery()->select('siswa.id'))),
            // Orang tua: hanya nilai anaknya sendiri
            'orang_tua' => $query->whereHas('siswa', fn (Builder $siswa) => $siswa->where('orang_tua_id', $user->orangTua?->id)),
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
            'index' => ListNilais::route('/'),
            'create' => CreateNilai::route('/create'),
            'view' => ViewNilai::route('/{record}'),
            'edit' => EditNilai::route('/{record}/edit'),
        ];
    }
}
