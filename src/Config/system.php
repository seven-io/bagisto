<?php

return [
    [
        'key' => 'seven',
        'name' => 'seven::app.name',
        'sort' => 1,
    ],
    [
        'key' => 'seven.general',
        'name' => 'seven::app.general',
        'sort' => 1,
    ],
    [
        'fields' => [
            [
                'name' => 'api_key',
                'title' => 'seven::app.api_key',
                'type' => 'password',
                'validation' => 'max:90',
            ],
        ],
        'key' => 'seven.general.settings',
        'name' => 'seven::app.general_settings',
        'sort' => 1,
    ],
];
