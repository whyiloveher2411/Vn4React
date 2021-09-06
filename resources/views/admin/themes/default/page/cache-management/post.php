<?php

if( $key = $r->get('flush') ){

	if( env('EXPERIENCE_MODE') ){
	    return experience_mode();
	}
	
	$caches = include cms_path('resource','views/admin/themes/'.$GLOBALS['backend_theme'].'/page/cache-management/cache-default.php');

	$plugins = plugins();

	foreach ($plugins as $plugin) {
	  if( file_exists( $file = cms_path('resource','views/plugins/'.$plugin->key_word.'/inc/cache-management.php')) ){
	    $serach = include $file;
	    if( is_array($serach) ){
	        $caches = array_merge($caches, $serach);
	    }
	  }
	}

	$theme_name = theme_name();
	if( file_exists( $file = cms_path('resource','views/themes/'.$theme_name.'/inc/cache-management.php')) ){
	    $serach = include $file;
	    if( is_array($serach) ){
	        $caches = array_merge($caches, $serach);
	    }
	}


	if( isset($caches[$key]) ){

		if( isset($caches[$key]['flush']) ){
			$result = $caches[$key]['flush']();
		}else{
			Cache::forget($key);
			$result = false;
		}

		try {

			function getRedirectUrl ($url) {
			    stream_context_set_default(array(
			        'http' => array(
			            'method' => 'HEAD'
			        )
			    ));
			    $headers = get_headers($url, 1);
			    if ($headers !== false && isset($headers['Location'])) {
			        return $headers['Location'];
			    }
			    return false;
			}

			@file_get_contents( getRedirectUrl(  route('index')) )  || @file_get_contents( getRedirectUrl(str_replace('https', 'http', route('index'))) );
		} catch (Exception $e) {

		}

		if( $result ){
			return  $result;
		}

		vn4_create_session_message( __('Success'), __('Clear cache success'), 'success' , true );
		return redirect()->back();

	}else{
	 	vn4_create_session_message( __('Error'), __('Sorry, No cache found'), 'error' , true );
		return redirect()->back();
	}

}

return redirect()->back();
