<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar_url')
                    ->label('Avatar')
                    ->defaultImageUrl(function ($record): string {
                        $hash = md5(mb_strtolower(mb_trim((string) $record->email)));

                        return 'https://www.gravatar.com/avatar/' . $hash . '?d=mp&r=g&s=250';
                    })
                    ->square()
                    ->size(46)
                    ->extraImgAttributes([
                        'style' => 'border-radius: 15px; object-fit: cover; box-shadow: 0 12px 22px rgba(101,58,21,.12); border: 1px solid rgba(255,255,255,.58);',
                    ]),

                Tables\Columns\TextColumn::make('name')
                    ->label('User')
                    ->searchable()
                    ->sortable()
                    ->html()
                    ->formatStateUsing(function (?string $state, $record): string {
                        $name = $state ?: '-';
                        $email = $record->email ?? '-';
                        $initial = mb_strtoupper(mb_substr($name, 0, 1));

                        return '
                            <div style="display:flex;align-items:center;gap:10px;min-width:240px;">
                                <div style="
                                    width:38px;
                                    height:38px;
                                    border-radius:14px;
                                    display:grid;
                                    place-items:center;
                                    color:#fff;
                                    font-size:14px;
                                    font-weight:950;
                                    background:linear-gradient(135deg,#ff9d18,#ee6500);
                                    box-shadow:0 12px 24px rgba(238,101,0,.20);
                                ">
                                    ' . e($initial) . '
                                </div>

                                <div style="min-width:0;">
                                    <div style="
                                        color:#23160d;
                                        font-size:13px;
                                        font-weight:950;
                                        line-height:1.25;
                                    ">
                                        ' . e($name) . '
                                    </div>

                                    <div style="
                                        display:inline-flex;
                                        align-items:center;
                                        max-width:260px;
                                        min-height:24px;
                                        margin-top:4px;
                                        padding:0 10px;
                                        border-radius:999px;
                                        color:#6f5946;
                                        background:rgba(255,255,255,.26);
                                        border:1px solid rgba(255,255,255,.38);
                                        font-size:10px;
                                        font-weight:850;
                                        white-space:nowrap;
                                        overflow:hidden;
                                        text-overflow:ellipsis;
                                    ">
                                        ✉ ' . e($email) . '
                                    </div>
                                </div>
                            </div>
                        ';
                    }),

                Tables\Columns\TextColumn::make('roles.name')
                    ->label('Roles')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => Str::title(str_replace('_', ' ', $state)))
                    ->color(fn (string $state): string => match ($state) {
                        'super_admin' => 'success',
                        'karyawan' => 'warning',
                        default => 'gray',
                    })
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->date('d M Y')
                    ->sortable()
                    ->html()
                    ->formatStateUsing(fn ($state): string => '
                        <span style="
                            display:inline-flex;
                            align-items:center;
                            min-height:28px;
                            padding:0 10px;
                            border-radius:999px;
                            color:#2563eb;
                            background:rgba(59,130,246,.10);
                            border:1px solid rgba(59,130,246,.20);
                            font-size:10px;
                            font-weight:950;
                            white-space:nowrap;
                        ">
                            ' . e(\Carbon\Carbon::parse($state)->translatedFormat('d M Y')) . '
                        </span>
                    '),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Update')
                    ->since()
                    ->sortable()
                    ->html()
                    ->formatStateUsing(fn ($state): string => '
                        <span style="
                            display:inline-flex;
                            align-items:center;
                            min-height:28px;
                            padding:0 10px;
                            border-radius:999px;
                            color:#078657;
                            background:rgba(16,185,129,.12);
                            border:1px solid rgba(16,185,129,.22);
                            font-size:10px;
                            font-weight:950;
                            white-space:nowrap;
                        ">
                            ⏱ ' . e(\Carbon\Carbon::parse($state)->diffForHumans()) . '
                        </span>
                    '),
            ])
            ->filters([
                SelectFilter::make('roles')
                    ->label('Role')
                    ->relationship('roles', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->recordActions([
                ViewAction::make()
                    ->label('')
                    ->icon(Heroicon::Eye)
                    ->color('gray'),

                EditAction::make()
                    ->label('')
                    ->icon(Heroicon::PencilSquare)
                    ->color('primary'),

                DeleteAction::make()
                    ->label('')
                    ->icon(Heroicon::Trash)
                    ->color('danger'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Hapus User'),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}