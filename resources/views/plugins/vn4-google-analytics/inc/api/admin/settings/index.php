<?php
return [
    'template'=>'Setting',
    'permission' => 'plugin_google_analytics_setting',
    'data'=>[
        'title'=>'Settings',
        'subTitle'=>'Vn4 Google Analytics',
        'settings'=>[
            [
                'template'=>'SettingBlock1',
                'title'=>'Embed Code',
                'description'=>'When you create your property, Analytics also generates a unique Tracking Code and a site-wide tag containing that Tracking Code for the generated property.',
                'image'=>'/plugins/vn4-google-analytics/img/embed_code.svg',
                'actions'=>[
                    [
                        'label'=>'Setting',
                        'link'=>'/plugin/vn4-google-analytics/settings/embed-code',
                    ],
                ]
                
            ],

            [
                'template'=>'SettingBlock1',
                'title'=>'Analytics',
                'description'=>'We believe that it’s easy to double your traffic and sales when you know exactly how people find and use your website. Vn4 Google Analtyics shows you the stats that matter, so you can grow your business with confidence.',
                'image'=>'/plugins/vn4-google-analytics/img/setting-analytics.svg',
                'actions'=>[
                    [
                        'label'=>'Setting',
                        'link'=>'/plugin/vn4-google-analytics/settings/analytics',
                    ]
                ]
            ],
        ],
    ]
];