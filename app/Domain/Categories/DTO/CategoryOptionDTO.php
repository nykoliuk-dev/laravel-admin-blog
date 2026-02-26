<?php
declare(strict_types=1);

namespace App\Domain\Categories\DTO;

final readonly class CategoryOptionDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public int $depth,
    ) {}
}
