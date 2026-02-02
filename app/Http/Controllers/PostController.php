<?php

namespace App\Http\Controllers;

use App\Domain\Posts\Commands\CreatePostCommand;
use App\Domain\Posts\Commands\UpdatePostCommand;
use App\Domain\Posts\Handlers\CreatePostHandler;
use App\Domain\Posts\Handlers\UpdatePostHandler;
use App\Http\Middleware\EnsureJsonRequest;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class PostController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(EnsureJsonRequest::class, only: ['store', 'update']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $posts = Post::latest()->get();

        return view('posts.index', [
            'title' => 'Список постов',
            'posts' => $posts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        Gate::authorize('create', Post::class);

        $categories = Category::all();
        $tags = Tag::all();

        return view('posts.create', [
            'title' => 'Добавить статью',
            'categories' => $categories,
            'tags' => $tags,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request, CreatePostHandler $action): JsonResponse
    {
        Gate::authorize('create', Post::class);

        $postData = new CreatePostCommand(
            title: $request->validated('title'),
            content: $request->validated('content'),
            userId: auth()->id(),
            file: $request->file('file'),
            categories: $request->validated('categories', []),
            tags: $request->validated('tags', [])
        );
        $post = $action->handle($postData);

        return response()->json([
            'success' => true,
            'message' => "Пост {$post->id} успешно добавлен!",
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post): View
    {
        return view('posts.show', [
            'title' => $post->title,
            'post' => $post,
            'categories' => $post->categories,
            'tags' => $post->tags,
            'comments' => $post->comments,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post): View
    {
        Gate::authorize('update', $post);

        $post->load('categories', 'tags');
        $categories = Category::all();
        $tags = Tag::all();

        return view('posts.edit', [
            'title' => $post->title,
            'post' => $post,
            'categories' => $categories,
            'tags' => $tags,
            'comments' => $post->comments,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post, UpdatePostHandler $action)
    {
        Gate::authorize('update', $post);

        $postData = new UpdatePostCommand(
            currentPost: $post,
            title: $request->validated('title'),
            content: $request->validated('content'),
            userId: auth()->id(),
            file: $request->file('file'),
            categories: $request->validated('categories', []),
            tags: $request->validated('tags', [])
        );

        $post = $action->handle($postData);

        return response()->json([
            'success' => true,
            'message' => "Пост {$post->id} успешно обновлен!",
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        Gate::authorize('delete', Post::class);

        $post->delete();
    }
}
