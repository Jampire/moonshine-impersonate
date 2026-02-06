<?php

declare(strict_types=1);

return [
    // the key to use for session/ajax impersonation
    'key' => (string)env('MS_IMPERSONATE_KEY', 'user-proxy'),

    // what route application will be redirected to after impersonating is started/ended
    'redirect_to' => [
        'enter' => (string)env(
            'MS_IMPERSONATE_ENTER_REDIRECT_TO',
            config('moonshine.prefix', '/')
        ),
        'stop' => (string)env(
            'MS_IMPERSONATE_STOP_REDIRECT_TO',
            config('moonshine.prefix', '/')
        ),
    ],

    'routes' => [
        // impersonate routes prefix
        'prefix' => (string)env(
            'MS_IMPERSONATE_ROUTE_PREFIX',
            config('moonshine.prefix').'/impersonate'
        ),

        // what middleware is used for routes to enter/stop impersonation
        'middleware' => ['web'],
    ],

    'buttons' => [
        'enter' => [
            'icon' => (string)env('MS_IMPERSONATE_ENTER_BUTTON_ICON', 'users')
        ],
        'stop' => [
            'icon' => (string)env('MS_IMPERSONATE_STOP_BUTTON_ICON', 'hand-raised'),
        ],
    ],

    // query string key name for resource item
    'resource_item_key' => (string)env('MS_IMPERSONATE_RESOURCE_ITEM_KEY', 'resourceItem'),

    // show 'toast' notifications on different actions
    'show_notification' => (bool)env('MS_IMPERSONATE_SHOW_NOTIFICATION', true),
];
