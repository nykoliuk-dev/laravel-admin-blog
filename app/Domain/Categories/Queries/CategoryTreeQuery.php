<?php
declare(strict_types=1);

namespace App\Domain\Categories\Queries;

use App\Domain\Categories\DTO\CategoryOptionDTO;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

final class CategoryTreeQuery
{
    /**
     * @return CategoryOptionDTO[]
     */
    public function handle(): array
    {
        $categories = Category::query()->get();
        $groupedCats = $categories->groupBy('parent_id');

        return $this->buildTree($groupedCats, null, 0);
    }

    /**
     * @return CategoryOptionDTO[]
     */
    private function buildTree(Collection $groupedCats, ?int $parentId, int $depth): array
    {
        $result = [];

        foreach ($groupedCats[$parentId] ?? [] as $category) {
            $result[] = new CategoryOptionDTO(
                id: $category->id,
                name: $category->name,
                depth: $depth
            );

            $result = array_merge(
                $result,
                $this->buildTree($groupedCats, $category->id, $depth + 1)
            );
        }

        return $result;
    }
}
