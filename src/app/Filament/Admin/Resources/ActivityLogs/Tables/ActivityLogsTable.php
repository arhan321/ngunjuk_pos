<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ActivityLogs\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Spatie\Activitylog\Models\Activity as ActivityModel;

class ActivityLogsTable
{
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

    public static function configure(Table $table): Table
    {
        return $table
            ->heading('')
            ->modifyQueryUsing(fn (Builder $query): Builder => static::applyLoginLogoutFilter($query))
            ->columns([
                TextColumn::make('log_name')
                    ->label('Type')
                    ->sortable()
                    ->html()
                    ->formatStateUsing(fn (?string $state): string => '
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
                            ' . e(Str::headline((string) ($state ?? 'Access'))) . '
                        </span>
                    '),

                TextColumn::make('event')
                    ->label('Event')
                    ->sortable()
                    ->html()
                    ->formatStateUsing(function (?string $state): string {
                        $event = strtolower((string) ($state ?? 'activity'));
                        $color = str_contains($event, 'logout') ? '#ef4444' : '#64748b';

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
                                    background:' . $color . ';
                                "></span>
                                ' . e(Str::headline($event)) . '
                            </span>
                        ';
                    }),

                TextColumn::make('causer.name')
                    ->label('User')
                    ->html()
                    ->formatStateUsing(fn (?string $state): string => '
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
                            👤 ' . e($state ?? '-') . '
                        </span>
                    '),

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
                            🗓 ' . e(\Carbon\Carbon::parse($state)->format('d/m/Y H:i:s')) . '
                        </span>
                    '),

                TextColumn::make('description')
                    ->label('Description')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->wrap(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('event')
                    ->label('Aktivitas')
                    ->options([
                        'login' => 'Login',
                        'logout' => 'Logout',
                    ]),
            ])
            ->recordUrl(null)
            ->toolbarActions([])
            ->paginated([10, 25, 50, 100]);
    }
}
