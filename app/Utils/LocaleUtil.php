<?php

namespace App\Utils;

class LocaleUtil {
    public static $locales= ['cn', 'en'];

    public static $localeTitles = [
        'cn' => '中文',
        'en' => 'En'
    ];

    public static function isValidLocale($locale)
    {
        return in_array($locale, self::$locales);
    }
}
