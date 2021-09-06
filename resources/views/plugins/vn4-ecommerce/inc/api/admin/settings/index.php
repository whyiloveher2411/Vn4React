<?php

return [
    'template'=>'Setting',
    'permission' => 'plugin_google_analytics_setting',
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
                        'image'=>'/plugins/vn4-ecommerce/img/settings.svg',
                        'actions'=>[
                            [
                                'label'=>'Setting',
                                'link'=>'/plugin/vn4-ecommerce/settings/general',
                            ],
                        ]
                    ],
                    [
                        'title'=>'Payments',
                        'description'=>'Enable and manage your store\'s payment providers',
                        'image'=>'/plugins/vn4-ecommerce/img/online-payment.svg',
                        'actions'=>[
                            [
                                'label'=>'Setting',
                                'link'=>'/plugin/vn4-ecommerce/settings/payments',
                            ],
                        ]
                    ],
                    [
                        'title'=>'Currencies',
                        'description'=>'List of Currency code by Countries, International Currencies, currency names and ... Below you will find a list of money in use for each country around the',
                        'image'=>'/plugins/vn4-ecommerce/img/exchange.svg',
                        'actions'=>[
                            [
                                'label'=>'Settings',
                                'link'=>'/plugin/vn4-ecommerce/settings/currencies',
                            ],
                            // [
                            //     'label'=>'Currency Rates',
                            //     'link'=>'/plugin/vn4-ecommerce/settings/currencies-rate',
                                // 'event'=>true,
                                // 'params'=>[
                                //     'url'=>'plugin/vn4-ecommerce/currencies/update-rate-api',
                                //     'method'=>'POST',
                                //     'data'=>[
                                //         'action'=>'update-rate-api'
                                //     ]
                                // ]
                            // ],
                        ]
                    ],
                    [
                        'title'=>'Checkout',
                        'description'=>'Customize your online checkout process',
                        'image'=>'/plugins/vn4-ecommerce/img/online-purchase.svg',
                        'actions'=>[
                            [
                                'label'=>'Setting',
                                'link'=>'/plugin/vn4-ecommerce/settings/checkout',
                            ],
                        ]
                    ],
                    [
                        'title'=>'Shipping and delivery',
                        'description'=>'Manage how you ship orders to customers',
                        'image'=>'/plugins/vn4-ecommerce/img/delivery-truck.svg',
                        'actions'=>[
                            [
                                'label'=>'Setting',
                                'link'=>'/plugin/vn4-ecommerce/settings/shipping',
                            ],
                        ]
                    ],
                    [
                        'title'=>'Locations',
                        'description'=>'Manage the places you stock inventory, fulfill orders, and sell products',
                        'image'=>'/plugins/vn4-ecommerce/img/map.svg',
                        'actions'=>[
                            [
                                'label'=>'Setting',
                                'link'=>'/plugin/vn4-ecommerce/settings/locations',
                            ],
                        ]
                    ],
                    [
                        'title'=>'Legal',
                        'description'=>'Manage your store\'s legal pages',
                        'image'=>'/plugins/vn4-ecommerce/img/justice.svg',
                        'actions'=>[
                            [
                                'label'=>'Setting',
                                'link'=>'/plugin/vn4-ecommerce/settings/legal',
                            ],
                        ]
                    ],
                    [
                        'title'=>'Notifications',
                        'description'=>'Manage notifications sent to you and your customers',
                        'image'=>'/plugins/vn4-ecommerce/img/notification.svg',
                        'actions'=>[
                            [
                                'label'=>'Setting',
                                'link'=>'/plugin/vn4-ecommerce/settings/notifications',
                            ],
                        ]
                    ],
                    [
                        'title'=>'Taxes',
                        'description'=>'As a merchant, you might need to charge taxes on your sales, and then report and remit those taxes to your government.',
                        'image'=>'/plugins/vn4-ecommerce/img/taxes.svg',
                        'actions'=>[
                            [
                                'label'=>'Setting',
                                'link'=>'/plugin/vn4-ecommerce/settings/taxes',
                            ],
                        ]
                    ],
                    [
                        'title'=>'Units',
                        'description'=>'Unit of Measure Class. Units of Measure. Base Unit of Measure. Quantity. dozen. box. each. each. Weight. pound. kilogram. gram. gram. Time. hour. minute',
                        'image'=>'/plugins/vn4-ecommerce/img/speedometer.svg',
                        'actions'=>[
                            [
                                'label'=>'Setting',
                                'link'=>'/plugin/vn4-ecommerce/settings/units',
                            ],
                        ]
                    ],
                ]
            ],
        ],
    ]
];