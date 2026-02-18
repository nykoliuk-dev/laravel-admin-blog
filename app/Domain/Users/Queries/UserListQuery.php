<?php
declare(strict_types=1);

namespace App\Domain\Users\Queries;

use App\Domain\Users\DTO\UserViewDTO;
use App\DTO\IdNameDTO;
use App\Models\Role;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

final class UserListQuery
{
    public function handle(int $page, int $perPage): LengthAwarePaginator
    {
        return User::query()
            ->with('roles')
            ->orderBy('id', 'desc')
            ->paginate(
                perPage: $perPage,
                page: $page,
            )->through(
                fn (User $user) => new UserViewDTO(
                    id: $user->id,
                    name: $user->name,
                    email: $user->email,
                    roles: $user->roles->map(fn (Role $role) => $role->slug)->all(),
                    createdAt: $user->created_at->toImmutable(),
                    updatedAt: $user->updated_at->toImmutable(),
                ));
    }
}
