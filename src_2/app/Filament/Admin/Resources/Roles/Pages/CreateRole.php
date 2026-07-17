<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Roles\Pages;

use App\Filament\Admin\Resources\Roles\Pages\Concerns\ManagesCustomRoleForm;
use App\Filament\Admin\Resources\Roles\RoleResource;
use App\Filament\Admin\Resources\Roles\Widgets\RoleFormHeroWidget;
use BezhanSalleh\FilamentShield\Support\Utils;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

final class CreateRole extends CreateRecord
{
    use ManagesCustomRoleForm;

    protected static string $resource = RoleResource::class;

    protected string $view = 'filament.admin.resources.roles.pages.create-role';

    protected static bool $isLazy = false;

    protected ?string $heading = '';

    protected ?string $subheading = '';

    public function mount(): void
    {
        parent::mount();

        $this->guard_name = Utils::getFilamentAuthGuard() ?: 'web';
    }

    public function getTitle(): string
    {
        return '';
    }

    public function saveRole(): void
    {
        $this->validate($this->roleValidationRules());

        $roleModel = Utils::getRoleModel();

        $role = $roleModel::query()->create([
            'name' => $this->name,
            'guard_name' => $this->normalizedGuardName(),
        ]);

        $role->syncPermissions($this->validSelectedPermissionNames());

        Notification::make()
            ->title('Role berhasil dibuat')
            ->success()
            ->send();

        $this->redirect($this->getRedirectUrl());
    }

    protected function getHeaderWidgets(): array
    {
        return [
            RoleFormHeroWidget::class,
        ];
    }

    protected function getRedirectUrl(): string
    {
        return RoleResource::getUrl('index');
    }
}
