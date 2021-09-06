<?php

function refesh_token($plugin){
	$access_code = $plugin->getMeta('access_token_first');
	
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

	$plugin->updateMeta('access_token_first',$access_code);

	return $access_code['access_token'];
}

function get_access_token($plugin){

	$access_code = $plugin->getMeta('access_token_first');

	if( time() >= $access_code['created'] + $access_code['expires_in'] ){
		return refesh_token($plugin);
	}

	return $access_code['access_token'];

}


add_route('plugin/google-analytics/report-item/{folder}/{view}','google-analytics.report-item','backend',function($r, $folder, $view) use ($plugin) {
	
	if( check_permission('plugin_google_analytics_view_report') ){

		// try {
			$access_code = $plugin->getMeta('access_token_first');

			$webpropertie_id = $access_code['webpropertie_id'];

			$access_token = get_access_token($plugin);

			include __DIR__.'/function-helper.php';
			// include __DIR__.'/function/'

			

			if( $r->isMethod('GET') ){
				return view_plugin($plugin, 'views.report.'.$folder,['folder'=>$folder,'view'=>$view, 'plugin'=>$plugin,'r'=>$r,'access_code'=>$access_code,'webpropertie_id'=>$webpropertie_id,'access_token'=>$access_token]);
			}

			if( file_exists(cms_path('resource','views/plugins/'.$plugin->key_word.'/views/report/'.$folder.'/'.$view.'_post.php')) ){
				return include cms_path('resource','views/plugins/'.$plugin->key_word.'/views/report/'.$folder.'/'.$view.'_post.php');
			}

		// } catch (Exception $e) {
		// 	die('<h3 style="text-align:center;">In some cases you may not be able to view google analytics because of insufficient data to display, you can view them after a few days or weeks when your website is stable and has stable traffic.</h3>');
		// }

	}
});	


add_route('plugin/google-analytics/report','google-analytics.report','backend',function($r) use ($plugin) {

	if( check_permission('plugin_google_analytics_view_report') ){

		$access_code = $plugin->getMeta('access_token_first');

		$webpropertie_id = $access_code['webpropertie_id'];

		$access_token = get_access_token($plugin);

		return view_plugin($plugin, 'views.report',['plugin'=>$plugin,'access_code'=>$access_code,'webpropertie_id'=>$webpropertie_id,'access_token'=>$access_token]);
	}

	vn4_create_session_message('Permission','You do not have permission to view google analytics reports!','warning');

	return redirect()->back();

});	
