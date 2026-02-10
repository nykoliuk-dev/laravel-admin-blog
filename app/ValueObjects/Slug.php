<?php
declare(strict_types=1);

namespace App\ValueObjects;

use App\Exceptions\SlugMalformedException;
use Illuminate\Support\Str;

final readonly class Slug
{
    public static function createFromString(string $value): Slug
    {
        return new Slug(Str::slug($value));
    }

    public function __construct(
        private string $value
    ) {
        if (!$this->isValid($value)) {
            throw SlugMalformedException::fromString($value);
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }

    private function isValid(string $value): bool
    {
        return (bool) preg_match('/^[a-z0-9-]+$/', $value);
    }
}
