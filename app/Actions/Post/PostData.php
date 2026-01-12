<?php
declare(strict_types=1);

namespace App\Actions\Post;

use Illuminate\Http\UploadedFile;

final readonly class PostData
{
    public function __construct(
        public readonly string $title,
        public readonly string $content,
        public readonly int $userId,
        public readonly UploadedFile $file,
        public readonly array $categories,
        public readonly array $tags
    ) {}
}
