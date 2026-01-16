<?php
declare(strict_types=1);

namespace App\Domain\Posts\Commands;

use Illuminate\Http\UploadedFile;

final readonly class CreatePostCommand
{
    public function __construct(
        public string $title,
        public string $content,
        public int $userId,
        public UploadedFile $file,
        public array $categories,
        public array $tags
    ) {}
}
