<?php

try {

	if( !function_exists('clear_all_cached_Dir') ){
		function clear_all_cached_Dir($dirPath) {
		    if (! is_dir($dirPath)) {
		        throw new InvalidArgumentException("$dirPath must be a directory");
		    }
		    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
		        $dirPath .= '/';
		    }
		    $files = glob($dirPath . '*', GLOB_MARK);
		    foreach ($files as $file) {
		        if (is_dir($file)) {
		            clear_all_cached_Dir($file);
		        } else {
		            unlink($file);
		        }
		    }
		    rmdir($dirPath);
		}
	}

	clear_all_cached_Dir(cms_path('storage', 'framework/cache/'));

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

	vn4_create_session_message( __('Success'), __('Clear Cache Success.'), 'success', true );

	$is_acction = true;

} catch (Exception $e) {

	vn4_create_session_message( __('Error'), $e->getMessage(), 'error', true );

	$is_acction = true;
}

