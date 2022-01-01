<?php
function searchConsoleRefeshToken($plugin){

	$settings = setting('seo/analytics/google_search_console');

	$access_code = $settings['access_token_first']??[];

	$app_config  = json_decode(file_get_contents(__DIR__ . '/client_secret_app.json'),true);

	$token = json_decode( file_post_contents_curl('https://www.googleapis.com/oauth2/v4/token',
			['client_id'=>$app_config['installed']['client_id'],
			'client_secret'=>$app_config['installed']['client_secret'],
			'refresh_token'=>$access_code['refresh_token'],
			'grant_type'=>'refresh_token']),true);

	if( isset($token['error']) || !isset($token['access_token']) ){
		return false;
	}

	$access_code['created'] = time();
	$access_code['expires_in'] = $token['expires_in'];
	$access_code['access_token'] = $token['access_token'];

	$settings['access_token_first'] = $access_code;

	setting_save('seo/analytics/google_search_console', $settings, 'seo', true );

	return $access_code['access_token'];
}

function searchConsoleGetAccessToken($plugin){

	$settings = setting('seo/analytics/google_search_console');

	$access_code = $settings['access_token_first']??[];

	if( time() >= $access_code['created'] + $access_code['expires_in'] ){
		return searchConsoleRefeshToken($plugin);
	}

	return $access_code['access_token'];

}

function vn4seoGetAudit($nodes){

	$mh = curl_multi_init();
    $curl_array = array();
    foreach($nodes as $i => $url)
    {
        $curl_array[$i] = curl_init($url);
        curl_setopt($curl_array[$i], CURLOPT_RETURNTRANSFER, true);
        curl_multi_add_handle($mh, $curl_array[$i]);
    }
    $running = NULL;
    do {
        usleep(10000);
        curl_multi_exec($mh,$running);
    } while($running > 0);
   
    $res = array();
    foreach($nodes as $i => $url)
    {

    	$res[$i] = Cache::rememberForever($i, function() use ($curl_array, $i) {

    		do{
		        $result = json_decode( curl_multi_getcontent($curl_array[$i]) , true);
	    	}while( isset($result['error']) );

			return $result;
			
		});
    }
   
    foreach($nodes as $i => $url){
        curl_multi_remove_handle($mh, $curl_array[$i]);
    }
    curl_multi_close($mh);       
    return $res;
}
