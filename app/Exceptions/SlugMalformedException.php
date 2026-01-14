<?php
declare(strict_types=1);

namespace App\Exceptions;

final class SlugMalformedException extends DomainException
{
    public static function fromString(string $slug): self
    {
        return new self("Строка '{$slug}' не является валидным слагом. Допустимы только строчные латинские буквы, цифры и дефис.");
    }
}
