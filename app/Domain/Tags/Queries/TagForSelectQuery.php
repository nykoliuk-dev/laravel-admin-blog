<?php
declare(strict_types=1);

namespace App\Domain\Tags\Queries;

use App\Domain\Tags\DTO\TagOptionDTO;
use App\Models\Tag;

final class TagForSelectQuery
{
    /**
     * @return TagOptionDTO[]
     */
    public function handle(): array
    {
        $tagModels = Tag::query()
            ->orderBy('name')
            ->get();

        return array_map(
            fn (Tag $tag) => new TagOptionDTO(
                id: $tag->id,
                name: $tag->name,
                slug: $tag->slug,
            ),
            $tagModels->all()
        );
    }
}
