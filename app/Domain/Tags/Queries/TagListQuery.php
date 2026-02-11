<?php
declare(strict_types=1);

namespace App\Domain\Tags\Queries;

use App\Domain\Tags\DTO\TagDTO;
use App\Models\Tag;
use Illuminate\Pagination\LengthAwarePaginator;

final class TagListQuery
{
    public function execute(int $page, int $perPage, string $path, array $query): LengthAwarePaginator
    {
        $offset = ($page - 1) * $perPage;

        $tagModels = Tag::query()
            ->withCount('posts')
            ->orderBy('id')
            ->offset($offset)
            ->limit($perPage)
            ->get();

        $tagItems  = array_map(
            fn (Tag $tag) => new TagDTO(
                id: $tag->id,
                name: $tag->name,
                slug: $tag->slug,
                usage: $tag->posts_count,
            ),
            $tagModels->all()
        );

        return new LengthAwarePaginator(
            items: $tagItems,
            total: Tag::query()->count(),
            perPage: $perPage,
            currentPage: $page,
            options: [
                'path' => $path,
                'query' => $query,
            ],
        );
    }
}
