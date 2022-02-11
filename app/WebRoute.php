<?php

namespace App;

class WebRoute {
    public const LOCALE_CHANGE = 'locale.change';

    // auth
    public const AUTH_LOGIN = 'auth.login';
    public const AUTH_LOGIN_POST = 'auth.login.post';
    public const AUTH_REGISTER = 'auth.register';
    public const AUTH_REGISTER_POST = 'auth.register.post';
    public const AUTH_LOGOUT = 'auth.logout';
    public const AUTH_PROFILE = 'auth.profile';
    public const AUTH_PROFILE_POST = 'auth.profile.post';
    public const AUTH_BANK = 'auth.bank';
    public const AUTH_BANK_POST = 'auth.bank.post';
    public const AUTH_RESET_PASSWORD = 'auth.reset.password';
    public const AUTH_RESET_PASSWORD_POST = 'auth.reset.password.post';
    public const AUTH_PHONE = 'auth.phone';

    // home
    public const HOME_INDEX = 'home.index';

    // code
    public const CODE_INDEX = 'home.code.index';
    public const CODE_CREATE = 'home.code.create';
    public const CODE_DELETE = 'home.code.delete';

    // transaction
    public const TRANSACTION_INDEX = 'home.transaction.index';

    // team
    public const TEAM_INDEX = 'team.index';
    public const TEAM_NET = 'team.net';

    // center
    public const CENTER_INDEX = 'center.index';
    public const CENTER_REGISTER = 'center.register';
    public const CENTER_REGISTER_POST = 'center.register.post';

    // fund
    public const FUND_CONVERSION_INDEX = 'fund.converison.index';
    public const FUND_CONVERSION_POST = 'fund.conversion.post';
    public const FUND_TRANSFER_INDEX = 'fund.transfer.index';
    public const FUND_TRANSFER_POST = 'fund.transfer.post';
    public const FUND_WITHDRAW_INDEX = 'fund.withdraw.index';
    public const FUND_TRANSFER_APPROVAL_REQUEST = 'fund.transfer.approval.request';
    public const FUND_TRANSFER_REQUEST_INDEX = 'fund.transfer.request.index';
    public const FUND_TRANSFER_REQUEST_APPROVE = 'fund.transfer.request.approve';

    // admin
    public const ADMIN_USER_INDEX = 'admin.user.index';
    public const ADMIN_USER_CREATE = 'admin.user.create';
    public const ADMIN_USER_ACTIVATE = 'admin.user.activate';
    public const ADMIN_USER_ACTIVATE_IN_SPEC_NET = 'admin.user.activate.in.spec.net';
    public const ADMIN_USER_INACTIVATE = 'admin.user.inactivate';
    public const ADMIN_USER_DELETE = 'admin.user.delete';
    public const ADMIN_USER_VALIDATE_NAME = 'admin.user.validate.name';
}
