<?php

set_time_limit(0);

$type = $r->get('type');
$path = $r->get('path');
$dir = trim($r->get('dir'),'/');

function tiny_image_jpg($file){
	
	return shell_exec('/usr/share/guetzli-master/bin/Release/guetzli --quality 84 "'.$file.'" "'.$file.'"');

}
function tiny_image_png( $file ){

	$extension = explode('.', $file);

	array_pop($extension);

	$file = implode('.',$extension);


	$index = 2;
	while ( file_exists(cms_path('public',$file.'-'.$index.'.png')) ) {
		$index++;
	}

	$output = shell_exec('pngquant --quality=15-80 "public/'.$file.'.png" --output "public/'.$file.'-'.$index.'.png"');

	unlink(cms_path('public',$file.'.png'));

	rename(cms_path('public',$file.'-'.$index.'.png'), cms_path('public',$file.'.png'));

}

if( $type === 'jpg' ){

	$file = 'public/'.$dir.'/'.$path;

	tiny_image_jpg($file);

	return ['success'=>true];

}elseif( $type === 'png' ){

	$file = $dir.'/'.$path;

	tiny_image_png($file);

	return ['success'=>true];

}else{

	$files = scandir ('public/'.$dir.'/'.$path);

	foreach ($files as $file) {
		if( $file !== '.' && $file !== '..'){
			$file = explode('.', $file);

			$extension = array_pop($file);

			if( $extension === 'jpg' ){
				tiny_image_jpg('public/'.$dir.'/'.$path.'/'.implode('.',$file).'.jpg');
			}elseif( $extension === 'png' ){
				tiny_image_png($dir.'/'.$path.'/'.implode('.',$file).'.png');
			}

		}
	}

	return ['success'=>true];

}