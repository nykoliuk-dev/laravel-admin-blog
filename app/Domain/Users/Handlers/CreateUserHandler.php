<?php
declare(strict_types=1);

namespace App\Domain\Users\Handlers;

use App\Domain\Users\Commands\CreateUserCommand;
use App\Enums\RoleSlug;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CreateUserHandler
{
    public function handle(CreateUserCommand $command): User
    {
        return DB::transaction(function () use ($command)
        {
            $user = User::query()->create([
                'name' => $command->name,
                'email' => $command->email,
                'password' => Hash::make($command->password),
            ]);
            $roleIds = Role::query()
                ->whereIn('slug', array_map(fn (RoleSlug $role) => $role->value, $command->roles))
                ->pluck('id');

            $user->roles()->sync($roleIds);

            return $user;
        });
    }
}
