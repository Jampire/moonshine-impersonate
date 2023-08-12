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
        'impersonated' => [
            'title' => 'Impersonated Users',
            'fields' => [
                'name' => 'Name',
                'email' => 'E-mail',
                'impersonated_count' => 'Impersonated Count',
                'last_impersonated_by' => 'Last Impersonated By',
                'last_impersonated_at' => 'Last Impersonation Date',
            ],
            'filters' => [
                'impersonated_only' => 'Impersonated Only',
                'all' => 'All Users',
            ],
        ],
        'docs' => [
            'title' => 'Documentation',
        ],
    ],
    'exceptions' => [
        'impersonated_not_loggable' => 'User model :class class does not use :trait trait. Please read MoonShine documentation.',
        'audit_impersonated_failed' => 'Failed to execute audit job. Please, check logs.',
    ],
];
