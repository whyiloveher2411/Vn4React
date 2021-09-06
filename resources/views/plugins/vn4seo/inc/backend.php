<?php

add_meta_box(
	'plugin-seo-general',
	'Search Engine Optimization',
	function($config){
		return isset($config['public_view']) && $config['public_view'];
	},
	'left',
	'zzzzzzplugin-seo-general' ,
	function($customePostConfig, $post) use ($plugin){

		if( $customePostConfig['public_view'] ){

			if( $post ){
				$data = [
					'plugin_vn4seo_google_title'=>$post->getMeta('plugin_vn4seo_google_title',$post->title),
					'plugin_vn4seo_google_description'=>$post->getMeta('plugin_vn4seo_google_description',''),
					'plugin_vn4seo_focus_keyword'=>$post->getMeta('plugin_vn4seo_focus_keyword',''),
					'link'=>get_permalinks($post),
					'plugin_vn4seo_canonical_url'=>$post->getMeta('plugin_vn4seo_canonical_url',''),
					'plugin_vn4seo_facebook_title'=>$post->getMeta('plugin_vn4seo_facebook_title'),
					'plugin_vn4seo_facebook_description'=>$post->getMeta('plugin_vn4seo_facebook_description'),
					'plugin_vn4seo_facebook_image'=>$post->getMeta('plugin_vn4seo_facebook_image'),
					'plugin_vn4seo_twitter_title'=>$post->getMeta('plugin_vn4seo_twitter_title'),
					'plugin_vn4seo_twitter_description'=>$post->getMeta('plugin_vn4seo_twitter_description'),
					'plugin_vn4seo_twitter_image'=>$post->getMeta('plugin_vn4seo_twitter_image'),
				];
			}else{
				$data = [
					'plugin_vn4seo_google_title'=>'',
					'plugin_vn4seo_google_description'=>'',
					'plugin_vn4seo_focus_keyword'=>'',
					'plugin_vn4seo_canonical_url'=>'',
					'link'=>'https://www.google.com.vn',
					'plugin_vn4seo_facebook_title'=>'',
					'plugin_vn4seo_facebook_description'=>'',
					'plugin_vn4seo_facebook_image'=>'',
					'plugin_vn4seo_twitter_title'=>'',
					'plugin_vn4seo_twitter_description'=>'',
					'plugin_vn4seo_twitter_image'=>'',
				];
			}
			
			echo view_plugin($plugin,'view.post-type.master', ['plugin_keyword'=>$plugin->key_word,'post'=>$post,'data'=>$data]);
		}else{
			echo 'None SEO';
		}
	}, 
	function($post, $request){

		if( get_admin_object($post->type)['public_view'] ){

			$input = $request->get('plugin_vn4seo');

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
			if( $input['plugin_vn4seo_facebook_image'] && $img = get_media($input['plugin_vn4seo_facebook_image']) ){
				$meta['og:image'] = '<meta property="og:image" content="'.$img.'" />';
			}

			$meta['twitter:card'] = '<meta name="twitter:card" content="summary" />';
			$meta['twitter:title'] = '<meta name="twitter:title" content="'.e($input['plugin_vn4seo_twitter_title']??$post->title).'" />';
			$meta['twitter:description'] = '<meta name="twitter:description" content="'.e($input['plugin_vn4seo_twitter_description']??$post->title).'" />';
			if( $input['plugin_vn4seo_twitter_image'] && $img = get_media($input['plugin_vn4seo_twitter_image']) ){
				$meta['twitter:image'] = '<meta name="twitter:image" content="'.$img.'" />';
			}

			$input['meta'] = $meta;

			$post->updateMeta($input);
		}
		return $post;
	}
);

