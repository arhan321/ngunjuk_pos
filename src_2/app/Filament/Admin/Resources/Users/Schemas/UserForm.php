<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Users\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Hash;

final class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Profil User')
                    ->description('Lengkapi data profil pengguna sistem POS Ngunjuk.')
                    ->icon(Heroicon::UserCircle)
                    ->columnSpanFull()
                    ->schema([
                        FileUpload::make('avatar_url')
                            ->label('Avatar')
                            ->image()
                            ->imageEditor()
                            ->imagePreviewHeight('250')
                            ->panelAspectRatio('6:5')
                            ->panelLayout('integrated')
                            ->directory('avatars')
                            ->disk('public')
                            ->visibility('public')
                            ->helperText('Gunakan foto profil yang jelas agar akun mudah dikenali.')
                            ->columnSpan([
                                'default' => 1,
                                'md' => 2,
                            ]),

                        Grid::make([
                            'default' => 1,
                            'md' => 2,
                        ])
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nama User')
                                    ->placeholder('Contoh: Admin Ngunjuk')
                                    ->required()
                                    ->minLength(2)
                                    ->maxLength(255)
                                    ->columnSpanFull(),

                                TextInput::make('email')
                                    ->label('Email')
                                    ->placeholder('admin@admin.com')
                                    ->required()
                                    ->prefixIcon(Heroicon::Envelope)
                                    ->email()
                                    ->unique(ignoreRecord: true)
                                    ->columnSpanFull(),

                                Select::make('roles')
                                    ->label('Roles')
                                    ->relationship('roles', 'name')
                                    ->prefixIcon(Heroicon::ShieldCheck)
                                    ->multiple()
                                    ->preload()
                                    ->searchable()
                                    ->required()
                                    ->helperText('Pilih role user, misalnya Super Admin atau Karyawan.')
                                    ->columnSpanFull(),
                            ])
                            ->columnSpan([
                                'default' => 1,
                                'md' => 4,
                            ]),
                    ])
                    ->columns([
                        'default' => 1,
                        'md' => 6,
                    ]),

                Section::make('Keamanan Akun')
                    ->description('Atur password user. Saat edit, kosongkan password jika tidak ingin mengganti password.')
                    ->icon(Heroicon::LockClosed)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->confirmed()
                            ->revealable()
                            ->prefixIcon(Heroicon::FingerPrint)
                            ->dehydrateStateUsing(fn ($state) => filled($state) ? Hash::make($state) : null)
                            ->dehydrated(fn ($state): bool => filled($state))
                            ->required(fn (string $context): bool => $context === 'create')
                            ->helperText('Password wajib diisi saat membuat user baru.'),

                        TextInput::make('password_confirmation')
                            ->label('Konfirmasi Password')
                            ->required(fn (string $context): bool => $context === 'create')
                            ->password()
                            ->revealable()
                            ->prefixIcon(Heroicon::FingerPrint),
                    ])
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ]),
            ]);
    }
}
