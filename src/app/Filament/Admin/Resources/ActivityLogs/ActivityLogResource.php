<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ActivityLogs;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Activitylog\Models\Activity;
use UnitEnum;

final class ActivityLogResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static string|UnitEnum|null $navigationGroup = 'Administration';

    protected static ?string $navigationLabel = 'Activity Log';

    protected static ?string $modelLabel = 'Activity Log';

    protected static ?string $pluralModelLabel = 'Activity Logs';

    protected static ?int $navigationSort = 3;

    protected static ?string $slug = 'activity-logs';

    public static function form(Schema $schema): Schema
    {
        return $schema;
    }

    public static function getEloquentQuery(): Builder
    {
        return self::applyLoginLogoutFilter(parent::getEloquentQuery())
            ->with(['causer', 'subject']);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->heading('')
            ->modifyQueryUsing(fn (Builder $query): Builder => self::applyLoginLogoutFilter($query))
            ->columns([
                TextColumn::make('log_name')
                    ->label('Type')
                    ->searchable()
                    ->sortable()
                    ->html()
                    ->formatStateUsing(function (?string $state): string {
                        $label = $state ? Str::headline($state) : 'Access';

                        return '
                            <span style="
                                display:inline-flex;
                                align-items:center;
                                gap:7px;
                                min-height:30px;
                                padding:0 12px;
                                border-radius:999px;
                                color:#078657;
                                background:rgba(16,185,129,.13);
                                border:1px solid rgba(16,185,129,.24);
                                font-size:11px;
                                font-weight:950;
                                white-space:nowrap;
                            ">
                                <span style="
                                    width:7px;
                                    height:7px;
                                    border-radius:999px;
                                    background:#10b981;
                                "></span>
                                '.e($label).'
                            </span>
                        ';
                    }),

                TextColumn::make('event')
                    ->label('Event')
                    ->searchable()
                    ->sortable()
                    ->html()
                    ->formatStateUsing(function (?string $state, Activity $record): string {
                        $event = mb_strtolower((string) ($state ?: $record->description ?: 'activity'));
                        $label = Str::headline($event);

                        $color = match (true) {
                            str_contains($event, 'logout') => '#ef4444',
                            str_contains($event, 'login') => '#64748b',
                            default => '#f97316',
                        };

                        return '
                            <span style="
                                display:inline-flex;
                                align-items:center;
                                gap:7px;
                                min-height:30px;
                                padding:0 12px;
                                border-radius:999px;
                                color:#24180f;
                                background:rgba(255,255,255,.24);
                                border:1px solid rgba(255,255,255,.38);
                                font-size:11px;
                                font-weight:950;
                                white-space:nowrap;
                            ">
                                <span style="
                                    width:7px;
                                    height:7px;
                                    border-radius:999px;
                                    background:'.$color.';
                                "></span>
                                '.e($label).'
                            </span>
                        ';
                    }),

                TextColumn::make('causer.name')
                    ->label('User')
                    ->searchable()
                    ->sortable()
                    ->html()
                    ->formatStateUsing(function (?string $state, Activity $record): string {
                        $name = $record->causer?->name ?? $state ?? 'System';

                        return '
                            <span style="
                                display:inline-flex;
                                align-items:center;
                                gap:7px;
                                min-height:30px;
                                padding:0 12px;
                                border-radius:999px;
                                color:#7c3aed;
                                background:rgba(139,92,246,.10);
                                border:1px solid rgba(139,92,246,.20);
                                font-size:11px;
                                font-weight:950;
                                white-space:nowrap;
                            ">
                                👤 '.e($name).'
                            </span>
                        ';
                    }),

                TextColumn::make('created_at')
                    ->label('Logged At')
                    ->sortable()
                    ->html()
                    ->formatStateUsing(fn ($state): string => '
                        <span style="
                            display:inline-flex;
                            align-items:center;
                            min-height:30px;
                            padding:0 12px;
                            border-radius:999px;
                            color:#2563eb;
                            background:rgba(59,130,246,.10);
                            border:1px solid rgba(59,130,246,.20);
                            font-size:11px;
                            font-weight:950;
                            white-space:nowrap;
                        ">
                            🗓 '.e(\Carbon\Carbon::parse($state)->format('d/m/Y H:i:s')).'
                        </span>
                    '),

                TextColumn::make('description')
                    ->label('Description')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->wrap(),
            ])
            ->filters([
                SelectFilter::make('event')
                    ->label('Aktivitas')
                    ->options([
                        'login' => 'Login',
                        'logout' => 'Logout',
                    ]),
            ])
            ->recordUrl(null)
            ->recordActions([])
            ->toolbarActions([])
            ->defaultSort('created_at', 'desc')
            ->paginated([10, 25, 50, 100]);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListActivityLogs::route('/'),
        ];
    }

    protected static function applyLoginLogoutFilter(Builder $query): Builder
    {
        return $query->where(function (Builder $query): void {
            $query
                ->whereIn('event', ['login', 'logout'])
                ->orWhere('description', 'like', '%login%')
                ->orWhere('description', 'like', '%logout%')
                ->orWhere('description', 'like', '%logged in%')
                ->orWhere('description', 'like', '%logged out%');
        });
    }
}
