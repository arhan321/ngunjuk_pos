<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Users\Widgets;

use App\Filament\Admin\Resources\Users\UserResource;
use App\Models\User;
use Filament\Widgets\Widget;

final class UserFormHeroWidget extends Widget
{
    protected string $view = 'filament.admin.resources.users.widgets.user-form-hero-widget';

    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = 'full';

    public function getViewData(): array
    {
        $routeName = request()->route()?->getName() ?? '';
        $isEdit = str_contains($routeName, '.edit');

        $totalUsers = User::query()->count();

        $superAdmins = User::query()
            ->whereHas('roles', function ($query): void {
                $query->where('name', 'super_admin');
            })
            ->count();

        $karyawan = User::query()
            ->whereHas('roles', function ($query): void {
                $query->where('name', 'karyawan');
            })
            ->count();

        return [
            'isEdit' => $isEdit,
            'title' => $isEdit ? 'Edit User' : 'Tambah User Baru',
            'description' => $isEdit
                ? 'Perbarui profil pengguna, role akses, avatar, email, dan password akun.'
                : 'Tambahkan akun pengguna baru untuk super admin atau karyawan yang akan mengakses sistem POS.',
            'backUrl' => UserResource::getUrl('index'),
            'stats' => [
                'total_users' => (int) $totalUsers,
                'super_admins' => (int) $superAdmins,
                'karyawan' => (int) $karyawan,
            ],
        ];
    }
}
