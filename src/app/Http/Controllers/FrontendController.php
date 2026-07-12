<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\View\View;
use Spatie\Permission\Models\Role;

final class FrontendController extends Controller
{
    public function settings(): View
    {
        $user = auth()->user();

        $userRole = $user->getRoleNames()->first() ?? '-';

        $roles = Role::query()
            ->orderBy('name')
            ->get();

        return view('settings', [
            'user' => $user,
            'userRole' => $userRole,
            'roles' => $roles,
        ]);
    }
}
