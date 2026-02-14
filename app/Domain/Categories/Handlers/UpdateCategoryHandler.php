<?php
declare(strict_types=1);

namespace App\Domain\Categories\Handlers;

use App\Domain\Categories\Commands\UpdateCategoryCommand;
use App\Models\Category;
use App\ValueObjects\Slug;

class UpdateCategoryHandler
{
    public function handle(UpdateCategoryCommand $command): Category
    {
        $category = Category::query()->where('slug', $command->currentCategorySlug)->firstOrFail();

        $category->name = $command->name;
        $category->parent_id = $command->parentId;;

        if($command->editSlug){
            $category->slug = new Slug($command->slug);
        }

        $category->save();

        return $category;
    }
}
