<?php

namespace App\Constants;

class ItemLanguages
{
    public const English = 'english';
    public const GERMAN = 'german';
    public const HUNGARIAN = 'hungarian';
    public const FRENCH = 'french';
    public const ROMANIAN = 'romanian';
    public const ITALIAN = 'italian';
    public const OTHERS = 'others';
    public const INTERNATIONAL = 'international';

    public static function getLanguages():array
    {
        return [
            self::English,
            self::GERMAN,
            self::HUNGARIAN,
            self::FRENCH,
            self::ROMANIAN,
            self::ITALIAN,
            self::OTHERS,
            self::INTERNATIONAL
        ];
    }
}