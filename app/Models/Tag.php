<?php

namespace App\Models;

use App\Casts\SlugCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'post_tag');
    }

    protected function casts(): array
    {
        return [
            'slug' => SlugCast::class,
        ];
    }
}
