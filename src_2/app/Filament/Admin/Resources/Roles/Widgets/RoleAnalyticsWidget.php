<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Roles\Widgets;

use BezhanSalleh\FilamentShield\Support\Utils;
use Filament\Widgets\Widget;

final class RoleAnalyticsWidget extends Widget
{
    protected string $view = 'filament.admin.resources.roles.widgets.role-analytics-widget';

    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = 'full';

    public function getViewData(): array
    {
        $roleModel = Utils::getRoleModel();
        $permissionModel = Utils::getPermissionModel();

        $totalRoles = $roleModel::query()->count();

        $totalPermissions = $permissionModel::query()->count();

        $webRoles = $roleModel::query()
            ->where('guard_name', 'web')
            ->count();

        $topRole = $roleModel::query()
            ->withCount('permissions')
            ->orderByDesc('permissions_count')
            ->first();

        $emptyRoles = $roleModel::query()
            ->doesntHave('permissions')
            ->count();

        return [
            'summary' => [
                'total_roles' => (int) $totalRoles,
                'total_permissions' => (int) $totalPermissions,
                'web_roles' => (int) $webRoles,
                'empty_roles' => (int) $emptyRoles,
                'top_role_name' => $topRole?->name ?? '-',
                'top_role_permissions' => (int) ($topRole?->permissions_count ?? 0),
            ],
        ];
    }
}
