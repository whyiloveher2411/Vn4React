<?php

include __DIR__.'/../tool/_helper.php';

$groupSelected = $r->get('group');


$plugins = plugins();

$firstOption = 'core';

$groups = [];

$groups[$firstOption] = [
    'title'=>'Core',
    'group'=>'Core',
    'path'=>'src/utils/i18n/trans.xlsx'
];

$themeInfo = json_decode(File::get(Config::get('view.paths')[0].'/themes/'.theme_name().'/info.json'), true);

// $groups['theme'] = [
//     'title'=>$themeInfo['name'],
//     'group'=>'Theme',
//     'path'=>'src/utils/i18n/trans.xlsx'
// ];

function dashesToCamelCase($string, $capitalizeFirstCharacter = false) 
{

    $str = str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));

    if (!$capitalizeFirstCharacter) {
        $str[0] = strtolower($str[0]);
    }

    return $str;
}

foreach( $plugins as $key => $plugin){
    $groups[$key] = [
        'title'=>$plugin->title,
        'group'=>'Plugin',
        'path'=>'src/plugins/'.dashesToCamelCase($key, true).'/i18n/trans.xlsx'
    ];
}

if( !$groupSelected || !isset($groups[$groupSelected]) ){
    return [
        'error'=>0,
        'group'=>[
            'options'=>$groups,
            'selected'=> $firstOption
        ]
    ];
}

$data = getDataOld($groups[$groupSelected]['path']);

return [
    'error'=>0,
    'trans'=>$data,
    'group'=>[
        'options'=>$groups,
        'selected'=> isset($groups[$groupSelected]) ? $groupSelected : $firstOption
    ]
];
