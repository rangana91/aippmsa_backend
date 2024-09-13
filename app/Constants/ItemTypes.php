<?php

namespace App\Constants;

class ItemTypes
{
    public const SHIRT = 'shirt';
    public const T_SHIRT = 't-shirt';
    public const SHORT = 'short';
    public const BLOUSE = 'blouse';
    public const SKIRT = 'skirt';
    public const SUNGLASSES = 'sunglasses';
    public const SHOES = 'shoes';
    public const SANDALS = 'sandals';
    public const HANDBAG = 'handbag';


    public static function getItems():array
    {
        return [
            self::SHIRT,
            self::T_SHIRT,
            self::SHORT,
            self::BLOUSE,
            self::SKIRT,
            self::SUNGLASSES,
            self::SHOES,
            self::SANDALS,
            self::HANDBAG
        ];
    }
}
