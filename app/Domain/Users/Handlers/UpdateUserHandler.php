<?php
declare(strict_types=1);

namespace App\Domain\Users\Handlers;

use App\Domain\Users\Commands\UpdateUserCommand;
use App\Enums\RoleSlug;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\Gate;
use Illuminate\Support\Facades\DB;

class UpdateUserHandler
{
    public function __construct(
        private Gate $gate
    ) {}
    public function handle(UpdateUserCommand $command): User
    {
        $user = User::query()->where('id', $command->userId)->firstOrFail();

        $this->gate->authorize('update', $user);

        return DB::transaction(function () use ($command, $user)
        {
            $user->name = $command->name;
            $user->email = $command->email;

            $user->save();

            if($command->roles !== null){
                $this->gate->authorize('changeRole', $user);

                $roles = array_map(
                    function (string $role) use ($user)
                    {
                        $roleEnum = RoleSlug::from($role);
                        $this->gate->authorize('assignRole', [$user, $roleEnum]);

                        return $roleEnum;
                    },
                    $command->roles
                );

                $roleIds = Role::query()
                    ->whereIn('slug', array_map(fn (RoleSlug $role) => $role->value, $roles))
                    ->pluck('id');

                $user->roles()->sync($roleIds);
            }

            return $user;
        });
    }
}
