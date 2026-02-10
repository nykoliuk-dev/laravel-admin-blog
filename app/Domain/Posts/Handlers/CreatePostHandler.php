<?php
declare(strict_types=1);

namespace App\Domain\Posts\Handlers;

use App\Domain\Posts\Commands\CreatePostCommand;
use App\Models\Post;
use App\ValueObjects\Slug;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CreatePostHandler
{
    public function handle(CreatePostCommand $data): Post
    {
        return DB::transaction(function () use ($data) {
            $filename = Str::uuid() . '.' . $data->file->getClientOriginalExtension();
            $subPath = now()->format('Y/m');
            $path = Post::UPLOAD_DIRECTORY . '/' . $subPath;
            Storage::disk('public')->putFileAs($path, $data->file, $filename);
            $imagePath = $subPath . '/' . $filename;

            $post = Post::create([
                'title'      => $data->title,
                'slug'       => Slug::createFromString($data->title),
                'content'    => $data->content,
                'image_name' => $imagePath,
                'user_id'    => $data->userId,
            ]);

            $post->categories()->sync($data->categories ?? []);
            $post->tags()->sync($data->tags ?? []);

            return $post;
        });
    }
}
