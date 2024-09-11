<?php

namespace App\Constants;

class ItemTypes
{
    public const SHIRT = 'shirt';
    public const T_SHIRT = 't-shirt';
    public const SHORT = 'short';
    public const BLOUSE = 'blouse';
    public const SKIRT = 'skirt';

    public static function getItems():array
    {
        return [
            self::SHIRT,
            self::T_SHIRT,
            self::SHORT,
            self::BLOUSE,
            self::SKIRT
        ];
    }
}
