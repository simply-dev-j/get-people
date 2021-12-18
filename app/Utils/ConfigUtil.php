<?php

namespace App\Utils;

class ConfigUtil {

    public static function AMOUNT_OF_ONE()
    {
        return env('AMOUNT_OF_ONE', 1200);
    }

    public static function AMOUNT_OF_UP_STAGE()
    {
        return env('AMOUNT_OF_UP_STAGE', 600);
    }
}
