<?php

return [
    // the key to use for session/ajax impersonation
    'key' => env('MS_IMPERSONATE_KEY', 'user-proxy'),

    // what route application will be redirected to after impersonating is started/ended
    'redirect_to' => env('MS_IMPERSONATE_REDIRECT_TO'),

    'routes' => [
        // impersonate routes prefix
        'prefix' => env('MS_IMPERSONATE_ROUTE_PREFIX', 'impersonate'),

        // what middleware is used for routes to enter/stop impersonation
        'middleware' => ['web'],
    ],

    'register_menu' => env('MS_IMPERSONATE_MENU', true),
    'show_documentation' => env('MS_IMPERSONATE_SHOW_DOCS', true),

    'buttons' => [
        'enter' => [
            'icon' => env('MS_IMPERSONATE_ENTER_BUTTON_ICON', 'heroicons.outline.lock-open')
        ],
        'stop' => [
            // if true the button will be set to the header of the page
            'enabled' => env('MS_IMPERSONATE_STOP_BUTTON_ENABLED', true),
            'icon' => env('MS_IMPERSONATE_STOP_BUTTON_ICON', 'heroicons.outline.lock-closed'),
            'class' => env('MS_IMPERSONATE_STOP_BUTTON_CLASS', 'btn-pink'),
        ],
    ],

    'resources' => [
        'impersonated' => [
            'fields' => [
                'name' => env('MS_RS_IMPERSONATED_FIELDS_NAME', 'name'),
                'email' => env('MS_RS_IMPERSONATED_FIELDS_NAME', 'email'),
            ],
        ],
    ],

    'default_auth_guard' => env('MS_IMPERSONATE_DEFAULT_GUARD', 'web'),
];
