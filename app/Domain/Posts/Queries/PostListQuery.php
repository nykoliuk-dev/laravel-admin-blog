<?php
declare(strict_types=1);

namespace App\Domain\Posts\Queries;

use App\Domain\Posts\DTO\PostViewDTO;
use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;

final class PostListQuery
{
    public function handle(int $page, int $perPage): LengthAwarePaginator
    {
        return Post::query()
            ->orderBy('id', 'desc')
            ->paginate(
                perPage: $perPage,
                page: $page,
            )->through(
                fn (Post $post) => new PostViewDTO(
                    id: $post->id,
                    title: $post->title,
                    slug: $post->slug,
                    content: $post->content,
                    imageUrl: $post->image_url,
                ));
    }
}
