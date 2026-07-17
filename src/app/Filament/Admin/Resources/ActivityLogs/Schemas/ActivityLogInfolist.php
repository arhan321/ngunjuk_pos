<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ActivityLogs\Schemas;

use Filament\Infolists\Components\KeyValueEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Models\Activity as ActivityModel;

class ActivityLogInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(4)
            ->components([
                Section::make('Informasi Aktivitas')
                    ->description('Detail utama aktivitas yang tercatat pada sistem POS Ngunjuk.')
                    ->icon('heroicon-o-clipboard-document-list')
                    ->columnSpan(3)
                    ->columns(2)
                    ->schema([
                        TextEntry::make('causer.name')
                            ->label('User')
                            ->badge()
                            ->color('primary')
                            ->placeholder('-'),

                        TextEntry::make('subject_type')
                            ->label('Subject')
                            ->badge()
                            ->color('success')
                            ->placeholder('-')
                            ->formatStateUsing(function (?Model $record, ?string $state) {
                                /** @var Activity&ActivityModel $record */
                                return $state ? Str::of($state)->afterLast('\\')->headline().' # '.$record->subject_id : '-';
                            }),

                        TextEntry::make('description')
                            ->label('Description')
                            ->columnSpanFull(),
                    ]),

                Section::make('Meta Log')
                    ->description('Informasi event, type, dan waktu log.')
                    ->icon('heroicon-o-information-circle')
                    ->columnSpan(1)
                    ->schema([
                        TextEntry::make('log_name')
                            ->label('Type')
                            ->badge()
                            ->color('success')
                            ->formatStateUsing(function (?Model $record): string {
                                /** @var Activity&ActivityModel $record */
                                return $record->log_name ? ucwords($record->log_name) : '-';
                            }),

                        TextEntry::make('event')
                            ->label('Event')
                            ->badge()
                            ->color(fn (?string $state): string => match ($state) {
                                'created' => 'warning',
                                'updated' => 'primary',
                                'deleted' => 'danger',
                                default => 'gray',
                            })
                            ->formatStateUsing(function (?Model $record): string {
                                return $record?->event ? ucwords($record?->event) : '-';
                            }),

                        TextEntry::make('created_at')
                            ->label('Logged At')
                            ->badge()
                            ->color('gray')
                            ->formatStateUsing(function (?Model $record): string {
                                /** @var Activity&ActivityModel $record */
                                return $record->created_at
                                    ? $record->created_at->format(config('filament-logger.datetime_format', 'd/m/Y H:i:s'))
                                    : '-';
                            }),
                    ]),

                Section::make('Properties')
                    ->description('Perubahan atribut lama dan baru yang tercatat pada log.')
                    ->columns()
                    ->columnSpan(4)
                    ->visible(fn ($record) => $record->properties?->count() > 0)
                    ->schema(function (?Model $record) {
                        /** @var Activity&ActivityModel $record */
                        $properties = $record->properties->except(['attributes', 'old']);

                        $schema = [];

                        if ($properties->count()) {
                            $schema[] = KeyValueEntry::make('properties')
                                ->label('Properties')
                                ->columnSpanFull();
                        }

                        if ($old = $record->properties->get('old')) {
                            $schema[] = KeyValueEntry::make('old')
                                ->label('Old Attributes')
                                ->formatStateUsing(fn () => $old);
                        }

                        if ($attributes = $record->properties->get('attributes')) {
                            $schema[] = KeyValueEntry::make('attributes')
                                ->label('New Attributes')
                                ->formatStateUsing(fn () => $attributes);
                        }

                        return $schema;
                    }),
            ]);
    }
}
