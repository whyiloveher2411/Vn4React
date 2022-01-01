<?php

$r = request();

$input = json_decode($r->getContent(),true);

if( $input ){
    $r->merge($input);
}

$result = [];


if( $param1 === 'change-theme'){

    if( config('app.EXPERIENCE_MODE') ){
        return experience_mode();
    }
        
    $theme = $r->get('theme');

    unset($GLOBALS['function_helper_get_admin_object']);
    use_module('check_database_mysql');

    if( file_exists( $file = cms_path('resource').'views/themes/'.$theme.'/inc/activate.php') ){
        $install = include $file;
        if( $install !== 1 ) return $install;
    }

    setting_save('general_client_theme', $theme , 'general', true);
    Cache::forget('setting.');

    $result['message'] = apiMessage('Change Theme Success.');
}

include __DIR__.'/_function.php';

$result['rows'] = getThemes();

return $result;