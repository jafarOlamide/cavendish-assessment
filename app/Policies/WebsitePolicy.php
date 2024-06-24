<?php

namespace App\Policies;

use App\Enums\RoleTypes;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class WebsitePolicy
{
    public function delete(User $user)
    {
        return $user->role->name  == RoleTypes::ADMIN ? Response::allow()
            : Response::denyAsNotFound();
    }
}
