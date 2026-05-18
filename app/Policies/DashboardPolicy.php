<?php

namespace App\Policies;

use App\Models\User;

class DashboardPolicy
{
    public function viewAny(user $user)
    {
        return $user->role->name === 'admin';
    }
}
