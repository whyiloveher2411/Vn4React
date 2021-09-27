<?php


include __DIR__.'/_function.php';

$r = request();

$input = $r->all();

if( $input['action'] === 'get' ){
    $folder = scandir(app()->resourcePath('views/themes/'));
    $list_theme = [];
    foreach ($folder as $theme) {
        if( $theme !== '.' && $theme !== '..' && file_exists(app()->resourcePath('views/themes/'.$theme.'/info.json')) ){
            copyemz( app()->resourcePath('views/themes/'.$theme.'/public/screenshot.png'), public_path('themes/'.$theme.'.png'));
            $content = json_decode( file_get_contents(app()->resourcePath('views/themes/'.$theme.'/info.json')) , true );
            $list_theme[$theme] = $content;
        }
    }


    return ['rows'=>$list_theme];
}elseif( $input['action'] === 'next'){

    if( $input['name'] ){
        recurse_copy( app()->resourcePath('views/themes/'.$input['name'].'/public/'), public_path('themes/'.$input['name'].'/') );
    }

    $folder = scandir(app()->resourcePath('views/plugins/'));

    $list_theme = [];
    foreach ($folder as $plugin) {
        if( $plugin !== '.' && $plugin !== '..' && file_exists(app()->resourcePath('views/plugins/'.$plugin.'/public')) ){

            if (!file_exists( public_path('plugins/'.$plugin) )) {
                mkdir( public_path('plugins/'.$plugin) , 0777, true);
            }
            recurse_copy( app()->resourcePath('views/plugins/'.$plugin.'/public'), public_path('plugins/'.$plugin.'/') );
        }
    }

    if( $input['importData'] ){
        include __DIR__.'/theme-import-data.php';
    }else{
        include __DIR__.'/theme-empty.php';
    }

    return ['success'=>true];
}

