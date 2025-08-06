<?php

return [
    [
        'info' => 'seven::app.settings_info',
        'key' => 'seven',
        'name' => 'seven::app.name',
        'sort' => 1,
    ],
    [
        'info' => 'seven::app.settings_info',
        'key' => 'seven.settings',
        'name' => 'seven::app.settings',
        'sort' => 1,
    ],
    [
        'fields' => [
            [
                'info' => 'seven::app.api_key_info',
                'name' => 'api_key',
                'title' => 'seven::app.api_key',
                'type' => 'password',
                'validation' => 'max:90',
            ],
        ],
        'info' => 'seven::app.general_info',
        'key' => 'seven.settings.general',
        'name' => 'seven::app.general',
        'sort' => 1,
    ],
    [
        'fields' => [
            [
                'locale_based'  => true,
                'info' => 'seven::app.sms_from_info',
                'name' => 'from',
                'title' => 'seven::app.sms_from',
                'type' => 'text',
                'validation' => 'max:16',
            ],
        ],
        'info' => 'seven::app.settings_sms_info',
        'key' => 'seven.settings.sms',
        'name' => 'seven::app.settings_sms',
        'sort' => 1,
    ],
    [
        'fields' => [
            [
                'locale_based'  => true,
                'info' => 'seven::app.after_registration_text_info',
                'name' => 'after_registration_text',
                'title' => 'seven::app.after_registration_text',
                'type' => 'text',
            ],
            [
                'locale_based'  => true,
                'info' => 'seven::app.after_password_update_text_info',
                'name' => 'after_password_update_text',
                'title' => 'seven::app.after_password_update_text',
                'type' => 'text',
            ],
            [
                'locale_based'  => true,
                'info' => 'seven::app.after_save_order_text_info',
                'name' => 'after_save_order_text',
                'title' => 'seven::app.after_save_order_text',
                'type' => 'text',
            ],
            [
                'locale_based'  => true,
                'info' => 'seven::app.after_save_shipment_text_info',
                'name' => 'after_save_shipment_text',
                'title' => 'seven::app.after_save_shipment_text',
                'type' => 'text',
            ],
        ],
        'info' => 'seven::app.events_info',
        'key' => 'seven.settings.events',
        'name' => 'seven::app.events',
        'sort' => 1,
    ],
];
