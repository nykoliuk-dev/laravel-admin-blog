<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ImportOldBlogData extends Command
{
    /**
     * @var string
     */
    protected $signature = 'blog:import-old';

    /**
     * @var string
     */
    protected $description = 'Import data from old blog database';
    private $oldDB;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Import started');

        $this->oldDB = DB::connection('old_mariadb');
        $oldPostCategories = $this->oldDB->table('category_post')->get();
        $oldPostTags = $this->oldDB->table('post_tag')->get();

        DB::transaction(function () use ($oldPostCategories, $oldPostTags) {
            $userMap = $this->importUsers($this->getTableDataByName('users'));
            $postMap = $this->importPosts($this->getTableDataByName('posts'), $userMap);
            $categoryMap = $this->importCategories($this->getTableDataByName('categories'));
            $tagMap = $this->importTags($this->getTableDataByName('tags'));
            $commentMap = $this->importComments($this->getTableDataByName('comments'), $postMap, $userMap);

            foreach ($oldPostCategories as $row) {
                DB::table('post_category')->insert([
                    'post_id'     => $postMap[$row->post_id],
                    'category_id' => $categoryMap[$row->category_id],
                ]);
            }

            foreach ($oldPostTags as $row) {
                DB::table('post_tag')->insert([
                    'post_id'     => $postMap[$row->post_id],
                    'tag_id' => $tagMap[$row->tag_id],
                ]);
            }
        });

        return Command::SUCCESS;
    }

    private function importUsers(Collection $oldUsers): array
    {
        $userMap = [];

        foreach ($oldUsers as $oldUser){
            $user = new User([
                'name'      => $oldUser->username,
                'email'       => $oldUser->email,
                'password'    => $oldUser->password_hash,
            ]);

            $user->setCreatedAt($oldUser->created_at);
            $user->save();
            $userMap[$oldUser->id] = $user->id;
        }

        return $userMap;
    }

    private function importPosts(Collection $oldPosts, array $userMap): array
    {
        $postMap = [];

        foreach ($oldPosts as $oldPost){
            $post = new Post([
                'title'      => $oldPost->title,
                'slug'       => $oldPost->slug,
                'content'    => $oldPost->content,
                'image_name' => $oldPost->image_name,
                'user_id'    => $userMap[$oldPost->user_id] ?? null,
            ]);

            $post->setCreatedAt($oldPost->date);
            $post->save();
            $postMap[$oldPost->id] = $post->id;
        }

        return $postMap;
    }

    private function importCategories(Collection $oldCategories): array
    {
        $categoryMap = [];

        foreach ($oldCategories as $oldCategory) {
            $category = new Category([
                'parent_id' => $oldCategory->parent_id,
                'name' => $oldCategory->name,
                'slug'  => $oldCategory->slug,
            ]);
            $category->save();

            $categoryMap[$oldCategory->id] = $category->id;
        }

        return $categoryMap;
    }
    private function importTags(Collection $oldTags): array
    {
        $tagMap = [];

        foreach ($oldTags as $oldTag) {
            $tag = new Tag([
                'name' => $oldTag->name,
                'slug'  => $oldTag->slug,
            ]);
            $tag->save();

            $tagMap[$oldTag->id] = $tag->id;
        }

        return $tagMap;
    }
    private function importComments(Collection $oldComments, array $postMap, array $userMap): array
    {
        $commentMap = [];

        foreach ($oldComments as $oldComment) {
            $comment = new Comment([
                'post_id' => $postMap[$oldComment->post_id],
                'user_id'  => $userMap[$oldComment->user_id] ?? null,
                'content'  => $oldComment->content,
            ]);
            $comment->save();

            $commentMap[$oldComment->id] = $comment->id;
        }

        return $commentMap;
    }

    private function getTableDataByName(string $name): Collection
    {
        return $this->oldDB->table($name)->get();
    }
}
