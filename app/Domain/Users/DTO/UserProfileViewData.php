<?php
declare(strict_types=1);

namespace App\Domain\Users\DTO;

use Illuminate\Pagination\LengthAwarePaginator;

final readonly class UserProfileViewData
{
    public function __construct(
        public UserViewDTO $user,
        public LengthAwarePaginator $posts,
        public LengthAwarePaginator $comments,
    ) {}
}
