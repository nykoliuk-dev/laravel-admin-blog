<?php
declare(strict_types=1);

namespace App\Domain\Users\DTO;

use Carbon\CarbonImmutable;

final readonly class UserViewDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public CarbonImmutable $createdAt,
        public CarbonImmutable $updatedAt,
    ) {}
}
