<?php


add_action('api_save_post_type',function($post){

	$request = request();

	$input = $request->get('meta');

	$arg = ['plugin_vn4seo_google_title','plugin_vn4seo_google_description','plugin_vn4seo_focus_keyword','plugin_vn4seo_facebook_title','plugin_vn4seo_facebook_description','plugin_vn4seo_facebook_image','plugin_vn4seo_twitter_title','plugin_vn4seo_twitter_description','plugin_vn4seo_twitter_image','plugin_vn4seo_canonical_url'];

	foreach ($input as $key => $value) {
		if( array_search($key, $arg) === false ){
			unset($input[$key]);
		}
	}

	$meta['description'] = '<meta name="description" content="'.e($input['plugin_vn4seo_google_description']??$post->title).'" />';

	if( isset($input['plugin_vn4seo_canonical_url']) && $input['plugin_vn4seo_canonical_url'] ){
		$meta['canonical'] = '<link rel="canonical" href="'.$input['plugin_vn4seo_canonical_url'].'" />';
	}

	$meta['og:type'] = '<meta property="og:type" content="article" />';
	$meta['og:title'] = '<meta property="og:title" content="'.e($input['plugin_vn4seo_facebook_title']??$post->title).'" />';
	$meta['og:description'] = '<meta property="og:description" content="'.e($input['plugin_vn4seo_facebook_description']??$post->title).'" />';
	$meta['og:url'] = '<meta property="og:url" content="'.get_permalinks($post).'" />';
	$meta['og:site_name'] = '<meta property="og:site_name" content="'.e(setting('general_site_title')).'" />';
	if( isset($input['plugin_vn4seo_facebook_image']) && $img = get_media($input['plugin_vn4seo_facebook_image']) ){
		$meta['og:image'] = '<meta property="og:image" content="'.$img.'" />';
	}

	$meta['twitter:card'] = '<meta name="twitter:card" content="summary" />';
	$meta['twitter:title'] = '<meta name="twitter:title" content="'.e($input['plugin_vn4seo_twitter_title']??$post->title).'" />';
	$meta['twitter:description'] = '<meta name="twitter:description" content="'.e($input['plugin_vn4seo_twitter_description']??$post->title).'" />';
	if( isset($input['plugin_vn4seo_twitter_image']) && $img = get_media($input['plugin_vn4seo_twitter_image']) ){
		$meta['twitter:image'] = '<meta name="twitter:image" content="'.$img.'" />';
	}

	$input['meta'] = $meta;

	$post->updateMeta($input);

	return $post;
});


Route::any('plugin/vn4seo/{name}',function($name) use ($plugin) {

	$r = request();

	return include __DIR__.'/api/'.$name.'.php';
});
