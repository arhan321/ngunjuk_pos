<?php

declare(strict_types=1);

namespace App\Filament\Admin\Logger\Pages;

use App\Filament\Admin\Resources\ActivityLogs\ActivityLogResource;
use App\Models\User;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;

class ListActivityLogs extends ListRecords
{
    protected static string $resource = ActivityLogResource::class;

    protected string $view = 'filament.admin.resources.activity-logs.pages.list-activity-logs';

    protected static bool $isLazy = false;

    public function getTitle(): string
    {
        return '';
    }

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function getHeaderWidgets(): array
    {
        return [];
    }

    protected function getFooterWidgets(): array
    {
        return [];
    }

    protected function applyLoginLogoutFilter($query)
    {
        return $query->where(function ($query): void {
            $query
                ->whereIn('event', ['login', 'logout'])
                ->orWhere('description', 'like', '%login%')
                ->orWhere('description', 'like', '%logout%')
                ->orWhere('description', 'like', '%logged in%')
                ->orWhere('description', 'like', '%logged out%');
        });
    }

    protected function loginLogoutQuery()
    {
        return $this->applyLoginLogoutFilter(Activity::query());
    }

    public function getActivitySummary(): array
    {
        $totalLogs = $this->loginLogoutQuery()->count();

        $loginLogs = $this->loginLogoutQuery()
            ->where(function ($query): void {
                $query
                    ->where('event', 'login')
                    ->orWhere('description', 'like', '%login%')
                    ->orWhere('description', 'like', '%logged in%');
            })
            ->count();

        $logoutLogs = $this->loginLogoutQuery()
            ->where(function ($query): void {
                $query
                    ->where('event', 'logout')
                    ->orWhere('description', 'like', '%logout%')
                    ->orWhere('description', 'like', '%logged out%');
            })
            ->count();

        $latestLog = $this->loginLogoutQuery()
            ->with('causer')
            ->latest()
            ->first();

        $topCauser = $this->loginLogoutQuery()
            ->select('causer_id', DB::raw('COUNT(*) as total_activity'))
            ->whereNotNull('causer_id')
            ->groupBy('causer_id')
            ->orderByDesc('total_activity')
            ->first();

        $topUser = $topCauser?->causer_id
            ? User::query()->find($topCauser->causer_id)
            : null;

        return [
            'total_logs' => (int) $totalLogs,
            'access_logs' => (int) $totalLogs,
            'login_logs' => (int) $loginLogs,
            'logout_logs' => (int) $logoutLogs,
            'latest_user' => $latestLog?->causer?->name ?? '-',
            'latest_event' => $latestLog?->event ?? $latestLog?->description ?? '-',
            'latest_time' => $latestLog?->created_at?->diffForHumans() ?? '-',
            'top_user' => $topUser?->name ?? '-',
            'top_user_total' => (int) ($topCauser?->total_activity ?? 0),
        ];
    }
}
