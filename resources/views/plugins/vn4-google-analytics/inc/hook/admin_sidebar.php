<?php

add_action('admin_sidebar', function($data, $sidebar){
    
    $sidebar = array_slice($sidebar, 0, 4, true) +
    array('vn4-google-analtyics' => [
        'title'=>'Google Analytics',
        'icon'=>['custom'=>'<image style="width:100%;" href="/plugins/vn4-google-analytics/img/ic_analytics.svg" />'],
        'show' => false,
        'description'=>'Tools you need to better understand your customers',
        'pages'=>[
            [
                'name' =>  'Realtime',
                'title' =>  'Realtime',
                'icon' =>  'EqualizerRounded',
                'href' =>  '/plugin/vn4-google-analytics/realtime',
            ],
            [
                'name' =>  'Reports',
                'title' =>  'Reports',
                'icon' =>  'TimelineRounded',
                'href' =>  '/plugin/vn4-google-analytics/reports',
            ],
        ]
    ]) +
    array_slice($sidebar, 4, count($sidebar), true);
    
    return $sidebar;
});