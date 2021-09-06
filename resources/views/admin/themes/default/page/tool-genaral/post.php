<?php 
if( $r->has('code') ){

	if( $r->has('is_editor') ){
		return vn4_view(backend_theme('page.tool-genaral.validate-html-in-editor'),['code'=>$r->get('code'),'key'=>$r->get('key')]);
	}
	return vn4_view(backend_theme('page.tool-genaral.validate-html-in-tool-page'),['code'=>$r->get('code')]);
}


$is_acction = false;

if( $r->has('action') && file_exists(__DIR__.'/'.$r->get('action').'.php') ){

	if( env('EXPERIENCE_MODE') ){
	    return experience_mode();
	}

	$result = include __DIR__.'/'.$r->get('action').'.php';

	if( $result ){
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

return redirect()->route('admin.page','tool-genaral');