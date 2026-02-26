<?php
declare(strict_types=1);

namespace App\Domain\Tags\Commands;

use App\Models\Tag;

final readonly class UpdateTagCommand
{
    public function __construct(
        public Tag $currentTag,
        public string $name,
        public bool $editSlug,
        public ?string $slug,
    ) {}
}
