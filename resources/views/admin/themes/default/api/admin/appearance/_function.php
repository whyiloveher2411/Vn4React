<?php


function getThemes(){
    
    $list = File::directories(Config::get('view.paths')[0].'/themes/');

    $themeActive = setting('general_client_theme');

    foreach ($list as $value) {

        $folder_theme = explode(DIRECTORY_SEPARATOR, $value);
        $folder_theme = end($folder_theme);
        $fileName = $value.'/info.json';
        $info = [];
        if( file_exists( $fileName ) ){
        $info = json_decode(File::get($fileName), true);
        }


        if( file_exists( cms_path().'themes/'.$folder_theme.'/screenshot.png' ) ){
            $img = asset('themes/'.$folder_theme.'/screenshot.png');
            $hasImage = true;
        }else{
            $img = asset('admin/images/no-image-icon.png');
            $hasImage = false;
        }

        $active = $themeActive === $folder_theme ? true : false;

        $result[$folder_theme] = [
            'info'=>$info,
            'active'=>$active,
            'image'=>$img,
            'hasImage'=>$hasImage
        ];
    }

    return $result;

}