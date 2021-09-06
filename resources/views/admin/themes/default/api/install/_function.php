<?php


function copyemz($file1,$file2){
	$contentx =@file_get_contents($file1);
	$openedfile = fopen($file2, "w");
	fwrite($openedfile, $contentx);
	fclose($openedfile);
	if ($contentx === FALSE) {
		$status=false;
	}else $status=true;

	return $status;
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