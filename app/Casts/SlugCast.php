<?php
declare(strict_types=1);

namespace App\Casts;

use App\ValueObjects\Slug;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class SlugCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes): Slug
    {
        return new Slug((string) $value);
    }
    public function set($model, string $key, $value, array $attributes): string
    {
        if ($value instanceof Slug) {
            return $value->getValue();
        }

        return (new Slug((string) $value))->getValue();
    }
}
