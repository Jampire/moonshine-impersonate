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
    // TODO: translate for other languages
    'resources' => [
        'impersonate' => [
            'title' => 'Impersonation',
        ],
//        'users' => [
//            'title' => 'Users',
//            'fields' => [
//                'name' => 'Name',
//                'email' => 'E-mail',
//                'impersonated_count' => 'Impersonated Count',
//                'last_impersonated_by' => 'Last Impersonated By',
//                'last_impersonated_at' => 'Last Impersonation Date',
//            ],
//        ],
        'impersonated' => [
            'title' => 'Impersonated Users',
            'fields' => [
                'name' => 'Name',
                'email' => 'E-mail',
                'impersonated_count' => 'Impersonated Count',
                'last_impersonated_by' => 'Last Impersonated By',
                'last_impersonated_at' => 'Last Impersonation Date',
            ],
        ],
        'docs' => [
            'title' => 'Documentation',
        ],
    ],
];
