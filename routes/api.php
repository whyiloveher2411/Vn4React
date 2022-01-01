<?php

use Illuminate\Http\Request;

include __DIR__.'/../cms/core.php';
include __DIR__.'/../cms/api_helper.php';

$request = request();

if( $request->is('api/admin/*') ){

	apiAccessHeader();

	$formKey = explode('#',base64_decode($request->get('__l')));

	if( isset($formKey[1]) ){
		
		App::setLocale( $formKey[0] );
		
		$abs = time() - $formKey[1]/1000;

		if( $abs > 10  || $abs < -10){
			die(json_encode([
				'message'=>apiMessage('Form Key error, please refesh page!','error')
			]));
		}
	}
	
	Route::group(['prefix'=>'admin','middleware'=>'api', 'namespace'=>'API'],function() use ($router) {

		$listPlugin = plugins();
		
		Route::any('plugin/{plugin}/{group}/{api}',function($plugin, $group, $api) use ($listPlugin) {

			$checkResult = checkUserAdmin();

			if( $checkResult !== null ){
				return $checkResult;
			}

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

			$checkResult = checkUserAdmin();

			if( $checkResult !== null ){
				return $checkResult;
			}

			if( file_exists( $file = cms_path('resource','views/themes/'.$theme.'/inc/api/admin/'.$api.'.php') ) ){
				return include $file;
			}

			return apiNotFound();

		});

		include cms_path('resource','views/admin/themes/default/api/admin/loader.php');

	});
}

if( request()->is('api/*') ){

	apiAccessHeader();

	Route::any('install/admin/system-check',function() {
		return ['error'=>true, 'redirect'=>'/dashboard'];
	});
	
}



