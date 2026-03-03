<?php
declare(strict_types=1);

namespace App\Exceptions;

final class SlugMalformedException extends DomainException
{
    public static function fromString(string $slug): self
    {
        return new self("The string '{$slug}' is not a valid slug. Only lowercase Latin letters, numbers, and hyphens are allowed.");
    }
}
