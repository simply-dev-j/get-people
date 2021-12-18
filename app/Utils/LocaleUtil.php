<?php

namespace App\Utils;

class LocaleUtil {
    public static $locales= ['zh-CN', 'en'];

    public static $localeTitles = [
        'zh-CN' => '中文',
        'en' => 'En'
    ];

    public static function isValidLocale($locale)
    {
        return in_array($locale, self::$locales);
    }
}
