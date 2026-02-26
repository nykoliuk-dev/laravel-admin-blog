<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Domain\Users\Commands\CreateUserCommand;
use App\Domain\Users\Commands\UpdateUserCommand;
use App\Domain\Users\DTO\UserListItemDTO;
use App\Domain\Users\DTO\UserViewDTO;
use App\Domain\Users\Handlers\CreateUserHandler;
use App\Domain\Users\Handlers\UpdateUserHandler;
use App\Domain\Users\Queries\GetUserProfileQuery;
use App\Domain\Users\Queries\UserListQuery;
use App\Enums\RoleSlug;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function index(Request $request, UserListQuery $query): View
    {
        $page = (int) $request->query('page', 1);
        $perPage = min(max(1, (int) $request->query('perPage', 3)), 100);

        $auth = auth()->user();

        $userPaginator = $query->handle(
            page: $page,
            perPage: $perPage,
        )->through(fn($item) => new UserListItemDTO(
            dto: $item['dto'],
            canUpdate: $auth->can('update', $item['raw']),
            canDelete: $auth->can('delete', $item['raw']),
        ));

        return view('admin.users.index', [
            'title' => 'User List Page',
            'users' => $userPaginator,
        ]);
    }

    public function create(): View
    {
        return view('admin.users.create', [
            'title' => 'Create New User',
            'roles' => RoleSlug::cases(),
        ]);
    }

    public function store(StoreUserRequest $request, CreateUserHandler $userHandler): RedirectResponse
    {
        $data = $request->validated();

        $roles = array_map(
            fn(string $role) => RoleSlug::tryFrom($role),
            $data['roles'] ?? []
        );

        $command = new CreateUserCommand(
            name: $data['name'],
            email: $data['email'],
            password: $data['password'],
            roles: $roles,
        );
        $userHandler->handle($command);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User created successfully');
    }

    public function show(Request $request, int $id, GetUserProfileQuery $query): View
    {
        $result = $query->handle(
            userId: $id,
            postsPage: (int) $request->query('posts_page', 1),
            commentsPage: (int) $request->query('comments_page', 1),
            perPage: min(max(1, (int) $request->query('perPage', 3)), 100),
        );

        return view('admin.users.show', [
            'title' => 'User Page',
            'user' => $result->user,
            'posts' => $result->posts,
            'comments' => $result->comments,
        ]);
    }

    public function edit(User $user, UserPolicy $policy): View
    {
        Gate::authorize('update', $user);

        /** @var User $auth */
        $auth = auth()->user();
        $allowedRoles = $policy->allowedRoles($auth, $user);

        return view('admin.users.edit', [
            'title' => 'Edit User Page',
            'user' => new UserViewDTO(
                id: $user->id,
                name: $user->name,
                email: $user->email,
                roles: $user->roles->map(fn (Role $role) => $role->slug)->all(),
                createdAt: $user->created_at->toImmutable(),
                updatedAt: $user->updated_at->toImmutable(),
            ),
            'canEditRole' => $auth->can('changeRole', $user),
            'roles' => $allowedRoles,
        ]);
    }

    public function update(int $id, UpdateUserRequest $request, UpdateUserHandler $userHandler): RedirectResponse
    {
        $data = $request->validated();

        $roles = $request->has('roles_present')
            ? ($data['roles'] ?? [])
            : null;

        $userHandler->handle(new UpdateUserCommand(
            userId: $id,
            name: $data['name'],
            email: $data['email'],
            roles: $roles,
        ));

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User updated successfully');
    }

    public function destroy(User $user): RedirectResponse
    {
        Gate::authorize('delete', $user);
        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User deleted successfully');
    }
}
