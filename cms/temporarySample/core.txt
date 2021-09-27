<?php

//containt and helpers containt
include __DIR__.'/core/containt.php';

if( is_admin() ){
	include __DIR__.'/backend.php'; 
}else{
	include __DIR__.'/frontend.php'; 
}


$listPlugin = plugins();
foreach ($listPlugin as $value) {

	$plugin = $value;

	if(File::exists(__DIR__.'/../resources/views/plugins/'.$value->key_word.'/function.php')){

		include __DIR__.'/../resources/views/plugins/'.$value->key_word.'/function.php';
	}

}

$GLOBALS['mydomain'] = setting('general_domain');

$theme = theme_name();

if($theme !== 'general_client_theme'){

	if(File::exists(__DIR__.'/../resources/views/themes/'.$theme.'/function.php')){
		
		include __DIR__.'/../resources/views/themes/'.$theme.'/function.php';
	}

}
