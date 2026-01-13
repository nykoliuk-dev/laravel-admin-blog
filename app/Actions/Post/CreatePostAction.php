<?php
declare(strict_types=1);

namespace App\Actions\Post;

use App\Models\Post;
use App\ValueObjects\Slug;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CreatePostAction
{
    public function execute(PostData $data): Post
    {
        return DB::transaction(function () use ($data) {
            $filename = Str::uuid() . '.' . $data->file->getClientOriginalExtension();
            $path = Post::UPLOAD_DIRECTORY . '/' . now()->format('Y/m');
            Storage::disk('public')->putFileAs($path, $data->file, $filename);
            $imagePath = now()->format('Y/m') . '/' . $filename;

            $post = Post::create([
                'title'      => $data->title,
                'slug'       => new Slug(Str::slug($data->title)),
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
