<?php
include __DIR__.'/../tool/_helper.php';

$data = $r->get('data');

if( $data && !empty($data) ){
    $groupSelected = $r->get('group');

    $plugins = plugins();

    $firstOption = 'core';
    $groups = [];
    $groups[$firstOption] = [
        'title'=>'Core',
        'group'=>'Core',
        'path'=>'src/utils/i18n/trans.xlsx',
        'type'=>null,
        'dir'=>'src',
    ];

    $themeInfo = json_decode(File::get(Config::get('view.paths')[0].'/themes/'.theme_name().'/info.json'), true);

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
            'path'=>'src/plugins/'.dashesToCamelCase($key, true).'/i18n/trans.xlsx',
            'type'=>'plugin',
            'dir'=>'src/plugins/'.dashesToCamelCase($key, true),
        ];
    }
    
    $translates = [];

    foreach( $data as $transText => $languagesData){

        foreach( $languagesData as $langCode => $value){

            if( !isset($translates[$langCode]) ){
                $translates[$langCode] = [];
            } 

            $translates[$langCode][$transText] = $value;
        }
    }

    $languages = $r->get('languages');

    saveDataTrans($groups[$groupSelected]['dir'],$groups[$groupSelected]['path'],$groups[$groupSelected]['type'],$translates, $languages);

    $data = getDataOld($groups[$groupSelected]['path']);

    return [
        'trans'=>$data,
        'error'=>0,
        'message'=>apiMessage('Save changes successfully')
    ];

}

return [
    'error'=>1,
    'message'=>apiMessage('Couldn\'t find any data to change','error'),
];