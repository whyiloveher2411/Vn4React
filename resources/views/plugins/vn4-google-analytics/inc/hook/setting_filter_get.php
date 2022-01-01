<?php

add_action('setting_filter_get',function( $data, $group, $subGroup, $dataAfterAction ){

    $dataAfterAction['tabs']['google-analytics'] = [
        'title'=>'Google Analytics',
        'icon'=>['custom'=>'<image style="width:100%;" href="/plugins/vn4-google-analytics/img/ic_analytics.svg" />'],
        'subTab'=>[
            'embed-code'=>[
                'title'=>'Embed Code',
                'description'=>'When you create your property, Analytics also generates a unique Tracking Code and a site-wide tag containing that Tracking Code for the generated property.',
            ],
            'analytics'=>[
                'title'=>'Analytics',
                'description'=>'We believe that it’s easy to double your traffic and sales when you know exactly how people find and use your website. Vn4 Google Analtyics shows you the stats that matter, so you can grow your business with confidence.',
            ],
        ]
    ];

    if( $group === 'google-analytics' ){

        switch ($subGroup ) {
            case 'embed-code':
                $dataAfterAction['config'] = [
                    [
                        'fields'=>[
                            'google_analytics/embed_code'=>[
                                'title'=>'Embed code',
                                'view'=>'textarea',
                                'saveCallback'=>function($code){

                                    if( !$code ) $code = '';

                                    use_module('read_html');

                                    $html = str_get_html($code);

                                    $script = $html->find('script',0);

                                    if( $script ){
                                        $parts = parse_url($script->src);
                                        parse_str($parts['query'], $query);
                                        if( isset($query['id']) ){
                                            $code = $query['id'];
                                        }
                                    }

                                    return $code;
                                }
                            ]
                        ]
                    ]
                ];
                break;
            case 'analytics':
                $dataAfterAction['config'] = [
                    [
                        'template'=>'BLANK',
                        'fields'=>[
                            'google_analytics/analytics_api/active'=>[
                                'title'=>'Active Google Analytics Api',
                                'view'=>'true_false',
                            ],
                            'google_analytics/analytics_api'=>[
                                'title'=>'Analytics API',
                                'customViewForm'=>'Settings/GoogleAnalytics/AnalyticsApi',
                                'is_json'=>true,
                            ]
                        ]
                    ]
                ];
                break;
        }
    }

    return $dataAfterAction;
},99);