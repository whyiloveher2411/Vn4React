<?php
return [
    'template'=>'Setting',
    'permission' => 'plugin_vn4seo_setting',
    'data'=>[
        'title'=>'Settings',
        'subTitle'=>'Vn4-SEO',
        'settings'=>[
            [
                'template'=>'SettingBlock1',
                'title'=>'Verify your website ownership',
                'description'=>'Verification is the process of proving that you own the property that you claim to own. We need to confirm ownership because once you are verified for a property, you have access to its Google Search data, and can affect its presence on Google Search. Every Search Console property requires at least one verified owner.',
                'image'=>'/plugins/vn4seo/img/verify-site.svg',
                'actions'=>[
                    [
                        'label'=>'Verify',
                        'link'=>'/plugin/vn4seo/settings/verify-website',
                    ],
                ]
                
            ],

            [
                'template'=>'SettingBlock1',
                'title'=>'Search Console',
                'description'=>'Manage Search Console properties, test URLs, and view your Google Search data and errors.',
                'image'=>'/plugins/vn4seo/img/search.svg',
                'actions'=>[
                    [
                        'label'=>'Setting',
                        'link'=>'/plugin/vn4seo/settings/search-console',
                    ]
                ]
            ],
            [
                'template'=>'SettingBlock1',
                'title'=>'Sitemap',
                'description'=>'A sitemap is a file where you provide information about the pages, videos, and other files on your site, and the relationships between them. Search engines like Google read this file to crawl your site more efficiently. A sitemap tells Google which pages and files you think are important in your site, and also provides valuable information about these files. For example, when the page was last updated and any alternate language versions of the page.',
                'image'=>'/plugins/vn4seo/img/sitemap.svg',
                'actions'=>[
                    [
                        'label'=>'Setting',
                        'link'=>'/plugin/vn4seo/settings/sitemap',
                    ]
                ]
            ],
        ],
    ]
];