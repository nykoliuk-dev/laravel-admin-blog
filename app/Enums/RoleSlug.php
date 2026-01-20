<?php

namespace App\Enums;

enum RoleSlug: string
{
    case ADMIN = 'admin';
    case EDITOR = 'editor';

    public function label(): string
    {
        return match ($this){
            self::ADMIN => 'Администратор',
            self::EDITOR => 'Редактор'
        };
    }
}
