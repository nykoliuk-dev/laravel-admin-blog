<?php
declare(strict_types=1);

namespace App\Domain\Categories\Commands;

use App\Models\Category;

final readonly class UpdateCategoryCommand
{
    public function __construct(
        public string $currentCategorySlug,
        public string $name,
        public ?int $parentId,
        public bool $editSlug,
        public ?string $slug,
    ) {}
}
