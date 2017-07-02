<?php

/**
 * Global config for WebEd
 * @author Tedozi Manson <duyphan.developer@gmail.com>
 */
return [
    /**
     * Admin route slug
     */
    'admin_route' => env('WEBED_ADMIN_ROUTE', 'admincp'),
    'system_route' => env('WEBED_SYSTEM_ROUTE', 'systemcp'),
    'email_route' => env('WEBED_EMAIL_ROUTE', 'emailcp'),
    'calendar_route' => env('WEBED_CALENDAR_ROUTE', 'calendarcp'),

    'api_route' => env('WEBED_API_ROUTE', 'api'),

    'languages' => [
        'en' => 'English'
    ],
];
