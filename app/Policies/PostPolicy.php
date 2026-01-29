<?php

namespace App\Policies;

use App\Enums\RoleSlug;
use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole(RoleSlug::ADMIN)
            || $user->hasRole(RoleSlug::EDITOR);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Post $post): bool
    {
        return $user->hasRole(RoleSlug::ADMIN)
            || (
                $user->hasRole(RoleSlug::EDITOR)
                && $post->user_id === $user->id
            );
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        return $user->hasRole(RoleSlug::ADMIN);
    }
}
