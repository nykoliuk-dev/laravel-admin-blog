<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Domain\Users\Queries\UserListQuery;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

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

    public function create()
    {

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
