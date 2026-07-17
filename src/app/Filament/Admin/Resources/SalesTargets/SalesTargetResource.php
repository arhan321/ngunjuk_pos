<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\SalesTargets;

use App\Filament\Admin\Resources\SalesTargets\Pages\CreateSalesTarget;
use App\Filament\Admin\Resources\SalesTargets\Pages\EditSalesTarget;
use App\Filament\Admin\Resources\SalesTargets\Pages\ListSalesTargets;
use App\Filament\Admin\Resources\SalesTargets\Schemas\SalesTargetForm;
use App\Filament\Admin\Resources\SalesTargets\Tables\SalesTargetsTable;
use App\Models\SalesTarget;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class SalesTargetResource extends Resource
{
    protected static ?string $model = SalesTarget::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-flag';

    protected static string|UnitEnum|null $navigationGroup = 'Keuangan';

    protected static ?string $navigationLabel = 'Target Penjualan';

    protected static ?string $modelLabel = 'Target Penjualan';

    protected static ?string $pluralModelLabel = 'Target Penjualan';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return SalesTargetForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SalesTargetsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSalesTargets::route('/'),
            'create' => CreateSalesTarget::route('/create'),
            'edit' => EditSalesTarget::route('/{record}/edit'),
        ];
    }
}