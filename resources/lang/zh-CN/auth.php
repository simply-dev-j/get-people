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
    LocaleConstants::AUTH_FAIL => '用户名或密码错误。',
    LocaleConstants::AUTH_PASSWORD =>'密码错误。',
    LocaleConstants::AUTH_THROTTLE =>'您尝试的登录次数过多，请 :seconds 秒后再试。',
    LocaleConstants::AUTH_INVALID_CODE =>'Invalid code',
];
