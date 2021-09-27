<?php


function copyemz($file1,$file2){

    if( !file_exists($file2) ){

        $contentx =@file_get_contents($file1);
        $openedfile = fopen($file2, "w");
        fwrite($openedfile, $contentx);
        fclose($openedfile);
        if ($contentx === FALSE) {
            $status=false;
        }else $status=true;

        return $status;
    }

    return true;
}

function recurse_copy($src,$dst) {
    $dir = opendir($src);
    @mkdir($dst);
    while(false !== ( $file = readdir($dir)) ) {
        if (( $file != '.' ) && ( $file != '..' )) {
            if ( is_dir($src . '/' . $file) ) {
                recurse_copy($src . '/' . $file,$dst . '/' . $file);
            }
            else {
                copyemz($src . '/' . $file,$dst . '/' . $file);
            }
        }
    }
    closedir($dir);
}

function setEnvironmentValue(array $values)
{
    $envFile = app()->environmentFilePath();

    if (!file_exists( __DIR__.'/../../site/'.$_SERVER['SERVER_NAME'])) {
        mkdir( __DIR__.'/../../site/'.$_SERVER['SERVER_NAME'], 0777, true);
    }

    if( !file_exists($envFile) ){
        copyemz( __DIR__.'/../../.env.example' ,$envFile);
    }

    $str = file_get_contents($envFile);

    if (count($values) > 0) {
        foreach ($values as $envKey => $envValue) {

            $str .= "\n"; 
            $keyPosition = strpos($str, "{$envKey}=");
            $endOfLinePosition = strpos($str, "\n", $keyPosition);
            $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);

            // If key does not exist, add it
            if (!$keyPosition || !$endOfLinePosition || !$oldLine) {
                $str .= "{$envKey}={$envValue}\n";
            } else {
                $str = str_replace($oldLine, "{$envKey}={$envValue}", $str);
            }

        }
    }

    $str = substr($str, 0, -1);
    if (!file_put_contents($envFile, $str)) return false;
    return true;
}

function makesFolderPath(){
    
    $result = true;

    if( !file_exists( $file = cms_path('storage','logs')) ){
        mkdir($file, 0777, true);
    }

    if( !file_exists( $file = cms_path('storage','framework/cache')) ){
        mkdir( $file , 0777, true);
    }

    if( !file_exists( $file = cms_path('storage','framework/views')) ){
        mkdir( $file, 0777, true);
    }
  
    if( !file_exists( $file = cms_path('storage','framework/sessions') ) ){
        mkdir( $file, 0777, true);
    }
    if( !file_exists( $file = cms_path('storage','cms/database') ) ){
        mkdir( $file, 0777, true);
    }

    $folder = scandir(app()->resourcePath('views/plugins/'));

    foreach ($folder as $plugin) {
        if( $plugin !== '.' && $plugin !== '..' && file_exists(app()->resourcePath('views/plugins/'.$plugin.'/public')) ){
            if (!file_exists( public_path('plugins/'.$plugin) )) {
                mkdir( public_path('plugins/'.$plugin) , 0777, true);
            }
            recurse_copy( app()->resourcePath('views/plugins/'.$plugin.'/public'), public_path('plugins/'.$plugin.'/') );
        }
    }
        
    $folder = scandir(app()->resourcePath('views/themes/'));
    foreach ($folder as $theme) {
        if( $theme !== '.' && $theme !== '..' && file_exists(app()->resourcePath('views/themes/'.$theme.'/info.json')) ){
            copyemz( app()->resourcePath('views/themes/'.$theme.'/public/screenshot.png'), public_path('themes/'.$theme.'.png'));
        }
    }

    return [
        'message'=>'',
        'result'=>$result
    ];
}