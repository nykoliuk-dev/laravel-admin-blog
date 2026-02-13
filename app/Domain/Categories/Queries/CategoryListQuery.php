<?php
declare(strict_types=1);

namespace App\Domain\Categories\Queries;

use App\Domain\Categories\DTO\CategoryDTO;
use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;

final class CategoryListQuery
{
    public function handle(int $page, int $perPage): LengthAwarePaginator
    {
        return Category::query()
            ->with(['parent:id,name'])
            ->withCount('posts')
            ->orderBy('id', 'desc')
            ->paginate(
                perPage: $perPage,
                page: $page,
            )->through(
                fn (Category $category) => new CategoryDTO(
                    id: $category->id,
                    name: $category->name,
                    slug: $category->slug,
                    parentName: $category->parent?->name,
                    postsCount: $category->posts_count,
                )
            );
    }
}
