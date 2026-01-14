<?php

namespace App\Http\Controllers;

use App\Domain\Posts\Commands\CreatePostCommand;
use App\Domain\Posts\Handlers\CreatePostHandler;
use App\Http\Requests\StorePostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class PostController extends Controller
{
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
        if (!$request->expectsJson()) {
            return response()->json([
                'message' => 'JSON requests only'
            ], 406);
        }

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
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
