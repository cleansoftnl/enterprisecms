<?php

if (!defined('WEBED_USERS')) {
    define('WEBED_USERS', 'webed-users');
}


return [
    'front_actions' => [
        'login' => [
            'view' => 'webed-theme::front.auth.login',
            'controller' => WebEd\Base\Users\Http\Controllers\Front\AuthFrontController::class,
        ],
        'register' => [
            'view' => 'webed-theme::front.auth.register',
            'controller' => WebEd\Base\Users\Http\Controllers\Front\RegisterController::class,
        ],
        'forgot_password' => [
            'view' => 'webed-theme::front.auth.forgot-password',
            'controller' => WebEd\Base\Users\Http\Controllers\Front\ForgotPasswordController::class,
            'email_template' => WEBED_USERS . '::front.emails.forgot-password',
            /**
             * The unit is day. Only accept integer.
             */
            'link_expired_after' => 1,
        ],
        'reset_password' => [
            'view' => 'webed-theme::front.auth.reset-password',
            'controller' => WebEd\Base\Users\Http\Controllers\Front\ResetPasswordController::class,
            'auto_sign_in_after_reset' => true,
            'remember_login' => true,
        ],
    ],
];
