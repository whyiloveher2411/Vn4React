<?php

return [
	'index'=>function($r){

		$user = Auth::user();

		$class_body = $user->getMeta('collapse',false)?'collapse-body':'nav-md';

		if( !function_exists('get_sidebar_admin_object')){
			function get_sidebar_admin_object(){
	            if ( isset($GLOBALS['function_helper_get_sidebar_admin_object']) ){
			        return $GLOBALS['function_helper_get_sidebar_admin_object'];
			    }
			    $sidebar = include public_path().'/../resources/views/admin/themes/'.$GLOBALS['backend_theme'].'/data/sidebar_admin.php';
			    $GLOBALS['function_helper_get_sidebar_admin_object'] = $sidebar;
			    return $sidebar;
			}
		}

		return response()->json([
			'menu'=>vn4_view(backend_theme('particle.sidebar'),['class_body'=>$class_body])
		]);
	}
];