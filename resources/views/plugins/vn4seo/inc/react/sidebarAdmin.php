<?php
$sidebar = array_slice($sidebar, 0, 4, true) +
    array('vn4-seo' => [
        'title'=>'SEO & Search',
        'show' => false,
        'icon'=>['custom'=>'<image style="width:100%;" href="/plugins/vn4seo/img/google-webmaster-tools.svg" />'],
        'pages'=>[
            [
                'name' =>  'Performance',
                'title' =>  'Performance',
                'icon' =>  'Search',
                'href' =>  '/plugin/'.$plugin->key_word.'/performance',
            ],
            [
                'name' =>  'Lighthouse',
                'title' =>  'Lighthouse',
                'icon' =>  'SpeedRounded',
                'href' =>  '/plugin/'.$plugin->key_word.'/measure',
            ],
            [
                'name' =>  'Settings',
                'title' =>  'Settings',
                'icon' =>  'SettingsOutlined',
                'href' =>  '/plugin/'.$plugin->key_word.'/settings',
               
            ],
        ]
    ]) +
    array_slice($sidebar, 4, count($sidebar), true);