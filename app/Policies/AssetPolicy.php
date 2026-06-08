<?php

namespace App\Policies;

use App\Models\Asset;
use App\Models\User;

class AssetPolicy
{
    protected function isSuperAdmin(User $user): bool
    {
        return $user->role?->slug === 'super_admin';
        // or whatever field identifies super admin
    }

    public function view(User $user, Asset $asset): bool
    {
        return true;
    }

    public function edit(User $user, Asset $asset): bool
    {
        if ($this->isSuperAdmin($user)) {
            return true;
        }

        return $user->department_id === $asset->home_department_id;
    }

    public function assign(User $user, Asset $asset): bool
    {
        return $this->edit($user, $asset);
    }

    public function transfer(User $user, Asset $asset): bool
    {
        return $this->edit($user, $asset);
    }

    public function handover(User $user, Asset $asset): bool
    {
        return $this->edit($user, $asset);
    }

    public function takeback(User $user, Asset $asset): bool
    {
        return $this->edit($user, $asset);
    }
}
