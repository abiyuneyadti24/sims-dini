<?php

namespace App\Filament\Resources\Jadwals;

use App\Filament\Resources\Jadwals\Pages\CreateJadwal;
use App\Filament\Resources\Jadwals\Pages\EditJadwal;
use App\Filament\Resources\Jadwals\Pages\ListJadwals;
use App\Filament\Resources\Jadwals\Pages\ViewJadwal;
use App\Filament\Resources\Jadwals\Schemas\JadwalForm;
use App\Filament\Resources\Jadwals\Tables\JadwalsTable;
use App\Models\Jadwal;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class JadwalResource extends Resource
{
    protected static ?string $model = Jadwal::class;

    protected static ?string $modelLabel = 'jadwal';

    protected static ?string $pluralModelLabel = 'jadwal';

    protected static ?string $slug = 'jadwal';

    protected static string | UnitEnum | null $navigationGroup = 'Akademik';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return JadwalForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return JadwalsTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        return match ($user?->role) {
            'admin', 'kepala_sekolah' => $query,
            // Guru: jadwal yang ia ajar, plus jadwal kelas yang ia wali-i
            'guru' => $query->where(fn (Builder $q) => $q
                ->where('guru_id', $user->guru?->id)
                ->orWhereHas('kelas', fn (Builder $kelas) => $kelas->where('wali_kelas_id', $user->guru?->id))),
            // Orang tua: jadwal kelas tempat anaknya belajar
            'orang_tua' => $query->whereHas('kelas.siswa', fn (Builder $siswa) => $siswa->where('orang_tua_id', $user->orangTua?->id)),
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
            'index' => ListJadwals::route('/'),
            'create' => CreateJadwal::route('/create'),
            'view' => ViewJadwal::route('/{record}'),
            'edit' => EditJadwal::route('/{record}/edit'),
        ];
    }
}
