<?php

$plugins = $list = File::directories(Config::get('view.paths')[0].'/plugins/');

foreach ($plugins as $value) {

 	$folder_theme = basename($value);
 	
	File::copyDirectory(cms_path('resource').'views/plugins/'.$folder_theme.'/public/', cms_path().'plugins/'.$folder_theme.'/');

}

$theme = theme_name();

File::copyDirectory(cms_path('resource').'views/themes/'.$theme.'/public/', cms_path().'themes/'.$theme.'/');


$themes = $list = File::directories(Config::get('view.paths')[0].'/themes/');

foreach ($themes as $value) {

	if( file_exists($file = $value.'/public/screenshot.png') ){
		$folder_theme = basename($value);

		File::isDirectory( cms_path('public').'themes/'.$folder_theme ) or File::makeDirectory( cms_path('public').'themes/'.$folder_theme , 0777, true, true);

		File::copy($file,cms_path('public').'themes/'.$folder_theme.'/screenshot.png');
	}

}



// if ( file_exists( cms_path('resource').'views/themes/'.$theme.'/screenshot.png' ) ){

// 	File::copy(cms_path('resource').'views/themes/'.$theme.'/screenshot.png',cms_path().'themes/'.$theme.'/screenshot.png');
// }

vn4_create_session_message( __('Ready'), __('The resource has been copied to the directory and ready to use.'), 'success', true );

$is_acction = true;

