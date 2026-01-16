<?php
declare(strict_types=1);

namespace App\ValueObjects;

use App\Exceptions\SlugMalformedException;

final readonly class Slug
{
    public function __construct(
        private string $value
    ) {
        if (!$this->isValid($value)) {
            throw SlugMalformedException::fromString($value);
        }
    }

    private function isValid(string $value): bool
    {
        return (bool) preg_match('/^[a-z0-9-]+$/', $value);
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
