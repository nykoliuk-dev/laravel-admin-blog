<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Categories\Queries\CategoryTreeQuery;
use App\Domain\Posts\Commands\CreatePostCommand;
use App\Domain\Posts\Handlers\CreatePostHandler;
use App\Domain\Posts\Queries\PostDetailsQuery;
use App\Domain\Posts\Queries\PostListQuery;
use App\Domain\Tags\Queries\TagForSelectQuery;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
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
    public function store(StorePostRequest $request, CreatePostHandler $postHandler): RedirectResponse
    {
        $postData = new CreatePostCommand(
            title: $request->validated('title'),
            content: $request->validated('content'),
            userId: auth()->id(),
            file: $request->file('file'),
            categories: $request->validated('categories', []),
            tags: $request->validated('tags', [])
        );
        $post = $postHandler->handle($postData);

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Post created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {

    }

    /**
     * Show the form for editing the specified resource.
     * @param string $post slug of the post
     */
    public function edit(
        string $post,
        PostDetailsQuery $postQuery,
        CategoryTreeQuery $categoryQuery,
        TagForSelectQuery $tagQuery
    ): View
    {
        $post = $postQuery->handle($post);
        $categories = $categoryQuery->handle(null);
        $tags = $tagQuery->handle();

        return view('admin.posts.edit', [
            'title' => 'Edit Post Page',
            'post' => $post,
            'categories' => $categories,
            'tags' => $tags,
        ]);
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
