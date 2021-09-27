<?php

return [
    'template'=>'Setting',
    'permission' => 'settings_management',
    'data'=>[
        'title'=>'Settings',
        'subTitle'=>'Vn4 Ecommerce',
        'settings'=>[
            [
                'template'=>'SettingBlock2',
                'items'=>[
                    [
                        'title'=>'General',
                        'description'=>'View and update your store details',
                        'image'=>'/admin/images/settings.svg',
                        'actions'=>[
                            [
                                'label'=>'Setting',
                                'link'=>'/plugin/vn4-ecommerce/settings/general',
                            ],
                        ]
                    ],
                    [
                        'title'=>'Reading settings',
                        'description'=>'Manage how your store charges taxes',
                        'image'=>'/admin/images/settings-reading.svg',
                        'actions'=>[
                            [
                                'label'=>'Setting',
                                'link'=>'/plugin/vn4-ecommerce/settings/taxes',
                            ],
                        ]
                    ],
                ]
            ],
            [
                'template'=>'SettingBlock1',
                'title'=>'Two-Factor Authentication',
                'description'=>'Multi-factor authentication is an electronic authentication method in which a user is granted access to a website or application only after successfully presenting two or more pieces of evidence to an authentication mechanism: knowledge, possession, and inherence.',
                'image'=>'/admin/images/2-step-authentication.svg',
                'actions'=>[
                    [
                        'label'=>'Setting',
                        'link'=>'/plugin/vn4-ecommerce/settings/general',
                    ],
                ]
            ],
            [
                'template'=>'SettingBlock2',
                'items'=>[
                    [
                        'title'=>'Timezone',
                        'description'=>'View and update your store details',
                        'image'=>'/admin/images/timezone.svg',
                        'actions'=>[
                            [
                                'label'=>'Setting',
                                'link'=>'/plugin/vn4-ecommerce/settings/general',
                            ],
                        ]
                    ],
                    [
                        'title'=>'Security',
                        'description'=>'Manage how your store charges taxes',
                        'image'=>'/admin/images/security.svg',
                        'actions'=>[
                            [
                                'label'=>'Setting',
                                'link'=>'/plugin/vn4-ecommerce/settings/taxes',
                            ],
                        ]
                    ],
                ]
            ],
            
        ],
    ]
];