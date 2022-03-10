<?php

namespace App;

class LocaleConstants {
    public const FORM_BASE = 'form.';
    public const AUTH_BASE = 'auth.';
    public const MESSAGE_BASE = 'message.';

    /**
     * Form base
     */
    public const FORM_AUTH_EMAIL = 'form_auth_email';
    public const FORM_AUTH_PASSWORD = 'form_auth_password';
    public const FORM_AUTH_CODE = 'form_auth_code';
    public const FORM_AUTH_NAME = 'form_auth_name';
    public const FORM_AUTH_CONFIRM_PASSWORD = 'form_auth_password_confirm';
    public const FORM_AUTH_LOGIN = 'form_auth_login';
    public const FORM_AUTH_REGISTER = 'form_auth_register';
    public const FORM_AUTH_LOGOUT = 'form_auth_logout';
    public const FORM_AUTH_SECURITY_CODE = 'form_auth_security_code';

    public const FORM_HOME = 'form_home';
    public const FORM_HOME_PENDING = 'form_home_pending';
    public const FORM_HOME_RELEASED = 'form_home_released';
    public const FORM_HOME_TOTAL_CODE = 'form_home_total_code';
    public const FORM_HOME_ACCEPTED_CODE = 'form_home_accepted_code';
    public const FORM_HOME_VIEW_ALL = 'form_home_view_all';
    public const FORM_HOME_CREATE_NEW_CODE = 'form_home_create_new_code';
    public const FORM_HOME_CODE_GEN_SUC = 'form_home_gen_suc';
    public const FORM_HOME_CODE_COPIED = 'form_home_copied';

    public const FORM_CODE_CREATE_AT = 'form_code_create_at';
    public const FORM_CODE_CODE = 'form_code_code';

    public const FORM_ADMIN_COMPANY_MANAGEMENT = 'form_admin_company_management';
    public const FORM_ADMIN_COMPANY_ADD = 'form_admin_company_add';
    /**
     * Auth base
     */
    public const AUTH_FAIL = 'auth_fail';
    public const AUTH_PASSWORD = 'auth_password';
    public const AUTH_THROTTLE = 'auth_throttle';
    public const AUTH_INVALID_CODE = 'auth_invalid_code';

    /**
     * Message
     */
    public const MESSAGE_USER_ACTIVE_ALREADY = 'message_user_active_already';

    public const MESSAGE_CODE_DELETED = 'message_code_deleted';

    public const MESSAGE_COMPANY_ADD_SUCCESS = 'message_company_add_success';
}

