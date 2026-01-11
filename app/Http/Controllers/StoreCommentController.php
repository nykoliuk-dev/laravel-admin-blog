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
        if (!$request->expectsJson()) {
            return response()->json([
                'message' => 'JSON requests only'
            ], 406);
        }

        $validated = $request->validated();

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
}
