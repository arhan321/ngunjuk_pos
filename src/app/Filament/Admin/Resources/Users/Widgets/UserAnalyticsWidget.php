<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Users\Widgets;

use App\Models\User;
use Filament\Widgets\Widget;

final class UserAnalyticsWidget extends Widget
{
    protected string $view = 'filament.admin.resources.users.widgets.user-analytics-widget';

    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = 'full';

    public function getViewData(): array
    {
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

        $newUsers = User::query()
            ->where('created_at', '>=', now()->subDays(30))
            ->count();

        $latestUser = User::query()
            ->with('roles')
            ->latest()
            ->first();

        return [
            'summary' => [
                'total_users' => (int) $totalUsers,
                'super_admins' => (int) $superAdmins,
                'karyawan' => (int) $karyawan,
                'new_users' => (int) $newUsers,
                'latest_user_name' => $latestUser?->name ?? '-',
                'latest_user_email' => $latestUser?->email ?? '-',
                'latest_user_role' => $latestUser?->roles?->pluck('name')->map(
                    fn (string $role): string => str($role)->replace('_', ' ')->title()->toString()
                )->implode(', ') ?: '-',
            ],
        ];
    }
}
