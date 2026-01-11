<?php
declare(strict_types=1);

namespace App\Actions\Post;

use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreatePostAction
{
    public function execute(array $data): Post
    {
        return DB::transaction(function () use ($data) {
            $post = Post::create([
                'title'      => $data['title'],
                'slug'       => Str::slug($data['title']),
                'content'    => $data['content'],
                'image_name' => $data['image_name'],
                'user_id'    => $data['user_id'],
            ]);

            $post->categories()->sync($data['categories'] ?? []);
            $post->tags()->sync($data['tags'] ?? []);

            return $post;
        });
    }
}
