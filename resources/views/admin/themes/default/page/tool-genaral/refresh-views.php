<?php
$success  =  File::cleanDirectory( storage_path('framework/views') );

if( $success ){
	vn4_create_session_message( __('Success'), __('Refresh views success'), 'success', true );
}else{

	vn4_create_session_message( __('Fail'), __('Refresh views fail'), 'error', true );
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


$is_acction = true;
