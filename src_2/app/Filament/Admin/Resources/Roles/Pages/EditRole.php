<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Roles\Pages;

use App\Filament\Admin\Resources\Roles\Pages\Concerns\ManagesCustomRoleForm;
use App\Filament\Admin\Resources\Roles\RoleResource;
use App\Filament\Admin\Resources\Roles\Widgets\RoleFormHeroWidget;
use BezhanSalleh\FilamentShield\Support\Utils;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

final class EditRole extends EditRecord
{
    use ManagesCustomRoleForm;

    protected static string $resource = RoleResource::class;

    protected string $view = 'filament.admin.resources.roles.pages.edit-role';

    protected static bool $isLazy = false;

    protected ?string $heading = '';

    protected ?string $subheading = '';

    public function mount(int|string $record): void
    {
        parent::mount($record);

        $this->record->loadMissing('permissions');

        $this->name = (string) $this->record->name;
        $this->guard_name = (string) ($this->record->guard_name ?: (Utils::getFilamentAuthGuard() ?: 'web'));
        $this->selectedPermissions = $this->record->permissions
            ->pluck('name')
            ->values()
            ->all();
    }

    public function getTitle(): string
    {
        return '';
    }

    public function saveRole(): void
    {
        $this->validate($this->roleValidationRules((int) $this->record->getKey()));

        $this->record->update([
            'name' => $this->name,
            'guard_name' => $this->normalizedGuardName(),
        ]);

        $this->record->syncPermissions($this->validSelectedPermissionNames());

        Notification::make()
            ->title('Role berhasil diperbarui')
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

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make()
                ->label('Detail Role')
                ->icon('heroicon-o-eye')
                ->color('gray'),

            DeleteAction::make()
                ->label('Hapus Role')
                ->icon('heroicon-o-trash')
                ->color('danger'),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return RoleResource::getUrl('index');
    }
}
