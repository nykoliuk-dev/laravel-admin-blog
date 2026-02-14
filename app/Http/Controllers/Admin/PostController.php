<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Categories\Queries\CategoryTreeQuery;
use App\Domain\Posts\Queries\PostListQuery;
use App\Domain\Tags\Queries\TagForSelectQuery;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

    /**
     * Show the form for creating a new resource.
     */
    public function create(CategoryTreeQuery $categoryQuery, TagForSelectQuery $tagQuery): View
    {
        $categories = $categoryQuery->handle(null);
        $tags = $tagQuery->handle();

        return view('admin.posts.create', [
            'title' => 'Add New Post',
            'categories' => $categories,
            'tags' => $tags,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {

    }

    /**
     * Display the specified resource.
     */
    public function show()
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update()
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {

    }
}
