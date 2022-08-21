<?php

namespace App\Enums;

/**
 * @SuppressWarnings(PHPMD)
 */
enum UserTypeEnum: string
{
    case COMMON = 'COMUM';
    case SHOPKEEPER = 'LOJISTA';

    public static function toArray(): array
    {
        return array_map(fn ($enum) => $enum->value,UserTypeEnum::cases());
    }
}
