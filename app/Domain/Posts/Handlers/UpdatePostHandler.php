<?php
declare(strict_types=1);

namespace App\Domain\Posts\Handlers;

use App\Domain\Posts\Commands\UpdatePostCommand;
use App\Domain\Posts\Services\PostImageService;
use App\Models\Post;
use App\ValueObjects\Slug;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UpdatePostHandler
{
    public function __construct(
        private PostImageService $imageService
    ) {}

    public function handle(UpdatePostCommand $command): Post
    {
        $post = Post::where('slug', $command->currentSlug)->firstOrFail();

        return DB::transaction(function () use ($command, $post) {
            $post->title = $command->title;
            $post->content = $command->content;
            $post->slug = new Slug(Str::slug($command->title));

            if($command->file){
                $this->imageService->delete($post->image_name, Post::UPLOAD_DIRECTORY);
                $post->image_name = $this->imageService->upload($command->file, Post::UPLOAD_DIRECTORY);
            }

            $post->save();

            $post->categories()->sync($data->categories ?? []);
            $post->tags()->sync($data->tags ?? []);

            return $post;
        });
    }
}
