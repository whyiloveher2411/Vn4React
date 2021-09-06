<?php

// $sidebar['add-on']['pages'][] = [
//     'name' =>  'Analytics',
//     'title' =>  'Analytics',
//     'icon' =>  'BarChart',
//     'href' =>  '/plugin/'.$plugin->key_word,
//     'children'=>[
//         [
//             'name'=>'Settings',
//             'title'=>'Settings',
//             'href'=>'/plugin/'.$plugin->key_word.'/settings',
//         ],
//         [
//             'name'=>'Realtime',
//             'title'=>'Realtime',
//             'href'=>'/plugin/'.$plugin->key_word.'/realtime',
//         ],
//         [
//             'name'=>'Reports',
//             'title'=>'Reports',
//             'href'=>'/plugin/'.$plugin->key_word.'/reports',
//         ],
//     ]
// ];




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
                'href' =>  '/plugin/'.$plugin->key_word.'/realtime',
            ],
            [
                'name' =>  'Reports',
                'title' =>  'Reports',
                'icon' =>  'TimelineRounded',
                'href' =>  '/plugin/'.$plugin->key_word.'/reports',
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