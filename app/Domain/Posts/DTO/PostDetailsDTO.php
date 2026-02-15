<?php
declare(strict_types=1);

namespace App\Domain\Posts\DTO;

use App\DTO\IdNameDTO;
use App\ValueObjects\Slug;

final readonly class PostDetailsDTO
{
    public function __construct(
        public int $id,
        public string $title,
        public Slug $slug,
        public string $content,
        public string $imageUrl,
        /** @var IdNameDTO[] */
        public array $categories,
        /** @var IdNameDTO[] */
        public array $tags,
        public int $commentsCount,
    ) {}
}
