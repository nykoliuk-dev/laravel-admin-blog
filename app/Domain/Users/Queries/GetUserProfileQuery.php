<?php
declare(strict_types=1);

namespace App\Domain\Users\Queries;

use App\Domain\Comments\DTO\UserCommentViewDTO;
use App\Domain\Posts\DTO\PostViewDTO;
use App\Domain\Users\DTO\UserProfileViewData;
use App\Domain\Users\DTO\UserViewDTO;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Role;
use App\Models\User;

class GetUserProfileQuery
{
    public function handle(int $userId, int $postsPage, int $commentsPage, int $perPage): UserProfileViewData
    {
        $user = User::query()
            ->where('id', $userId)
            ->with('roles')
            ->firstOrFail();

        $userDTO = new UserViewDTO(
            id: $user->id,
            name: $user->name,
            email: $user->email,
            roles: $user->roles->map(fn (Role $role) => $role->slug)->all(),
            createdAt: $user->created_at->toImmutable(),
            updatedAt: $user->updated_at->toImmutable(),
        );

        $posts = Post::query()
            ->where('user_id', $user->id)
            ->orderBy('id', 'desc')
            ->paginate(
                perPage: $perPage,
                pageName: 'posts_page',
                page: $postsPage,
            )->through(
                fn (Post $post) => new PostViewDTO(
                    id: $post->id,
                    title: $post->title,
                    slug: $post->slug,
                    content: $post->content,
                    imageUrl: $post->image_url,
                ));

        $comments = Comment::query()
            ->where('user_id', $user->id)
            ->orderBy('id', 'desc')
            ->paginate(
                perPage: $perPage,
                pageName: 'comments_page',
                page: $commentsPage,
            )->through(
                fn (Comment $comment) => new UserCommentViewDTO(
                    id: $comment->id,
                    postId: $comment->post_id,
                    content: $comment->content,
                    updatedAt: $comment->updated_at->toImmutable(),
                ));

        return new UserProfileViewData(
            user: $userDTO,
            posts: $posts,
            comments: $comments,
        );
    }
}
