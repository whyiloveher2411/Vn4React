<?php
// Production

//hook
include __DIR__.'/core/hook.php';

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
	
	return $view;
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

function request($key = null, $default = null){

    if( isset($GLOBALS['__request']) ) return $GLOBALS['__request'];

    if (is_null($key)) {
        $GLOBALS['__request'] = app('request');
        return $GLOBALS['__request'];
    }elseif (is_array($key)) {
        $GLOBALS['__request'] = app('request')->only($key);
        return $GLOBALS['__request'];
    }

    $value = app('request')->__get($key);

    $GLOBALS['__request'] = is_null($value) ? value($default) : $value;

    return $GLOBALS['__request'];
}

/**
*Translate
*/

function __( $trans, $param = false ){
	
	$lang = App::getLocale();

	$result = $trans;

	if( !isset($GLOBALS['trans_default_'.$lang]) ) {
		$GLOBALS['trans_default_'.$lang] = Cache::get('trans_default_'.$lang );


		if( $GLOBALS['trans_default_'.$lang] === null ){

		 	$translate = [];

			if( file_exists( $file = cms_path('resource','lang/'.$lang.'.json') ) ){
				$translate = json_decode( file_get_contents($file) , true);
				if( !$translate ) $translate = [];
			}

		 	Cache::forever('trans_default_'.$lang, $translate );
		}
	}

	if( isset($GLOBALS['trans_default_'.$lang][$trans]) ){
		$result = $GLOBALS['trans_default_'.$lang][$trans];
	}

	if( $param ){

		$keys = array_keys( $param );

		$keys = array_map( function($key){
			return '{{'.$key.'}}';
		}, $keys );

		$values = array_values( $param );

		$result = str_replace( $keys, $values, $result);
	}

	return $result;
}


function __t( $trans, $param = false ){

	$lang = App::getLocale();

	$result = $trans;

	if( !isset($GLOBALS['trans_theme_'.$lang]) ) {
		
		$GLOBALS['trans_theme_'.$lang] = Cache::get('trans_theme_'.$lang );

		if( $GLOBALS['trans_theme_'.$lang] === null ){

			$translate = [];

			if( file_exists($file = cms_path('resource','views/themes/'.theme_name().'/lang/'.$lang.'.json') ) ){
				$translate = json_decode( file_get_contents($file) , true);
				if( !$translate ) $translate = [];
			}

		 	Cache::forever('trans_theme_'.$lang, $translate );
		}

	}
	
	if( isset($GLOBALS['trans_theme_'.$lang][$trans]) ){
		$result = $GLOBALS['trans_theme_'.$lang][$trans];
	}

	if( $param ){

		$keys = array_keys( $param );

		$keys = array_map( function($key){
			return '{{'.$key.'}}';
		}, $keys );

		$values = array_values( $param );

		$result = str_replace( $keys, $values, $result);
	}

	return $result;
}

function __p($trans, $plugin_keyword, $param = false ){

	$lang = App::getLocale();

	$result = $trans;

	if( !isset($GLOBALS['trans_plugin_'.$plugin_keyword.'_'.$lang]) ) {
		$GLOBALS['trans_plugin_'.$plugin_keyword.'_'.$lang] = Cache::get( 'trans_plugin_'.$plugin_keyword.'_'.$lang );


		if( $GLOBALS['trans_plugin_'.$plugin_keyword.'_'.$lang] === null ){

			$translate = [];

			if( file_exists($file = cms_path('resource','views/plugins/'.$plugin_keyword.'/lang/'.$lang.'.json') ) ){
				$translate = json_decode( file_get_contents($file) , true);
				if( !$translate ) $translate = [];
			}
		 	Cache::forever('trans_plugin_'.$plugin_keyword.'_'.$lang, $translate );
		}
	}

	if( isset($GLOBALS['trans_plugin_'.$plugin_keyword.'_'.$lang][$trans]) ){
		$result = $GLOBALS['trans_plugin_'.$plugin_keyword.'_'.$lang][$trans];
	}
	
	if( $param ){

		$keys = array_keys( $param );

		$keys = array_map( function($key){
			return '{{'.$key.'}}';
		}, $keys );

		$values = array_values( $param );

		$result = str_replace( $keys, $values, $result);
	}

	return $result;
}


