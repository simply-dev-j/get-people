<?php

namespace App;

class WebRoute {
    public const LOCALE_CHANGE = 'locale.change';

    // auth
    public const AUTH_LOGIN = 'auth.login';
    public const AUTH_LOGIN_POST = 'auth.login.post';
    public const AUTH_REGISTER = 'auth.register';
    public const AUTH_REGISTER_POST = 'auth.register.post';

    // home
    public const HOME_INDEX = 'home.index';

    // code
    public const CODE_INDEX = 'home.code.index';
    public const CODE_CREATE = 'home.code.create';
}
