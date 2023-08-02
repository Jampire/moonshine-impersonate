<?php

return [
    'buttons' => [
        'enter' => [
            'label' => 'Impersonate',
            'message' => 'User has been impersonated.',
        ],
        'stop' => [
            'label' => 'Stop Impersonation',
            'message' => 'The impersonation has been successfully stopped!',
        ],
    ],
    'resource' => [
        'impersonate' => [
            'title' => 'Impersonation',
        ],
        'users' => [
            'title' => 'Users',
            'fields' => [
                'name' => 'Name',
                'email' => 'E-mail',
                'impersonated_count' => 'Impersonated Count',
                'last_impersonated_by' => 'Last Impersonated By',
                'last_impersonated_at' => 'Last Impersonation Date',
            ],
        ],
    ],
];
