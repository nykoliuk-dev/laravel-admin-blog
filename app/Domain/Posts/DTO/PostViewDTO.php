<?php
declare(strict_types=1);

namespace App\Domain\Posts\DTO;

use App\ValueObjects\Slug;

final readonly class PostViewDTO
{
    public function __construct(
        public int $id,
        public string $title,
        public Slug $slug,
        public string $content,
        public string $imageUrl,
    ) {}
}
