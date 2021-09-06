<?php



add_action('api_save_post_type',function($post){
	
	$request = request();

	$keysMeta = $request->get('aptp_field');


	if( isset($keysMeta[0]) ){

		$metaUpdate = [];
		$meta = $request->get('meta');

		foreach( $keysMeta as $key ){
			$metaUpdate[$key] = isset($meta[ $key ]) ? $meta[ $key ] : '';
		}

		$post->updateMeta($metaUpdate);
	}

	return $post;
});




Route::any('plugin/advanced-custom-post-pro-aptp/{name}',function($name) use ($plugin) {

	$r = request();

	return include __DIR__.'/api/'.$name.'.php';
});

