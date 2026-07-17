<?php

declare(strict_types=1);

namespace App\Filament\Admin\Logger\Widgets;

use Filament\Widgets\Widget;

class ActivityLogAnalyticsWidget extends Widget
{
    protected string $view = 'filament.admin.logger.widgets.activity-log-analytics-widget';

    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = 'full';
}
