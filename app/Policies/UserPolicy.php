<?php

namespace App\Policies;

use App\Enums\RoleSlug;
use App\Models\User;

class UserPolicy
{
    public function update(User $auth, User $target): bool
    {
        if ($auth->id === $target->id) {
            return true;
        }

        // ADMIN
        if ($auth->hasRole(RoleSlug::ADMIN)) {
            return ! $target->hasRole(RoleSlug::ADMIN);
        }

        // EDITOR
        if ($auth->hasRole(RoleSlug::EDITOR)) {
            return ! $target->hasRole(RoleSlug::ADMIN)
                && ! $target->hasRole(RoleSlug::EDITOR);
        }

        return false;
    }

    public function delete(User $auth, User $target): bool
    {
        if ($auth->id === $target->id) {
            return false;
        }

        return $this->update($auth, $target);
    }

    public function changeRole(User $auth, User $target): bool
    {
        if ($auth->id === $target->id) {
            return false;
        }

        // ADMIN
        if ($auth->hasRole(RoleSlug::ADMIN)) {
            return ! $target->hasRole(RoleSlug::ADMIN);
        }

        // EDITOR
        if ($auth->hasRole(RoleSlug::EDITOR)) {
            return ! $target->hasRole(RoleSlug::ADMIN)
                && ! $target->hasRole(RoleSlug::EDITOR);
        }

        return false;
    }
}
