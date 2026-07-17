<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ActivityLogs\Pages;

use App\Filament\Admin\Resources\ActivityLogs\ActivityLogResource;
use Filament\Resources\Pages\ViewRecord;

class ViewActivityLog extends ViewRecord
{
    protected static string $resource = ActivityLogResource::class;

    protected ?string $heading = 'Detail Activity Log';

    protected ?string $subheading = 'Lihat detail aktivitas sistem dan perubahan data yang tercatat.';
}
