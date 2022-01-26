<?php

return [
    [
        'key' => 'sms77',
        'name' => 'sms77::app.name',
        'sort' => 1,
    ],
    [
        'key' => 'sms77.general',
        'name' => 'sms77::app.general',
        'sort' => 1,
    ],
    [
        'fields' => [
            [
                'name' => 'api_key',
                'title' => 'sms77::app.api_key',
                'type' => 'password',
                'validation' => 'max:90',
            ],
        ],
        'key' => 'sms77.general.settings',
        'name' => 'sms77::app.general_settings',
        'sort' => 1,
    ],
];