<?php
declare(strict_types=1);

namespace App\Domain\Tags\Queries;

use App\Domain\Posts\DTO\PostViewDTO;
use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;

final class TagPostsPaginatedQuery
{
    public function handle(int $page, int $perPage, int $tagId): LengthAwarePaginator
    {
        return Post::query()
            ->whereRelation('tags', 'post_tag.tag_id', $tagId)
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
