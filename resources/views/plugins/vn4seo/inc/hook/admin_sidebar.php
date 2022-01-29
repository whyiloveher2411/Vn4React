<?php

add_action('admin_sidebar', function($data, $sidebar){
    
    $sidebar = array_slice($sidebar, 0, 4, true) +
    array('vn4-seo' => [
        'title'=>'SEO & Search',
        'show' => false,
        'icon'=>['custom'=>'<image style="width:100%;" href="'.plugin_asset('vn4seo','img/google-webmaster-tools.svg').'" />'],
        'pages'=>[
            [
                'name' =>  'Performance',
                'title' =>  'Performance',
                'icon' =>  'Search',
                'href' =>  '/plugin/vn4seo/performance',
            ],
            [
                'name' =>  'Lighthouse',
                'title' =>  'Lighthouse',
                'icon' =>  'SpeedRounded',
                'href' =>  '/plugin/vn4seo/measure',
            ]
        ]
    ]) +
    array_slice($sidebar, 4, count($sidebar), true);
    
    return $sidebar;
});