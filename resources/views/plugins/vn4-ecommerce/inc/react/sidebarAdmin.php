<?php

$sidebar['dashboard']['pages'][] = [
    'name'=>'E-Reporting',
    'title'=>'E-Reporting',
    'icon'=>'TrendingUpRounded',
//    'svgIcon'=>'<svg viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M2 10C2 7.87827 2.84285 5.84344 4.34315 4.34315C5.84344 2.84285 7.87827 2 10 2V10H18C18 12.1217 17.1571 14.1566 15.6569 15.6569C14.1566 17.1571 12.1217 18 10 18C7.87827 18 5.84344 17.1571 4.34315 15.6569C2.84285 14.1566 2 12.1217 2 10Z"></path><path opacity="0.5" d="M12 2.25195C13.3836 2.61042 14.6462 3.3324 15.6569 4.34307C16.6676 5.35375 17.3895 6.61633 17.748 7.99995H12V2.25195Z"></path></svg>'
];


$sidebar = array_slice($sidebar, 0, 3, true) +
    array('e-commerce' => [
        'title'=>'E-commerce',
        'icon'=>['custom'=>'<image style="width:100%;" href="/plugins/vn4-ecommerce/img/shopping-cart.svg" />'],
        'show' => false,
        'description'=>'Manage store, catalog, order data',
        'pages'=>[
            // [
            //     'name' =>  'E-Reporting',
            //     'title' =>  'E-Reporting',
            //     'icon' =>  'TrendingUpRounded',
            //     'href' =>  '/sdfsdf/sdf/sdf',
            // ],
            [
                'name' =>  'Sales',
                'title' =>  'Sales',
                'icon' =>  'AttachMoneyRounded',
                'children'=>[
                    [
                        'name'=>'Orders',
                        'title'=>'Orders',
                        'href' =>  '/post-type/ecom_order/list',
                    ],
                    [
                        'name'=>'Invoices',
                        'title'=>'Invoices',
                        'href' =>  '/post-type/ecom_invoices/list',
                    ],
                    [
                        'name'=>'Shipments',
                        'title'=>'Shipments',
                        'href' =>  '/post-type/ecom_shipments/list',
                    ],
                    [
                        'name'=>'Transactions',
                        'title'=>'Transactions',
                        'href' =>  '/post-type/ecom_transactions/list',
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
                        'href' =>  '/post-type/ecom_prod/list',
                    ],
                    [
                        'name'=>'Categories',
                        'title'=>'Categories',
                        'href' =>  '/post-type/ecom_prod_cate/list',
                    ],
                    [
                        'name'=>'Tags',
                        'title'=>'Tags',
                        'href' =>  '/post-type/ecom_prod_tag/list',
                    ],
                    [
                        'name'=>'Attributes',
                        'title'=>'Attributes',
                        'href' =>  '/post-type/ecom_prod_attr/list',
                    ],
                    [
                        'name'=>'Filters',
                        'title'=>'Filters',
                        'href' =>  '/post-type/ecom_prod_filter/list',
                    ],
                    [
                        'name'=>'Specifications Sets',
                        'title'=>'Specifications Sets',
                        'href' =>  '/post-type/ecom_prod_spec_sets/list',
                    ],
                    
                ]
            ],
            [
                'name' =>  'Customers',
                'title' =>  'Customers',
                'icon' =>  'PeopleOutlineRounded',
                'href' =>  '/post-type/ecom_customer/list',
            ],
            [
                'name' =>  'Reviews',
                'title' =>  'Reviews',
                'icon' =>  'StarBorderRounded',
                'href' =>  '/post-type/ecom_prod_review/list',
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
                'href' =>  '/plugin/vn4-ecommerce/settings',
            ],

        ]

    ]) +
    array_slice($sidebar, 3, count($sidebar), true);
