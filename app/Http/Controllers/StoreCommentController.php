<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Post;

class StoreCommentController extends Controller
{
    public function __invoke(StoreCommentRequest $request, Post $post)
    {
        $comment = $post->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->validated('content'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Comment successfully added!',
            'comment' => [
                'content' => $comment->content,
                'author' => $comment->user?->name ?? 'Гость',
                'created_at' => $comment->created_at->format('d.m.Y H:i'),
            ],
        ], 201);
    }
}
