<?php



$sidebar = array_slice($sidebar, 0, 1, true) +
    array('e-commerce' => [
        'title'=>'E-commerce',
        'show' => false,
        'description'=>'Manage store, catalog, order data',
        'pages'=>[
            [
                'name' =>  'E-Reporting',
                'title' =>  'E-Reporting',
                'icon' =>  'TrendingUpRounded',
                'href' =>  '/sdfsdf/sdf/sdf',
            ],
            [
                'name' =>  'Sales',
                'title' =>  'Sales',
                'icon' =>  'AttachMoneyRounded',
                'href' =>  '#',
                'children'=>[
                    [
                        'name'=>'Orders',
                        'title'=>'Orders',
                        'href' =>  '#',
                    ],
                    [
                        'name'=>'Invoices',
                        'title'=>'Invoices',
                        'href' =>  '#',
                    ],
                    [
                        'name'=>'Shipments',
                        'title'=>'Shipments',
                        'href' =>  '#',
                    ],
                    [
                        'name'=>'Transactions',
                        'title'=>'Transactions',
                        'href' =>  '#',
                    ],
                ]
            ],
            [
                'name' =>  'Catalog',
                'title' =>  'Catalog',
                'icon' =>  'ShoppingCartOutlined',
                'href' =>  '#',
                'children'=>[
                    [
                        'name'=>'Products',
                        'title'=>'Products',
                        'href' =>  '#',
                    ],
                    [
                        'name'=>'Categories',
                        'title'=>'Categories',
                        'href' =>  '#',
                    ],
                ]
            ],
            [
                'name' =>  'Customers',
                'title' =>  'Customers',
                'icon' =>  'PeopleOutlineRounded',
                'href' =>  '#',
            ],
            [
                'name' =>  'Reviews',
                'title' =>  'Reviews',
                'icon' =>  'StarBorderRounded',
                'href' =>  '#',
            ],
            [
                'name' =>  'Marketing',
                'title' =>  'Marketing',
                'icon' =>  'NotificationsActiveOutlined',
                'href' =>  '#',
                'children'=>[
                    [
                        'name'=>'Orders',
                        'title'=>'Orders',
                        'href' =>  '#',
                    ],
                ]
            ],
            [
                'name' =>  'Stores',
                'title' =>  'Stores',
                'icon' =>  'StoreMallDirectoryOutlined',
                'href' =>  '#',
                'children'=>[
                    [
                        'name'=>'Orders',
                        'title'=>'Orders',
                        'href' =>  '#',
                    ],
                ]
            ],
            [
                'name' =>  'System',
                'title' =>  'System',
                'icon' =>  'SettingsOutlined',
                'href' =>  '#',
                'children'=>[
                    [
                        'name'=>'Orders',
                        'title'=>'Orders',
                        'href' =>  '#',
                    ],
                ]
            ],

        ]

    ]) +
    array_slice($sidebar, 1, count($sidebar), true);