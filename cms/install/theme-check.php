<?php
$input = $r->all();

if( $input['action'] === 'get' ){
    $folder = scandir(app()->resourcePath('views/themes/'));
    $list_theme = [];
    foreach ($folder as $theme) {
        if( $theme !== '.' && $theme !== '..' && file_exists(app()->resourcePath('views/themes/'.$theme.'/info.json')) ){
            // copyemz( app()->resourcePath('views/themes/'.$theme.'/public/screenshot.png'), public_path('themes/'.$theme.'.png'));
            $content = json_decode( file_get_contents(app()->resourcePath('views/themes/'.$theme.'/info.json')) , true );
            $list_theme[$theme] = $content;
        }
    }


    return ['rows'=>$list_theme];
}elseif( $input['action'] === 'next'){

    if( $input['name'] ){
        recurse_copy( app()->resourcePath('views/themes/'.$input['name'].'/public/'), public_path('themes/'.$input['name'].'/') );
    }

    if( $input['importData'] ){
        return include __DIR__.'/theme-import-data.php';
    }else{
        return include __DIR__.'/theme-empty.php';
    }
}

