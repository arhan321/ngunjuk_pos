<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Categories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Informasi Kategori')
                    ->description('Lengkapi data kategori produk agar menu minuman lebih mudah dikelompokkan pada sistem POS.')
                    ->icon('heroicon-o-tag')
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Kategori')
                            ->placeholder('Contoh: Coffee, Yakult, Teh')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (?string $state, callable $set): void {
                                $set('slug', Str::slug($state ?? ''));
                            })
                            ->helperText('Nama kategori akan digunakan untuk mengelompokkan produk.'),

                        TextInput::make('slug')
                            ->label('Slug Kategori')
                            ->placeholder('otomatis-dari-nama-kategori')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('Slug dibuat otomatis dari nama kategori.'),

                        Toggle::make('is_active')
                            ->label('Kategori Aktif')
                            ->helperText('Kategori aktif dapat digunakan dan ditampilkan pada sistem.')
                            ->default(true)
                            ->columnSpanFull(),
                    ])
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ]),
            ]);
    }
}