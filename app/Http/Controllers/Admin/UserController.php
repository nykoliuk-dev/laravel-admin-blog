<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Domain\Users\Commands\CreateUserCommand;
use App\Domain\Users\Handlers\CreateUserHandler;
use App\Domain\Users\Queries\UserListQuery;
use App\Enums\RoleSlug;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

    public function store()
    {

    }

    public function show()
    {

    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}
