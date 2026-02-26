<?php
declare(strict_types=1);

namespace App\Domain\Categories\Queries;

use App\Domain\Posts\DTO\PostViewDTO;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;

final class CategoryPostsPaginatedQuery
{
    public function handle(int $page, int $perPage, Category $category): LengthAwarePaginator
    {
        return $category->posts()
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
