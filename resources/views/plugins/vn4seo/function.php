<?php

$plugin_key_word = $plugin->key_word;


if( $plugin->getMeta('active_sitemap') ){

	add_route('{type}.xml','sitemap_detail','frontend',function($r,$type) use ($plugin) {
		return response()->view( 'plugins.'.$plugin->key_word.'.view.frontend.sitemap',['plugin'=>$plugin,'type'=>$type])->header('Content-Type', 'application/xml');
	});
}


if( is_admin() ){
	include __DIR__.'/inc/backend.php';
}else{
	include __DIR__.'/inc/frontend.php';
}
