<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Domain\Users\Commands\CreateUserCommand;
use App\Domain\Users\DTO\UserViewDTO;
use App\Domain\Users\Handlers\CreateUserHandler;
use App\Domain\Users\Queries\GetUserProfileQuery;
use App\Domain\Users\Queries\UserListQuery;
use App\Enums\RoleSlug;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
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

        $userPaginator = $query->handle(
            page: $page,
            perPage: $perPage,
        );

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

    public function edit(User $user): View
    {
        Gate::authorize('update', $user);

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
            'roles' => RoleSlug::cases(),
        ]);
    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}
