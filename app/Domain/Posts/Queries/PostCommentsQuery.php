<?php
declare(strict_types=1);

namespace App\Domain\Posts\Queries;

use App\Domain\Comments\DTO\CommentViewDTO;
use App\Models\Comment;
use Illuminate\Pagination\LengthAwarePaginator;

final class PostCommentsQuery
{
    public function handle(int $page, int $perPage, int $postId): LengthAwarePaginator
    {
        return Comment::query()
            ->where('post_id', $postId)
            ->with('user:id,name')
            ->orderBy('updated_at', 'desc')
            ->paginate(
                perPage: $perPage,
                page: $page,
            )->through(
                fn (Comment $comment) => new CommentViewDTO(
                    id: $comment->id,
                    postId: $comment->post_id,
                    userId: $comment->user_id,
                    userName: $comment->user?->name,
                    content: $comment->content,
                    updatedAt: $comment->updated_at->toImmutable(),
                )
            );
    }
}
