<?php

$action = $r->get('action',false);

if( $action && $action !== 'check-notify' && $action !== 'check-plugin' ){
	
	$checkPermissionView = check_permission($page.'_view');
	$checkPermissionTool = check_permission('tool_'.$action);

	if(!$checkPermissionView || !$checkPermissionTool){
		vn4_create_session_message( __('Error'), __('Sorry, you are not allowed to access this page'), 'error' , true );

		if( $r->has('rel') ){
			$rel = $r->get('rel');
			if( is_url($rel) ){
				return redirect($rel);
			}
			return redirect()->back();
		}

		return redirect()->route('admin.index');
	}
}

$is_acction = false;

if( $action && file_exists(__DIR__.'/'.$r->get('action').'.php') ){

	if( $action !== 'check-notify' && $action !== 'check-plugin' && env('EXPERIENCE_MODE') ){
	    return experience_mode();
	}


	$result = include __DIR__.'/'.$r->get('action').'.php';

	if( $result !== 1 ){
		return $result;
	}else{
		$is_acction = true;
	}
	
}


if( $r->has('rel') ){
	$rel = $r->get('rel');
	if( is_url($rel) ){
		return redirect($rel);
	}
	return redirect()->back();
}

if( $is_acction ) return redirect(route('admin.page','tool-genaral'));




