<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Roles\Widgets;

use App\Filament\Admin\Resources\Roles\RoleResource;
use BezhanSalleh\FilamentShield\Support\Utils;
use Filament\Widgets\Widget;

final class RoleFormHeroWidget extends Widget
{
    protected string $view = 'filament.admin.resources.roles.widgets.role-form-hero-widget';

    protected int|string|array $columnSpan = 'full';

    protected static bool $isLazy = false;

    public function getViewData(): array
    {
        $routeName = request()->route()?->getName() ?? '';
        $isEdit = str_contains($routeName, '.edit');

        $roleModel = Utils::getRoleModel();
        $permissionModel = Utils::getPermissionModel();

        $totalRoles = $roleModel::query()->count();

        $totalPermissions = $permissionModel::query()->count();

        $webRoles = $roleModel::query()
            ->where('guard_name', 'web')
            ->count();

        return [
            'isEdit' => $isEdit,
            'title' => $isEdit ? 'Edit Role' : 'Tambah Role Baru',
            'description' => $isEdit
                ? 'Perbarui nama role, guard, dan permission akses pengguna pada sistem POS.'
                : 'Buat role baru untuk mengatur hak akses pengguna pada sistem POS Ngunjuk.',
            'backUrl' => RoleResource::getUrl('index'),
            'stats' => [
                'total_roles' => (int) $totalRoles,
                'total_permissions' => (int) $totalPermissions,
                'web_roles' => (int) $webRoles,
            ],
        ];
    }
}
