<?php

function refesh_token($plugin){

	$settings = setting('google_analytics/analytics_api');

	$access_code = $settings['access_token_first']??[];
	
	$app_config  = json_decode(file_get_contents(__DIR__ . '/client_secret_app.json'),true);

	$token = json_decode( file_post_contents_curl('https://www.googleapis.com/oauth2/v4/token',
			['client_id'=>$app_config['installed']['client_id'],
			'client_secret'=>$app_config['installed']['client_secret'],
			'refresh_token'=>$access_code['refresh_token'],
			'grant_type'=>'refresh_token']),true);

	if( isset($token['error']) ){
		vn4_create_session_message('Error',__p('Please reconfigure google analytics plugin.',$plugin->key_word).' <a href="'.route('admin.plugin.controller',['plugin'=>$plugin->key_word,'controller'=>'setting','method'=>'index','vn4-tab-top-screen'=>'analytics']).'">Here</a>','error', 'plugin-google-analytics-reconfigure');
		return redirect()->back();
	}

	if( !isset($token['access_token']) ){
		vn4_create_session_message('Error',__p('Please reconfigure google analytics plugin.',$plugin->key_word).' <a href="'.route('admin.plugin.controller',['plugin'=>$plugin->key_word,'controller'=>'setting','method'=>'index','vn4-tab-top-screen'=>'analytics']).'">Here</a>','error','plugin-google-analytics-reconfigure');
		return redirect()->back();
	}

	$access_code['created'] = time();
	$access_code['expires_in'] = $token['expires_in'];
	$access_code['access_token'] = $token['access_token'];

	$settings['access_token_first'] = $access_code;

	setting_save('google_analytics/analytics_api', $settings, 'seo', true );

	return $access_code['access_token'];
}

function get_access_token($plugin){

	$settings = setting('google_analytics/analytics_api');

	$access_code = $settings['access_token_first']??[];

	if( time() >= $access_code['created'] + $access_code['expires_in'] ){
		return refesh_token($plugin);
	}

	return $access_code['access_token'];

}
