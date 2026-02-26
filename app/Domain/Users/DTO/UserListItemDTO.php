<?php
declare(strict_types=1);

namespace App\Domain\Users\DTO;

final readonly class UserListItemDTO
{
    public function __construct(
        public UserViewDTO $dto,
        public bool $canUpdate,
        public bool $canDelete,
    ) {}
}
