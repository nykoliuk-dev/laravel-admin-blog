<?php
declare(strict_types=1);

namespace App\Domain\Tags\DTO;

final readonly class TagDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public string $slug,
        public int $usage
    ) {}
}
