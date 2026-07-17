<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ActivityLogs\Widgets;

use Filament\Widgets\Widget;

class ActivityLogAnalyticsWidget extends Widget
{
    protected string $view = 'filament.admin.resources.activity-logs.widgets.activity-log-analytics-widget';

    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = 'full';
}
