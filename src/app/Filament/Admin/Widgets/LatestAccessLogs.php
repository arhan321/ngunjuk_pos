<?php

declare(strict_types=1);

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\Widget;

class LatestAccessLogs extends Widget
{
    protected string $view = 'filament.admin.widgets.latest-access-logs';

    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 99;

    public static function canView(): bool
    {
        return false;
    }
}
