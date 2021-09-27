<?php
$success  =  File::cleanDirectory( storage_path('framework/views') );


$result = [];

if( $success ){
    $result['message'] = apiMessage( 'Refresh views success' );
}else{
    $result['message'] = apiMessage( 'Refresh views fail', 'error' );
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



return $result;
