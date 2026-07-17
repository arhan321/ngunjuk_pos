<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Roles\Pages\Concerns;

use BezhanSalleh\FilamentShield\Support\Utils;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

trait ManagesCustomRoleForm
{
    public ?string $name = '';

    public ?string $guard_name = 'web';

    public array $selectedPermissions = [];

    public string $activePermissionTab = 'resources';

    public function getPermissionTabsProperty(): array
    {
        return $this->buildPermissionTabs();
    }

    public function getSelectedPermissionCountProperty(): int
    {
        return count(array_unique($this->selectedPermissions));
    }

    public function getTotalPermissionCountProperty(): int
    {
        return count($this->getAllPermissionNames());
    }

    public function toggleSelectAll(): void
    {
        $allPermissions = $this->getAllPermissionNames();

        $this->selectedPermissions = $this->selectedPermissionCount >= count($allPermissions)
            ? []
            : $allPermissions;
    }

    public function selectGroupPermissions(array $permissions): void
    {
        $this->selectedPermissions = array_values(array_unique([
            ...$this->selectedPermissions,
            ...$permissions,
        ]));
    }

    public function deselectGroupPermissions(array $permissions): void
    {
        $this->selectedPermissions = array_values(array_diff($this->selectedPermissions, $permissions));
    }

    protected function roleValidationRules(?int $ignoreId = null): array
    {
        $guardName = $this->normalizedGuardName();

        $uniqueRule = Rule::unique(config('permission.table_names.roles'), 'name')
            ->where(fn ($query) => $query->where('guard_name', $guardName));

        if ($ignoreId !== null) {
            $uniqueRule->ignore($ignoreId);
        }

        return [
            'name' => ['required', 'string', 'max:255', $uniqueRule],
            'guard_name' => ['nullable', 'string', 'max:255'],
            'selectedPermissions' => ['array'],
            'selectedPermissions.*' => ['string'],
        ];
    }

    protected function normalizedGuardName(): string
    {
        return $this->guard_name ?: (Utils::getFilamentAuthGuard() ?: 'web');
    }

    protected function validSelectedPermissionNames(): array
    {
        $permissionModel = Utils::getPermissionModel();

        return $permissionModel::query()
            ->where('guard_name', $this->normalizedGuardName())
            ->whereIn('name', array_unique($this->selectedPermissions))
            ->pluck('name')
            ->all();
    }

    protected function getAllPermissionNames(): array
    {
        $permissionModel = Utils::getPermissionModel();

        return $permissionModel::query()
            ->where('guard_name', $this->normalizedGuardName())
            ->orderBy('name')
            ->pluck('name')
            ->all();
    }

    protected function buildPermissionTabs(): array
    {
        $permissionModel = Utils::getPermissionModel();

        $tabs = [
            'resources' => ['label' => 'Resources', 'count' => 0, 'groups' => []],
            'pages' => ['label' => 'Pages', 'count' => 0, 'groups' => []],
            'widgets' => ['label' => 'Widgets', 'count' => 0, 'groups' => []],
        ];

        $permissions = $permissionModel::query()
            ->where('guard_name', $this->normalizedGuardName())
            ->orderBy('name')
            ->pluck('name');

        foreach ($permissions as $permissionName) {
            [$action, $subject] = $this->parsePermissionName($permissionName);
            $tabKey = $this->classifyPermissionTab($action, $subject);
            $groupKey = Str::slug($tabKey . '-' . $subject);

            if (! isset($tabs[$tabKey]['groups'][$groupKey])) {
                $tabs[$tabKey]['groups'][$groupKey] = [
                    'title' => Str::headline($subject),
                    'subtitle' => $this->permissionSubtitle($tabKey, $subject),
                    'permissions' => [],
                ];
            }

            $tabs[$tabKey]['groups'][$groupKey]['permissions'][] = [
                'name' => $permissionName,
                'label' => Str::headline($action),
                'order' => $this->permissionActionOrder($action),
            ];

            $tabs[$tabKey]['count']++;
        }

        foreach ($tabs as $tabKey => $tab) {
            foreach ($tab['groups'] as $groupKey => $group) {
                usort(
                    $tabs[$tabKey]['groups'][$groupKey]['permissions'],
                    fn (array $a, array $b): int => $a['order'] <=> $b['order']
                );
            }
        }

        return $tabs;
    }

    protected function parsePermissionName(string $permissionName): array
    {
        $separator = config('filament-shield.permissions.separator', ':');

        if (str_contains($permissionName, $separator)) {
            return [
                Str::before($permissionName, $separator),
                Str::after($permissionName, $separator),
            ];
        }

        return ['Permission', $permissionName];
    }

    protected function classifyPermissionTab(string $action, string $subject): string
    {
        $subjectLower = Str::lower($subject);

        if (Str::contains($subjectLower, ['widget', 'chart', 'table', 'stats', 'overview'])) {
            return 'widgets';
        }

        if ($action === 'View' && Str::contains($subjectLower, ['dashboard', 'page', 'profile', 'report'])) {
            return 'pages';
        }

        return 'resources';
    }

    protected function permissionSubtitle(string $tabKey, string $subject): string
    {
        return match ($tabKey) {
            'pages' => 'Filament\\Pages\\' . $subject,
            'widgets' => 'App\\Filament\\Admin\\Widgets\\' . $subject,
            default => 'App\\Models\\' . $subject,
        };
    }

    protected function permissionActionOrder(string $action): int
    {
        return [
            'ViewAny' => 10,
            'View' => 20,
            'Create' => 30,
            'Update' => 40,
            'Delete' => 50,
            'DeleteAny' => 60,
            'Restore' => 70,
            'RestoreAny' => 80,
            'ForceDelete' => 90,
            'ForceDeleteAny' => 100,
        ][$action] ?? 999;
    }
}
