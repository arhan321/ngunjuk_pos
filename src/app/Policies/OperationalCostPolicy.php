<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\OperationalCost;
use Illuminate\Auth\Access\HandlesAuthorization;

class OperationalCostPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:OperationalCost');
    }

    public function view(AuthUser $authUser, OperationalCost $operationalCost): bool
    {
        return $authUser->can('View:OperationalCost');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:OperationalCost');
    }

    public function update(AuthUser $authUser, OperationalCost $operationalCost): bool
    {
        return $authUser->can('Update:OperationalCost');
    }

    public function delete(AuthUser $authUser, OperationalCost $operationalCost): bool
    {
        return $authUser->can('Delete:OperationalCost');
    }

}