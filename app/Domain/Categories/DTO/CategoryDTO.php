<?php
declare(strict_types=1);

namespace App\Domain\Categories\DTO;

use App\ValueObjects\Slug;

final readonly class CategoryDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public Slug $slug,
        public ?string $parentName,
        public int $postsCount,
    ) {}
}
