<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'post_id'      => 'required|integer|exists:posts,id',
            'content'      => 'required|min:3|max:2000',
        ];

        $validated = $request->validate($rules);

        $validated['user_id'] = auth()->id();

        try {
            $comment = Comment::create($validated);

            return response()->json([
                'success' => true,
                'message' => "Комментарий успешно добавлен!",
            ], 201);
        } catch (\Throwable $e) {
            Log::error($e);

            return response()->json([
                'success' => false,
                'message' => 'Ошибка при создании комментария.',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
