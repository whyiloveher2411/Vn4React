<?php

add_action('setting_filter_get',function( $data, $group, $subGroup, $dataAfterAction ){

    $dataAfterAction['tabs']['seo'] = [
        'title'=>'SEO',
        'icon'=>['custom'=>'<image style="width:100%;" href="/plugins/vn4seo/img/google-webmaster-tools.svg" />'],
        'subTab'=>[
            'verify-ownership'=>[
                'title'=>'Verify Ownership',
                'description'=>'Verification is the process of proving that you own the property that you claim to own. We need to confirm ownership because once you are verified for a property, you have access to its Google Search data, and can affect its presence on Google Search. Every Search Console property requires at least one verified owner.',
            ],
            'search-console'=>[
                'title'=>'Search Console',
                'description'=>'Manage Search Console properties, test URLs, and view your Google Search data and errors.',
            ],
            'sitemap'=>[
                'title'=>'Sitemap',
                'description'=>'A sitemap is a file where you provide information about the pages, videos, and other files on your site, and the relationships between them. Search engines like Google read this file to crawl your site more efficiently. A sitemap tells Google which pages and files you think are important in your site, and also provides valuable information about these files. For example, when the page was last updated and any alternate language versions of the page.',
            ],
        ]
    ];

    if( $group === 'seo' ){
        switch ($subGroup ) {
            case 'verify-ownership':
                $dataAfterAction['config'] = [
                    [
                        'template'=>'BLANK',
                        'fields'=>[
                            'seo/verify_ownership/htmlfile'=>[
                                'title'=>'Verify Ownership by HTML file',
                                'hidden'=>true,
                                'saveCallback'=>function($value){
                                    if( $value ){
                                        if( !is_array($value) ){
                                            $file = json_decode($value,true);
                                        }else{
                                            $file = $value;
                                        }
                                    
                                        if( isset($file['link']) ){
                                            $file_info = pathinfo(cms_path('public',$file['link']));
                                            copy(cms_path('public',$file['link']), cms_path('public',$file_info['basename']));
                                            $webmaster_tools['google']['file'] = $value;
                                        }

                                    }
                                    return $value;
                                }
                            ],
                            'seo/verify_ownership/metatag'=>[
                                'title'=>'Verify Ownership by meta tag',
                                'customViewForm'=>'Settings/Seo/VerifyOwnership/GoogleVerify',
                            ]
                        ]
                    ]
                ];
                break;
            case 'search-console':
                $dataAfterAction['config'] = [
                    [
                        'template'=>'BLANK',
                        'fields'=>[
                            'seo/analytics/google_search_console/active'=>[
                                'title'=>'Active Google Console Api',
                                'view'=>'true_false',
                            ],
                            'seo/analytics/google_search_console'=>[
                                'title'=>'Search console',
                                'customViewForm'=>'Settings/Seo/Analytics/GoogleSearchConsole',
                                'is_json'=>true,
                            ]
                        ]
                    ]
                ];
                break;
            case 'sitemap':
                $dataAfterAction['config'] = [
                    [
                        'template'=>'BLANK',
                        'fields'=>[
                            'seo/sitemap/active'=>[
                                'title'=>'Active Sitemap',
                                'view'=>'true_false',
                            ],
                            'seo/sitemap/post_type'=>[
                                'title'=>'Post Type',
                                'listPostType' => get_admin_object(),
                                'customViewForm'=>'Settings/Seo/Sitemap/PostType',
                            ]
                        ]
                    ]
                ];
                break;

        }
        
    }

    return $dataAfterAction;
},99);