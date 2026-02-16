<?php
declare(strict_types=1);

namespace App\Domain\Comments\DTO;

use Carbon\CarbonImmutable;

final readonly class CommentViewDTO
{
    public function __construct(
        public int $id,
        public int $postId,
        public ?int $userId,
        public ?string $userName,
        public string $content,
        public CarbonImmutable $updatedAt,
    ) {}
}
