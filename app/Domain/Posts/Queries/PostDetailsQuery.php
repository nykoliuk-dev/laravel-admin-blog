<?php
declare(strict_types=1);

namespace App\Domain\Posts\Queries;

use App\Domain\Posts\DTO\PostDetailsDTO;
use App\DTO\IdNameDTO;
use App\Models\Post;

final class PostDetailsQuery
{
    public function handle(string $slug): PostDetailsDTO
    {
        $post = Post::query()
            ->where('slug', $slug)
            ->with(['categories:id,name', 'tags:id,name'])
            ->withCount('comments')
            ->firstOrFail();

        $categories = $post->categories
            ->mapWithKeys(fn ($cat) => [
                $cat->id => new IdNameDTO(
                    id:   $cat->id,
                    name: $cat->name,
                )
            ])
            ->all();
        $tags = $post->tags
            ->mapWithKeys(fn ($tag) => [
                $tag->id => new IdNameDTO(
                    id:   $tag->id,
                    name: $tag->name,
                )
            ])
            ->all();

        return new PostDetailsDTO(
            id:             $post->id,
            title:          $post->title,
            slug:           $post->slug,
            content:        $post->content,
            imageUrl:       $post->image_url,
            categories:     $categories,
            tags:           $tags,
            commentsCount:  $post->comments_count,
        );
    }
}
