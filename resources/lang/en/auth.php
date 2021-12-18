<?php

use App\LocaleConstants;

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    LocaleConstants::AUTH_FAIL => 'These credentials do not match our records.',
    LocaleConstants::AUTH_PASSWORD => 'The provided password is incorrect.',
    LocaleConstants::AUTH_THROTTLE => 'Too many login attempts. Please try again in :seconds seconds.',
    LocaleConstants::AUTH_INVALID_CODE =>'Invalid code',
];
