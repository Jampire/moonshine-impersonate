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
        'prefix' => env('MS_IMPERSONATE_ROUTE_PREFIX', config('moonshine.route.prefix').'/impersonate'),

        // what middleware is used for routes to enter/stop impersonation
        'middleware' => ['web'],
    ],

    'buttons' => [
        'enter' => [
            'icon' => env('MS_IMPERSONATE_ENTER_BUTTON_ICON', 'heroicons.outline.eye')
        ],
        'stop' => [
            'icon' => env('MS_IMPERSONATE_STOP_BUTTON_ICON', 'heroicons.outline.eye-slash'),
            'class' => env('MS_IMPERSONATE_STOP_BUTTON_CLASS', 'btn-secondary'),
        ],
    ],

    // query string key name for resource item
    'resource_item_key' => env('MS_IMPERSONATE_RESOURCE_ITEM_KEY', 'resourceItem'),

    // show 'toast' notifications on different actions
    'show_notification' => env('MS_IMPERSONATE_SHOW_NOTIFICATION', true),
];
