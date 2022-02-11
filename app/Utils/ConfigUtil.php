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

    public static function AMOUNT_OF_ONE_WITHDRAWN_FOR_ROOT()
    {
        return env('AMOUNT_OF_ONE_WITHDRAWN_FOR_ROOT', -3000);
    }

    public static function AMOUNT_OF_ONE_RELEASED_FOR_ROOT()
    {
        return env('AMOUNT_OF_ONE_RELEASED_FOR_ROOT', 300);
    }

    public static function AMOUNT_OF_ACCEPT_FUND_TRANSFER_REQUEST()
    {
        return env('AMOUNT_OF_ONE_RELEASED_FOR_ROOT', 2400);
    }
}
