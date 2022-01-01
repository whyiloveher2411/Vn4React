<?php

return [
    [
        'fields'=>[
            'general_status'=>[
                'title'=>__('Status'),
                'view'=>'select',
                'list_option'=>[
                    'developing' => ['title'=>__('Developing')],
                    'production' => ['title'=>__('Production')],
                ],
                'note'=>__('Some functions will be activated when the website is ready, the view will automatically minify, so please check javascript, css, html before turning on.')
            ],
            'general_site_title'=>[
                'title'=>__('Site Title'),
                'view'=>'text',
            ],
            'general_description'=>[
                'title'=>__('Description'),
                'view'=>'text',
                'note'=>'In a few words, explain what this site is about'
            ],
            'general_email_address'=>[
                'title'=>__('Email Address'),
                'view'=>'text',
                'note'=>'This address is used for admin purposes, like new user notification'
            ],
            'general_timezone'=>[
                'title'=>__('Timezone'),
                'view'=>'custom',
                'component'=>'components/Timezone'
            ],
            'general_date_format'=>[
                'title'=>__('Date Format'),
                'view'=>'custom',
                'component'=>'components/DateTimeFormat',
                'labelCustom'=>date( setting('general_date_format', 'm/d/Y') ),
                'defaultValue'=>'m/d/Y',
                'list_option'=>[
                    'F j, Y'=>date('F j, Y'),
                    'Y-m-d'=>date('Y-m-d'),
                    'm/d/Y'=>date('m/d/Y'),
                    'd/m/Y'=>date('d/m/Y'),
                ],
            ],
            'general_time_format'=>[
                'title'=>__('Time Format'),
                'view'=>'custom',
                'component'=>'components/DateTimeFormat',
                'labelCustom'=>date( setting('general_time_format', 'g:i a') ),
                'defaultValue'=>'g:i a',
                'list_option'=>[
                    'g:i a'=>date('g:i a'),
                    'g:i A'=>date('g:i A'),
                    'H:i'=>date('H:i'),
                ]
            ],
        ]
    ]
];