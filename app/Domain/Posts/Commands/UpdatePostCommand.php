<?php
declare(strict_types=1);

namespace App\Domain\Posts\Commands;

use App\Models\Post;
use Illuminate\Http\UploadedFile;

final readonly class UpdatePostCommand
{
    public function __construct(
        public Post $currentPost,
        public string $title,
        public string $content,
        public int $userId,
        public ?UploadedFile $file,
        public array $categories,
        public array $tags
    ) {}
}
