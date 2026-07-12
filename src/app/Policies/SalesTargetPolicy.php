<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\SalesTarget;
use Illuminate\Auth\Access\HandlesAuthorization;

class SalesTargetPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:SalesTarget');
    }

    public function view(AuthUser $authUser, SalesTarget $salesTarget): bool
    {
        return $authUser->can('View:SalesTarget');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:SalesTarget');
    }

    public function update(AuthUser $authUser, SalesTarget $salesTarget): bool
    {
        return $authUser->can('Update:SalesTarget');
    }

    public function delete(AuthUser $authUser, SalesTarget $salesTarget): bool
    {
        return $authUser->can('Delete:SalesTarget');
    }

}