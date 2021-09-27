<?php

use Illuminate\Http\Request;

include __DIR__.'/../cms/core.php';

if( request()->is('api/admin/*') ){
	include __DIR__.'/../cms/api_helper.php';

	if (isset($_SERVER['HTTP_ORIGIN'])) {
	    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
	    header('Access-Control-Allow-Credentials: true');
	    header('Access-Control-Max-Age: 86400');    // cache for 1 day
	}
	// Access-Control headers are received during OPTIONS requests
	if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

	    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
	        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

	    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
	        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

	    exit(0);
	}
	
	Route::group(['prefix'=>'admin','middleware'=>'api', 'namespace'=>'API'],function() use ($router) {

		$listPlugin = plugins();
		
		Route::any('plugin/{plugin}/{group}/{api}',function($plugin, $group, $api) use ($listPlugin) {

			if( isset($listPlugin[$plugin]) 
				&& file_exists( $file = cms_path('resource','views/plugins/'.$plugin.'/inc/api/admin/'.$group.'/'.$api.'.php') ) ){
					$r = request();
					$plugin = $listPlugin[$plugin];
					return include $file;
			}else{
				return apiNotFound();
			}

		});

		$theme = theme_name();

		Route::any('theme/'.$theme.'/{group}/{api}',function($group, $api){

			if( file_exists( $file = cms_path('resource','views/themes/'.$theme.'/inc/api/admin/'.$api.'.php') ) ){
				return include $file;
			}

			return apiNotFound();

		});

		include cms_path('resource','views/admin/themes/default/api/admin/loader.php');

	});
}

if( request()->is('api/*') ){

}



