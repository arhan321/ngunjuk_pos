<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Roles;

use App\Filament\Admin\Resources\Roles\Pages\CreateRole;
use App\Filament\Admin\Resources\Roles\Pages\EditRole;
use App\Filament\Admin\Resources\Roles\Pages\ListRoles;
use App\Filament\Admin\Resources\Roles\Pages\ViewRole;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use BezhanSalleh\FilamentShield\Support\Utils;
use BezhanSalleh\FilamentShield\Traits\HasShieldFormComponents;
use BezhanSalleh\PluginEssentials\Concerns\Resource as Essentials;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Panel;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

final class RoleResource extends Resource
{
    use Essentials\BelongsToParent;
    use Essentials\BelongsToTenant;
    use Essentials\HasGlobalSearch;
    use Essentials\HasLabels;
    use Essentials\HasNavigation;
    use HasShieldFormComponents;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make()
                    ->schema([
                        Section::make('Data Role')
                            ->description('Fallback form untuk data role.')
                            ->schema([
                                TextInput::make('name')
                                    ->label(__('filament-shield::filament-shield.field.name'))
                                    ->required()
                                    ->maxLength(255),

                                TextInput::make('guard_name')
                                    ->label(__('filament-shield::filament-shield.field.guard_name'))
                                    ->default(Utils::getFilamentAuthGuard())
                                    ->nullable()
                                    ->maxLength(255),
                            ])
                            ->columns([
                                'default' => 1,
                                'md' => 2,
                            ])
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->weight(FontWeight::Bold)
                    ->searchable()
                    ->sortable()
                    ->html()
                    ->formatStateUsing(function (string $state): string {
                        $name = Str::headline($state);
                        $initial = mb_strtoupper(mb_substr($name, 0, 1));

                        return '
                            <div style="display:flex;align-items:center;gap:10px;min-width:220px;">
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
                                    '.e($initial).'
                                </div>

                                <div style="min-width:0;">
                                    <div style="
                                        color:#23160d;
                                        font-size:13px;
                                        font-weight:950;
                                        line-height:1.25;
                                    ">
                                        '.e($name).'
                                    </div>

                                    <div style="
                                        display:inline-flex;
                                        align-items:center;
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
                                    ">
                                        Role Access
                                    </div>
                                </div>
                            </div>
                        ';
                    }),

                TextColumn::make('guard_name')
                    ->label('Guard Name')
                    ->html()
                    ->formatStateUsing(fn (?string $state): string => '
                        <span style="
                            display:inline-flex;
                            align-items:center;
                            gap:7px;
                            min-height:28px;
                            padding:0 11px;
                            border-radius:999px;
                            color:#c25500;
                            background:rgba(249,115,22,.12);
                            border:1px solid rgba(249,115,22,.22);
                            font-size:10px;
                            font-weight:950;
                            white-space:nowrap;
                        ">
                            <span style="
                                width:7px;
                                height:7px;
                                border-radius:999px;
                                background:#f97316;
                            "></span>
                            '.e($state ?? 'web').'
                        </span>
                    '),

                TextColumn::make('team.name')
                    ->default('Global')
                    ->badge()
                    ->color(fn (mixed $state): string => str($state)->contains('Global') ? 'gray' : 'primary')
                    ->label(__('filament-shield::filament-shield.column.team'))
                    ->searchable()
                    ->visible(fn (): bool => self::shield()->isCentralApp() && Utils::isTenancyEnabled()),

                TextColumn::make('permissions_count')
                    ->label('Permissions')
                    ->counts('permissions')
                    ->sortable()
                    ->alignCenter()
                    ->html()
                    ->formatStateUsing(function ($state): string {
                        $count = (int) $state;

                        if ($count <= 0) {
                            $bg = 'rgba(148,163,184,.12)';
                            $border = 'rgba(148,163,184,.24)';
                            $color = '#64748b';
                            $caption = 'Belum ada';
                        } elseif ($count <= 5) {
                            $bg = 'rgba(59,130,246,.10)';
                            $border = 'rgba(59,130,246,.20)';
                            $color = '#2563eb';
                            $caption = 'Standar';
                        } else {
                            $bg = 'rgba(16,185,129,.12)';
                            $border = 'rgba(16,185,129,.22)';
                            $color = '#078657';
                            $caption = 'Lengkap';
                        }

                        return '
                            <div style="display:flex; flex-direction:column; align-items:center; gap:5px;">
                                <span style="
                                    display:inline-flex;
                                    justify-content:center;
                                    min-width:44px;
                                    min-height:30px;
                                    align-items:center;
                                    border-radius:13px;
                                    padding:0 10px;
                                    background:'.$bg.';
                                    border:1px solid '.$border.';
                                    color:'.$color.';
                                    font-weight:950;
                                    font-size:12px;
                                ">
                                    '.number_format($count, 0, ',', '.').'
                                </span>

                                <span style="
                                    color:'.$color.';
                                    font-size:10px;
                                    font-weight:850;
                                ">
                                    '.$caption.'
                                </span>
                            </div>
                        ';
                    }),

                TextColumn::make('updated_at')
                    ->label('Updated At')
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
                            '.e(\Carbon\Carbon::parse($state)->translatedFormat('d M Y H:i')).'
                        </span>
                    '),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make()
                    ->label('')
                    ->icon('heroicon-o-eye')
                    ->color('gray'),

                EditAction::make()
                    ->label('Edit')
                    ->icon('heroicon-o-pencil-square')
                    ->color('primary'),

                DeleteAction::make()
                    ->label('Delete')
                    ->icon('heroicon-o-trash')
                    ->color('danger'),
            ])
            ->toolbarActions([
                DeleteBulkAction::make()
                    ->label('Hapus Role'),
            ])
            ->defaultSort('updated_at', 'desc');
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
            'index' => ListRoles::route('/'),
            'create' => CreateRole::route('/create'),
            'view' => ViewRole::route('/{record}'),
            'edit' => EditRole::route('/{record}/edit'),
        ];
    }

    public static function getModel(): string
    {
        return Utils::getRoleModel();
    }

    public static function getSlug(?Panel $panel = null): string
    {
        return Utils::getResourceSlug();
    }

    public static function getCluster(): ?string
    {
        return Utils::getResourceCluster();
    }

    public static function getEssentialsPlugin(): ?FilamentShieldPlugin
    {
        return FilamentShieldPlugin::get();
    }
}
