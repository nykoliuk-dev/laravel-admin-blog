<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Posts\Queries\PostListQuery;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(Request $request, PostListQuery $query): View
    {
        $postPaginator = $query->handle(
            page: (int) $request->query('page', 1),
            perPage: (int) $request->query('perPage', 3),
        );

        return view('admin.posts.index', [
            'title' => 'Post List Page',
            'posts' => $postPaginator,
        ]);
    }
}
