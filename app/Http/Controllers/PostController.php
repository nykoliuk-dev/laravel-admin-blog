<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
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
    public function store(Request $request): JsonResponse
    {
        if (!request()->expectsJson()) {
            return response()->json([
                'message' => 'JSON requests only'
            ], 406);
        }

        $rules = [
            'title'   => 'required|min:3',
            'content' => 'required',
            'file'    => 'required|image|max:1024',

            // === Categories ===
            'categories'      => 'array',
            'categories.*'    => 'integer|min:1',

            // === Tags ===
            'tags'            => 'array',
            'tags.*'          => 'integer|min:1',
        ];

        $validated = $request->validate($rules);

        $file = $request->file('file');
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $file->move(
            public_path('assets/img/gallery'),
            $filename
        );
        $validated['user_id'] = auth()->id();

        try {
            DB::transaction(function () use ($validated, $request, $filename) {
                $post = Post::create([
                    'title'      => $validated['title'],
                    'slug'       => Str::slug($validated['title']),
                    'content'    => $validated['content'],
                    'image_name' => $filename,
                    'user_id'    => $validated['user_id'],
                ]);

                $post->categories()->sync($validated['categories'] ?? []);
                $post->tags()->sync($validated['tags'] ?? []);
            });

            return response()->json([
                'success' => true,
                'message' => "Пост {$validated['user_id']} успешно добавлен!",
            ]);
        } catch (\Throwable $e) {
            Log::error($e);

            return response()->json([
                'success' => false,
                'message' => 'Ошибка при создании поста.',
            ], 500);
        }
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
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
