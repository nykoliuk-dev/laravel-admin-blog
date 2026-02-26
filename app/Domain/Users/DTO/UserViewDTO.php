<?php
declare(strict_types=1);

namespace App\Domain\Users\DTO;

use App\DTO\IdNameDTO;
use App\Enums\RoleSlug;
use Carbon\CarbonImmutable;

final readonly class UserViewDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        /** @var array<RoleSlug> */
        public array $roles,
        public CarbonImmutable $createdAt,
        public CarbonImmutable $updatedAt,
    ) {}

    public function rolesAsString(string $separator = ' | '): string
    {
        return implode(
            $separator,
            array_map(fn(RoleSlug $role) => $role->label(), $this->roles)
        );
    }
}
