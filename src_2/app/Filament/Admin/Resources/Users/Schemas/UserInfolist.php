<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Users\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;

final class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Detail User')
                    ->description('Informasi lengkap akun pengguna sistem POS Ngunjuk.')
                    ->icon(Heroicon::UserCircle)
                    ->schema([
                        ImageEntry::make('avatar_url')
                            ->label('Avatar')
                            ->defaultImageUrl(function ($record): string {
                                $hash = md5(mb_strtolower(mb_trim((string) $record->email)));

                                return 'https://www.gravatar.com/avatar/'.$hash.'?d=mp&r=g&s=250';
                            })
                            ->columnSpan(1),

                        Grid::make(3)
                            ->schema([
                                TextEntry::make('name')
                                    ->label('Nama User')
                                    ->weight('bold')
                                    ->columnSpan(2),

                                TextEntry::make('roles.name')
                                    ->label('Roles')
                                    ->badge()
                                    ->icon(Heroicon::ShieldCheck)
                                    ->formatStateUsing(fn (string $state): string => Str::title(str_replace('_', ' ', $state)))
                                    ->placeholder('-')
                                    ->columnSpan(1),

                                TextEntry::make('email')
                                    ->label('Email Address')
                                    ->icon(Heroicon::Envelope)
                                    ->copyable()
                                    ->columnSpanFull(),

                                Grid::make(2)
                                    ->schema([
                                        TextEntry::make('created_at')
                                            ->label('Dibuat')
                                            ->dateTime('d M Y H:i')
                                            ->placeholder('-')
                                            ->icon(Heroicon::Calendar)
                                            ->columnSpan(1),

                                        TextEntry::make('updated_at')
                                            ->label('Terakhir Update')
                                            ->dateTime('d M Y H:i')
                                            ->placeholder('-')
                                            ->icon(Heroicon::Calendar)
                                            ->columnSpan(1),
                                    ])
                                    ->columnSpanFull(),
                            ])
                            ->columnSpan(5),
                    ])
                    ->columns(6),
            ]);
    }
}
