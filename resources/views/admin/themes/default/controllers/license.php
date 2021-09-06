<?php

return [
	'setting'=>function($r){

		$token = $r->get('access_token');

		try {
			$token = (array) \Firebase\JWT\JWT::decode($token, 'vn4cms_api', array('HS256'));
		} catch (Exception $e) {
			return redirect()->back();
		}

		if( !isset($token['key']) || !isset($token['access_token']) ){
			vn4_create_session_message( __('Error'), __('Unable to verify copyright, please check again (Error code 400)'), 'error');
			die( '<script>alert("Unable to verify copyright, please check again (Error code 400)");window.close()</script>' );	
		}else{
			vn4_create_session_message( __('Success'), __('License update successful'), 'success');
			setting_save('license_secret', $token['key']);
			setting_save('license_token', $token['access_token']);
			Cache::forget('setting.');
			Cache::forget('notify');
			die( '<script>alert("License update successful, please refesh your website to see the changes.");window.close()</script>' );	
		}
	}
];