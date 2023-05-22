<?php

return [
    // the key to use for session/ajax impersonation
    'key' => env('MS_IMPERSONATE_KEY', 'user-proxy'),

    // what route application will be redirected to after impersonating is started/ended
    'redirect_to' => env(
        'MS_IMPERSONATE_REDIRECT_TO',
        config('moonshine.route.prefix', '/')
    ),

    'routes' => [
        // impersonate routes prefix
        'prefix' => env('MS_IMPERSONATE_ROUTE_PREFIX', 'impersonate'),

        // what middleware is used for routes to enter/stop impersonation
        'middleware' => ['web'],
    ],

    'buttons' => [
        'enter' => [
            'icon' => env('MS_IMPERSONATE_ENTER_BUTTON_ICON', 'heroicons.outline.eye')
        ],
        'stop' => [
            // if true the button will be set to the header of the page
            'enabled' => env('MS_IMPERSONATE_STOP_BUTTON_ENABLED', true),
            'icon' => env('MS_IMPERSONATE_STOP_BUTTON_ICON', 'heroicons.outline.eye-slash'),
            'class' => env('MS_IMPERSONATE_STOP_BUTTON_CLASS', 'btn-pink'),
        ],
    ],
];
