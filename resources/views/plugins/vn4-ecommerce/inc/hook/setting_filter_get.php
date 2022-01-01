<?php

add_action('setting_filter_get',function( $data, $group, $subGroup, $dataAfterAction ){

    include __DIR__.'/../__helper.php';

    $dataAfterAction['tabs']['e-commerce'] = [
        'title'=>'e-commerce',
        'icon'=>['custom'=>'<image style="width:100%;" href="/plugins/vn4-ecommerce/img/shopping-cart.svg" />'],
        'subTab'=>[
            'payments'=>[
                'title'=>'Payments',
                'description'=>'Enable and manage your store\'s payment providers',
                'icon'=>['custom'=>'<image style="width:100%;" href="/plugins/vn4-ecommerce/img/online-payment.svg" />']
            ],
            'currency'=>[
                'title'=>'Currency',
                'description'=>'List of Currency code by Countries, International Currencies, currency names and ... Below you will find a list of money in use for each country around the',
                'icon'=>['custom'=>'<image style="width:100%;" href="/plugins/vn4-ecommerce/img/exchange.svg" />']
            ],
            'checkout'=>[
                'title'=>'Checkout',
                'description'=>'Customize your online checkout process',
                'icon'=>['custom'=>'<image style="width:100%;" href="/plugins/vn4-ecommerce/img/online-purchase.svg" />']
            ],
            'shipping-and-delivery'=>[
                'title'=>'Shipping and delivery',
                'description'=>'Manage how you ship orders to customers',
                'icon'=>['custom'=>'<image style="width:100%;" href="/plugins/vn4-ecommerce/img/delivery-truck.svg" />']
            ],
            'locations'=>[
                'title'=>'Locations',
                'description'=>'Manage the places you stock inventory, fulfill orders, and sell products',
                'icon'=>['custom'=>'<image style="width:100%;" href="/plugins/vn4-ecommerce/img/map.svg" />']
            ],
            'legal'=>[
                'title'=>'Legal',
                'description'=>'Manage your store\'s legal pages',
                'icon'=>['custom'=>'<image style="width:100%;" href="/plugins/vn4-ecommerce/img/justice.svg" />']
            ],
            'notifications'=>[
                'title'=>'Notifications',
                'description'=>'Manage notifications sent to you and your customers',
                'icon'=>['custom'=>'<image style="width:100%;" href="/plugins/vn4-ecommerce/img/notification.svg" />']
            ],
            'taxes'=>[
                'title'=>'Taxes',
                'description'=>'As a merchant, you might need to charge taxes on your sales, and then report and remit those taxes to your government.',
                'icon'=>['custom'=>'<image style="width:100%;" href="/plugins/vn4-ecommerce/img/taxes.svg" />']
            ],
            'units'=>[
                'title'=>'Units',
                'description'=>'Unit of Measure Class. Units of Measure. Base Unit of Measure. Quantity. dozen. box. each. each. Weight. pound. kilogram. gram. gram. Time. hour. minute',
                'icon'=>['custom'=>'<image style="width:100%;" href="/plugins/vn4-ecommerce/img/speedometer.svg" />']
            ]
        ]
    ];

    if( $group === 'e-commerce' ){

        switch ($subGroup ) {
            case 'payments':
                $dataAfterAction['config'] = [
                    [
                        'fields'=>[
                            'unit_of_weight'=>[
                                'title'=>'Unit Of Weight',
                                'customViewForm'=>'Settings/Field/UnitOfWeight'
                            ]
                        ]
                    ]
                ];
                break;
            case 'currency':
                $dataAfterAction['config'] = [
                    [
                        'template'=>'BLANK',
                        'fields'=>[
                            'currency/currencyconverter/api_key'=>[
                                'title'=>'Currency converter Api Key',
                                'hidden'=>true,
                            ],
                            'currency/exchangerate/api_key'=>[
                                'title'=>'Exchange Rate Api Key',
                                'hidden'=>true,
                            ],
                            'currency/options/allow'=>[
                                'title'=>'Allowed Currencies',
                                'customViewForm'=>'Settings/Currency',
                                'currenciesList'=> getCurrenciesList(),
                                'is_json'=>true,
                                'saveCallback'=>function($value){
                                    
                                    if( gettype( $value ) === 'string' ){
                                        $value = json_decode( $value,true ) ?? [];
                                    }

                                    $currencies = validateCurrenciesInput( $value );

                                    return $currencies;
                                }
                            ],
                        ]
                    ]
                ];
                break;
            case 'units':
                $dataAfterAction['config'] = [
                    [
                        'fields'=>[
                            'ecom/units/weight'=>[
                                'title'=>'Unit Of Mass',
                                'view'=>'select',
                                'disableClearable'=>true,
                                'list_option'=>[
                                    'mg'=>['title'=>'Milligram (mg)'],
                                    'g'=>['title'=>'Gram (g)'],
                                    'oz'=>['title'=>'Ounce (oz)'],
                                    'kg'=>['title'=>'Kilogram (kg)'],
                                    'lb'=>['title'=>'Pound (lb)'],
                                    'ton'=>['title'=>'Tonne (ton)'],
                                ]
                            ],
                            'ecom/units/length'=>[
                                'title'=>'Unit Of Length',
                                'view'=>'select',
                                'disableClearable'=>true,
                                'list_option'=>[
                                    'mm'=>['title'=>'Millimeter (mm)'],
                                    'cm'=>['title'=>'Centimeter (cm)'],
                                    'in'=>['title'=>'Inch (in)'],
                                    'ft'=>['title'=>'Foot (ft)'],
                                ]
                            ]
                        ]
                    ]
                ];
                break;
            default:
                # code...
                break;
        }
    }

    return $dataAfterAction;
}, 1);