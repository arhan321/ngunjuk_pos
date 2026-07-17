<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\OperationalCosts;

use App\Filament\Admin\Resources\OperationalCosts\Pages\CreateOperationalCost;
use App\Filament\Admin\Resources\OperationalCosts\Pages\EditOperationalCost;
use App\Filament\Admin\Resources\OperationalCosts\Pages\ListOperationalCosts;
use App\Filament\Admin\Resources\OperationalCosts\Schemas\OperationalCostForm;
use App\Filament\Admin\Resources\OperationalCosts\Tables\OperationalCostsTable;
use App\Models\OperationalCost;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class OperationalCostResource extends Resource
{
    protected static ?string $model = OperationalCost::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-receipt-percent';

    protected static string|UnitEnum|null $navigationGroup = 'Keuangan';

    protected static ?string $navigationLabel = 'Biaya Operasional';

    protected static ?string $modelLabel = 'Biaya Operasional';

    protected static ?string $pluralModelLabel = 'Biaya Operasional';

    protected static ?int $navigationSort = 1;

    protected static ?string $slug = 'operational-costs';

    public static function canAccess(): bool
    {
        return auth()->check() && auth()->user()->hasRole('super_admin');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->check() && auth()->user()->hasRole('super_admin');
    }

    public static function form(Schema $schema): Schema
    {
        return OperationalCostForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OperationalCostsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOperationalCosts::route('/'),
            'create' => CreateOperationalCost::route('/create'),
            'edit' => EditOperationalCost::route('/{record}/edit'),
        ];
    }
}