<?php

namespace App\Models;

use App\Casts\SlugCast;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

/**
 * @property \App\ValueObjects\Slug $slug
 */
class Post extends Model
{
    public const UPLOAD_DIRECTORY = 'posts';
    protected $fillable = [
        'title',
        'slug',
        'content',
        'image_name',
        'user_id',
    ];

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'post_tag');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(
            Category::class,
            'post_category',
            'post_id',
            'category_id',
        );
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->image_name
                ? Storage::url(self::UPLOAD_DIRECTORY . '/' . $this->image_name)
                : asset('assets/img/default-post.jpg'),
        );
    }

    protected function casts(): array
    {
        return [
            'slug' => SlugCast::class,
        ];
    }
}
