<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use Illuminate\Support\Facades\Log;

class StoreCommentController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreCommentRequest $request)
    {
        $validated = $request->validated();

        $validated['user_id'] = auth()->id();

        $comment = Comment::query()->create()($validated);

        return response()->json([
            'success' => true,
            'message' => "Комментарий успешно добавлен!",
        ], 201);
    }
}
