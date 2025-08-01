<?php

return [
    [
        'info' => 'seven::app.settings_info',
        'key' => 'seven',
        'name' => 'seven::app.name',
        'sort' => 1,
    ],
    [
        'info' => 'seven::app.general_info',
        'key' => 'seven.general',
        'name' => 'seven::app.general',
        'sort' => 1,
    ],
    [
        'fields' => [
            [
                'channel_based' => false,
                'locale_based'  => false,
                'info' => 'seven::app.api_key_info',
                'name' => 'api_key',
                'title' => 'seven::app.name',
                'type' => 'password',
                'validation' => 'max:90',
            ],
        ],
        'info' => 'seven::app.name',
        'key' => 'seven.general.settings',
        'name' => 'seven::app.general_settings',
        'sort' => 1,
    ],
];
