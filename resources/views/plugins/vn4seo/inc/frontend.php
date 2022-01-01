<?php
add_action('middleware_frontend',function($request) use ($plugin) {
	
	add_filter('meta',function($meta_old) use ($request,$plugin){

		if( !is_array($meta_old )) $meta_old = [];

		$meta_vn4seo = [];

		$post = get_post();

		$title = __t(setting('general_site_title','Vn4CMS'));

		$webmaster_tools = $plugin->getMeta('webmaster-tools');

		$verifiWebsite = setting('seo/verify_ownership/metatag',false);

		if( $verifiWebsite ){

			$meta_vn4seo['google-site-verification'] = $verifiWebsite;
		}

		if( $post ){

			$title = $post->getMeta('plugin_vn4seo_google_title');
			title_head($title);
			$meta_vn4seo['og:locale'] = '<meta property="og:locale" content="'.App::getLocale().'" />';

			$meta_db = $post->getMeta('meta');

			if( is_array($meta_db) ) $meta_vn4seo  = array_merge( $meta_vn4seo, $meta_db);
			else $meta_vn4seo[] = $meta_db;
			

		}elseif( $GLOBALS['route_name'] === 'page' || $GLOBALS['route_name'] === 'vn4-multiple-language.page' ){

			$page = $request->route('page');

			$title_google = theme_options($page.'_page','plugin_vn4seo_google_title');

			$title = $title_google?$title_google:title_head();

			title_head($title);
			
			$theme_page_meta = theme_options($page.'_page_meta','meta');

			$theme_page_meta = str_replace('##title_head##', $title, $theme_page_meta);

			$meta_vn4seo['og:url'] = '<meta property="og:url" content="'.URL::current().'" />';
			$meta_vn4seo['og:locale'] = '<meta property="og:locale" content="'.App::getLocale().'" />';
			$meta_vn4seo[] = $theme_page_meta;

		}else{
			$meta_vn4seo['og:type'] = '<meta property="og:type" content="website" />';
		}

		return array_merge($meta_old,$meta_vn4seo);

	},'vn4seo',true);
	

});

