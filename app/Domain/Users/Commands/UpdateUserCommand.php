<?php
declare(strict_types=1);

namespace App\Domain\Users\Commands;

final readonly class UpdateUserCommand
{
    public function __construct(
        public int $userId,
        public string $name,
        public string $email,
        public ?array $roles,
    ) {}
}
