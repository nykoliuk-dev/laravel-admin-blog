<?php
declare(strict_types=1);

namespace App\Domain\Tags\Handlers;

use App\Domain\Tags\Commands\UpdateTagCommand;
use App\Models\Tag;
use App\ValueObjects\Slug;

class UpdateTagHandler
{
    public function handle(UpdateTagCommand $command): Tag
    {
        $tag = $command->currentTag;

        $tag->name = $command->name;

        if($command->editSlug){
            $tag->slug = new Slug($command->slug);
        }

        $tag->save();

        return $tag;
    }
}
