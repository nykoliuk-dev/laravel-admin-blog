<?php
declare(strict_types=1);

namespace App\Domain\Tags\DTO;

use App\ValueObjects\Slug;

final readonly class TagDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public Slug $slug,
        public int $usage
    ) {}
}
