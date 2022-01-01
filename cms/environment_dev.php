<?php
// Developing

//hook
include __DIR__.'/core/hook.php';

function request($key = null, $default = null){

    if( isset($GLOBALS['____f_request____']) ) return $GLOBALS['____f_request____'];

    if (is_null($key)) {
        $GLOBALS['____f_request____'] = app('request');
        return $GLOBALS['____f_request____'];
    }elseif (is_array($key)) {
        $GLOBALS['____f_request____'] = app('request')->only($key);
        return $GLOBALS['____f_request____'];
    }

    $value = app('request')->__get($key);

    $GLOBALS['____f_request____'] = is_null($value) ? value($default) : $value;

    return $GLOBALS['____f_request____'];
    
}

add_action('middleware_web',function(){

	$listPlugin = plugins();

	foreach ($listPlugin as $value) {

		$plugin = $value;

		if(File::exists(__DIR__.'/../resources/views/plugins/'.$value->key_word.'/inc/developing.php')){

			include __DIR__.'/../resources/views/plugins/'.$value->key_word.'/inc/developing.php';
		}

	}

	$GLOBALS['mydomain'] = setting('general_domain');

	$theme = theme_name();

	if($theme !== 'general_client_theme'){

		if(File::exists(__DIR__.'/../resources/views/themes/'.$theme.'/inc/developing.php')){
			
			include __DIR__.'/../resources/views/themes/'.$theme.'/inc/developing.php';
		}

	}
});

add_action('vn4_footer',function(){

	$is_admin = is_admin();
	?>
	<style type="text/css">
		.blade{
			background: #4bff00 !important;color: black !important;border:1px solid white !important;z-index: 99999;
			<?php if( !$is_admin ) {echo 'position: absolute !important;'; } ?>
		}	
		.s-translate{
			display: inline-block !important;width: auto !important;border: 2px dashed red !important;background: blue !important;color: white !important;white-space: nowrap !important;z-index: 99999;border-radius: 4px;padding: 0 3px;
		}	
		.s-translate b{
			white-space: nowrap !important;font-size:10px !important;
		}
		.s-optimize-seo{
			position: relative;
			border: 2px dashed red !important;
		}
		
	</style>

	<?php
});

function route($name, $parameters = array(), $absolute = true, $route = null, $add_action = true )
{

	if( $add_action ){

		$action = do_action('route',null, $name, $parameters, $absolute, $route);

		if( $action ){
			return $action;
		}
		
	}

	return app('url')->route($name, $parameters, $absolute, $route);
}

function vn4_redirect( $url, $code = 302 ){
    header('Location:  '.  $url , true, $code );
    die();
}

function vn4_view($view_name = null, $data = array(), $mergeData = array(), $active_cache = false ){

	do_action('vn4_view',$view_name);

	$view = view($view_name, $data, $mergeData)->render();
	
	return '<span class="blade">'.str_replace('.', '/', $view_name).'</span>'.$view;
}

function cms_path($name = 'public' ,$path = ''){
	if( !isset($GLOBALS[$name.'_path']) ){
		switch ($name) {
			case 'storage':
			 	$GLOBALS['storage_path'] = storage_path();
				break;
			case 'resource':
			 	$GLOBALS['resource_path'] = app()->resourcePath();
				break;
			case 'app':
			 	$GLOBALS['app_path'] = app_path();
				break;
			case 'root':
			 	$GLOBALS['root_path'] = base_path();
				break;
			default:
				$GLOBALS['public_path'] = public_path();
				break;

		}
	}
    return $GLOBALS[$name.'_path'].'/'.$path;
}



/**
Trans
*/

function __( $trans ){
	
	$lang = App::getLocale();

	if( !isset($GLOBALS['trans_framework_'.$lang]) ) {
		$GLOBALS['trans_framework_'.$lang] = Cache::get('trans_framework_'.$lang );


		if( $GLOBALS['trans_framework_'.$lang] === null ){

		 	$translate = [];

			if( file_exists( cms_path('resource','lang/'.$lang.'.csv') ) ){

				$csv = array_map("str_getcsv", file(cms_path('resource','lang/'.$lang.'.csv')));
			 	foreach ($csv as $line){
			     	$translate[ $line[0] ] = $line[1];
			 	}

			 }
		 	Cache::forever('trans_framework_'.$lang, $translate );
		}

		
	}

	if( isset($GLOBALS['trans_framework_'.$lang][$trans]) ){
		return '<span class="s-translate">'.$GLOBALS['trans_framework_'.$lang][$trans].' <b style="white-space: nowrap;font-size:10px;">(Core)</b></span>';
	}

	return '<span class="s-translate">'.$trans.' <b style="white-space: nowrap;font-size:10px;">(Core)</b></span>';

}


function __t( $trans ){

	$lang = App::getLocale();

	if( !isset($GLOBALS['trans_theme_'.$lang]) ) {
		$GLOBALS['trans_theme_'.$lang] = Cache::get('trans_theme_'.$lang );

		if( $GLOBALS['trans_theme_'.$lang] === null ){

		 	$translate = [];
			if( file_exists( cms_path('resource','views/themes/'.theme_name().'/lang/'.$lang.'.csv') ) ){
				$csv = array_map("str_getcsv", file(cms_path('resource','views/themes/'.theme_name().'/lang/'.$lang.'.csv')));
			 	foreach ($csv as $line){
			     	$translate[ $line[0] ] = $line[1];
			 	}
		 	}
		 	Cache::forever('trans_theme_'.$lang, $translate );
		}

	}

	if( isset($GLOBALS['trans_theme_'.$lang][$trans]) ){
		return '<span class="s-translate">'.$GLOBALS['trans_theme_'.$lang][$trans].'  <b style="white-space: nowrap;font-size:10px;">(Theme)</b><span>';
	}

	return '<span class="s-translate">'.$trans.'  <b style="white-space: nowrap;font-size:10px;">(Theme)</b><span>';
}

function __p($trans, $plugin_keyword ){

	$lang = App::getLocale();

	if( !isset($GLOBALS['trans_plugin_'.$plugin_keyword.'_'.$lang]) ) {
		$GLOBALS['trans_plugin_'.$plugin_keyword.'_'.$lang] = Cache::get( 'trans_plugin_'.$plugin_keyword.'_'.$lang );


		if( $GLOBALS['trans_plugin_'.$plugin_keyword.'_'.$lang] === null ){

		 	$translate = [];
			if( file_exists( cms_path('resource','views/plugins/'.$plugin_keyword.'/lang/'.$lang.'.csv') ) ){
				$csv = array_map("str_getcsv", file(cms_path('resource','views/plugins/'.$plugin_keyword.'/lang/'.$lang.'.csv')));
			 	foreach ($csv as $line){
			     	$translate[ $line[0] ] = $line[1];
			 	}
		 	}
		 	Cache::forever('trans_plugin_'.$plugin_keyword.'_'.$lang, $translate );
		}


	}

	if( isset($GLOBALS['trans_plugin_'.$plugin_keyword.'_'.$lang][$trans]) ){
		return '<span class="s-translate">'.$GLOBALS['trans_plugin_'.$plugin_keyword.'_'.$lang][$trans].' <b>(Plugin: '.$plugin_keyword.')</b>'.'<span>';
	}

	return '<span class="s-translate">'.$trans.' <b>(Plugin: '.$plugin_keyword.')</b>'.'<span>';
}
