<?php

return [
    // the key to use for session/ajax impersonation
    'key' => env('MS_IMPERSONATE_KEY', 'user-proxy'),

    // what route application will be redirected to after impersonating is started/ended
    'redirect_to' => env('MS_IMPERSONATE_REDIRECT_TO', '/'),

    'routes' => [
        // impersonate routes prefix
        'prefix' => env('MS_IMPERSONATE_ROUTE_PREFIX', 'impersonate'),

        // what middleware is used for routes to enter/stop impersonation
        'middleware' => env('MS_IMPERSONATE_ROUTE_MIDDLEWARE', ['web', 'moonshine']),
    ],
];
