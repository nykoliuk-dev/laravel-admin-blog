<?php
declare(strict_types=1);

namespace App\Domain\Users\Commands;

use App\Enums\RoleSlug;

final readonly class CreateUserCommand
{
    /** @param RoleSlug[] $roles */
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public array $roles,
    ) {}
}
