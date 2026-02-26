<?php
declare(strict_types=1);

namespace App\Domain\Comments\DTO;

use Carbon\CarbonImmutable;

final readonly class UserCommentViewDTO
{
    public function __construct(
        public int $id,
        public int $postId,
        public string $content,
        public CarbonImmutable $updatedAt,
    ) {}
}
