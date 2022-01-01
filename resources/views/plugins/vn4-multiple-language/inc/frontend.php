<?php

$regex_lang_page = '';
$custom_post_types = $plugin->getMeta('custom-post-types');

$custom_post_types = $custom_post_types ? $custom_post_types : [];

$my_bowser_lang = 'not_lang';

$GLOBALS['list_language'] = [];

foreach ($languages as $key=>$l) {
	
	$GLOBALS['list_language'][$l['lang_slug']] = $key ;

	if( $l['lang_slug'] === $my_bowser_lang ){
		$GLOBALS['lang_default'] = array_merge($l,['key'=>$key]);
	}

	$regex_lang_page .= '|('.$l['lang_slug'].')';
}

$regex_lang_page = substr($regex_lang_page, 1);

$GLOBALS['vn4_multiple_custom_post'] =  $plugin->getMeta('custom-post-types');


function the_languages() {

	$callback = '';

	switch ($GLOBALS['route_name']) {

		case 'vn4-multiple-language.index':
			$callback = function($key, $lang){
				return route('vn4-multiple-language.index',['language'=>$lang['lang_slug']]);
			};
			break;
		case 'vn4-multiple-language.page':

			$register_page_slug = get_page_slug($keyPage);

			if( $keyPage !== null ){

				$callback = function($key, $lang) use ($keyPage, $register_page_slug){
					return route('vn4-multiple-language.page',['language'=>$lang['lang_slug'],'page'=>$register_page_slug[$keyPage['key_page']][$lang['lang_slug']]]);
				};

			}else{
				$callback = function($key, $lang){
					return route('vn4-multiple-language.page',['language'=>$lang['lang_slug'],'page'=>$GLOBALS['route_current']->parameters['page']]);
				};

			}
			break;
		case 'vn4-multiple-language.post.detail.deep':
		case 'vn4-multiple-language.post.detail':

			$post = get_post();

			if( !$post ){

				$callback = function($key, $lang){
					return route('vn4-multiple-language.404',['language'=>$lang['lang_slug']]);
				};

			}else{

				if( array_search($post->type, $GLOBALS['vn4_multiple_custom_post']) !== false ){

					$post_relationship = $post->getMeta('vn4-multiple-language-post-connect');

					if( is_array($post_relationship) ){

						$callback = function($key, $lang) use ($post_relationship,$post) {

							if( isset($post_relationship['post'][$lang['lang_slug']]) && $postConnect = get_post($post->type, $post_relationship['post'][$lang['lang_slug']]['id']) ){

								$list_post_type_slug = get_post_type_slug();

								if( isset($list_post_type_slug[$postConnect->type][$lang['lang_slug']]) ){
									$post_type = $list_post_type_slug[$postConnect->type][$lang['lang_slug']];
								}else{
									get_admin_object();
									
									$temp = array_flip($GLOBALS['custom_post_slug']);

									$post_type = $temp[$post->type];

								}

								return route('vn4-multiple-language.post.detail',['language'=>$postConnect->language,'post_type'=>$post_type,'slug'=>$postConnect->slug]);

							
							}

							return route('vn4-multiple-language.index',['language'=>$lang['lang_slug']]);
							
						};

					}else{
						
						$callback = function($key, $lang) use ($post) {
							return route('vn4-multiple-language.index',['language'=>$lang['lang_slug']]);
						};
						
					}

				}else{
					$callback = function($key, $lang) use ($post) {

						$list_post_type_slug = get_post_type_slug();

						if( isset($list_post_type_slug[$post->type][$lang['lang_slug']]) ){
							$post_type = $list_post_type_slug[$post->type][$lang['lang_slug']];
						}else{
							get_admin_object();
							
							$temp = array_flip($GLOBALS['custom_post_slug']);

							$post_type = $temp[$post->type];

						}

						return route('vn4-multiple-language.post.detail',['language'=>$lang['lang_slug'],'post_type'=>$post_type,'slug'=>$post->slug]);

					};
				}

			}
			break;
		default:
			$callback = function($key, $lang){
				return route('vn4-multiple-language.404',['language'=>$lang['lang_slug']]);
			};
			break;
	}

	$languages = languages();

	$string = '';

	$localeCode = App::getLocale();

	foreach($languages as $key=>$lang){

		$languages[$key]['url'] = $callback($key, $lang);
		$languages[$key]['flag_image'] = get_flag_language($lang);

		if( $lang['lang_slug'] ===  $localeCode){
			$languages[$key]['active'] = true;

		}else{
			$languages[$key]['active'] = false;
		}

	}	

	return $languages;
}

add_action('middleware_frontend',function(){
	App::setLocale(language_default()['lang_slug']);
});

add_action('get_sidebar',function($id_sidebar){
	return $id_sidebar.'-'.App::getLocale();
});

add_action('vn4_nav_menu',function($key){
	return $key.'-'.App::getLocale();
});


add_action('route',function($data, $name, $parameters, $absolute, $route ) use ($plugin, $languages, $custom_post_types) {

	$lang_current = App::getLocale();

	switch ($name) {
		case 'index':
			if( isset($parameters['language']) ) {
				$lang_current = languages()[$parameters['language']]['lang_slug'];
			}

			$parameters['language'] = $lang_current;
			return route('vn4-multiple-language.index', $parameters, $absolute, $route, false);
			break;
		case 'page':
			$register_page_slug = get_page_slug();

			if( !is_array($parameters) ){
				$parameters = ['page'=>$parameters];
			}

			if( isset($parameters['language']) ) {
				$lang_current = languages()[$parameters['language']]['lang_slug'];
			}

			$parameters['language'] = $lang_current;

			if( isset($register_page_slug[$parameters['page']][$lang_current]) ){
				$parameters['page'] = $register_page_slug[$parameters['page']][$lang_current];
			}

			return route('vn4-multiple-language.page', $parameters, $absolute, $route, false);
			break;
		case 'post.detail':
			$parameters['language'] = $lang_current;
			return route('vn4-multiple-language.post.detail',$parameters, $absolute, $route, false);
			break;
		case 'post.detail.deep':
			$parameters['language'] = $lang_current;
			return route('vn4-multiple-language.post.detail.deep',$parameters, $absolute, $route, false);
			break;
	}
});





add_action('index',function(){
	return vn4_redirect(route('vn4-multiple-language.index',language_default()['lang_slug']));
});

add_action('getPage',function($data, $page){

	$language_default = language_default();

	$register_page_slug = get_page_slug();

	if( isset($register_page_slug[$page][$language_default['lang_slug']]) ){
		return vn4_redirect( route('vn4-multiple-language.page',['language'=>$language_default['lang_slug'],'page'=>$register_page_slug[$page][$language_default['lang_slug']]]));
	}

	return vn4_redirect(route('vn4-multiple-language.page',['language'=>$language_default['lang_slug'],'page'=>$page]));

});


add_action('postDetail',function($data, $post, $post_type,$post_slug) use ($languages) {

	$slugOfPostType = get_post_type_slug();

	if( isset($slugOfPostType[$post_type][$post->language]) ){

		return Redirect::to(route('vn4-multiple-language.post.detail',['language'=>$post->language,'post_type'=>$slugOfPostType[$post_type][$post->language],'post_slug'=>$post_slug]), 301);
	}

	if( !$post->language || !isset($languages[$post->language]) ) $post->language = language_default()['lang_slug']; 

	return Redirect::to(route('vn4-multiple-language.post.detail',['language'=>$post->language,'post_type'=>$post_type,'post_slug'=>$post_slug]), 301);

});

add_route('{language}/404','vn4-multiple-language.404','frontend',function($r, $language) {

	App::setLocale($language);

	return errorPage(404,'Page note found');

},['language'=>$regex_lang_page]);



add_route('/{language}','vn4-multiple-language.index','frontend',function($r, $language) use ($languages) {

	App::setLocale($language);

	title_head(setting('general_description',__('A simple website using Vn4CMS')));

	$theme_option = json_decode(setting('reading_homepage'),true);

	if( !isset($theme_option['type']) ) $theme_option = ['type'=>'default','static-page'=>'none','post-type'=>'page','post-id'=>0];

	$theme = theme_name();

	if( $theme_option['type'] === 'custom' && $page = get_post($theme_option['post-type'],$theme_option['post-id']) ){

		if( $page->language !== $language ){

			$post_connect = $page->getMeta('vn4-multiple-language-post-connect');

			if( isset($post_connect['post']) && isset($post_connect['post'][$language]) ){
				$page = get_post($theme_option['post-type'],$post_connect['post'][$language]['id']);
			}
		}

		return view_post($page);

	}elseif( $theme_option['type'] === 'static-page' && view()->exists( $view = 'themes.'.$theme.'.page.'.$theme_option['static-page']) ){
		return vn4_view($view);
	}

	return vn4_view('themes.'.theme_name().'.index');

},['language'=>$regex_lang_page] );



add_route('/{language}/{page}','vn4-multiple-language.page','frontend',function($r, $language, $page) use ($languages) {

	App::setLocale($language);

	$list_page_slug = get_page_slug($keypage);

	$theme_name = theme_name();

	if( is_array($keypage) ){

		if( $keypage['lang'] !== $language || $keypage['slug'] !== $page ){
			return vn4_redirect(route('vn4-multiple-language.page',['language'=>$keypage['lang'],'page'=>$keypage['slug']]));
		}

		$page = $keypage['key_page'];

	}elseif( isset($list_page_slug[$page][$language]) && $list_page_slug[$page][$language] !== $page ){

		return vn4_redirect(route('vn4-multiple-language.page',['language'=>$language,'page'=>$list_page_slug[$page][$language]]));

	}

	$theme_option = json_decode(setting('reading_'.$page),true);

	if( !isset($theme_option['type']) ) $theme_option = ['type'=>'default','static-page'=>'none','post-type'=>'page','post-id'=>0];

	$theme = theme_name();

	if( $theme_option['type'] === 'custom' && $page = get_post($theme_option['post-type'],$theme_option['post-id']) ){

		if( $page->language !== $language ){

			$post_connect = $page->getMeta('vn4-multiple-language-post-connect');

			if( isset($post_connect['post']) && isset($post_connect['post'][$language]) ){
				$page = get_post($theme_option['post-type'],$post_connect['post'][$language]['id']);
			}
		}
		return view_post($page);
	}

	$view = 'themes.'.$theme_name.'.page.'.$page;

	if( view()->exists( $view ) ){

		title_head(ucwords( preg_replace('/-/', ' ', str_slug(str_replace('.blade.php', '', $page)) )  ));

		if(  File::exists('../resources/views/themes/'.$theme_name.'/page/'.$page.'-post.php') ){
			
           $result = include '../resources/views/themes/'.$theme_name.'/page/'.$page.'-post.php';

           if( $result !== 1 ) return $result;
        }

		return vn4_view($view);

	}

	return errorPage(404,'Page note found');

},['language'=>$regex_lang_page]);

add_route('/{language}/{post_type}/{post_slug}','vn4-multiple-language.post.detail','frontend',function($r, $language, $post_type, $post_slug) use ($custom_post_types, $languages, $plugin) {

	App::setLocale($language);

	$slugOfPostType = get_post_type_slug($post_type,$post_type2);
	
	if( !$post_type2 ){
		
		$post_type2 = convert_slug_custom_post_to_name($post_type);

		if( !$post_type2 ){
			return errorPage(404,'Page note found');
		}

	}

	$post = getPostBySlug($post_type2,$post_slug);

	if( $post ){

		if( !Auth::check() ){

			if( $post->status !== 'publish' ) return errorPage(404,'Not found post');

			if( $post->post_date_gmt - time() > 0 )  return errorPage(404,'Not found post');

		}

		if( array_search($post->type, $custom_post_types) !== false ){

			if( !$post->language || !isset($languages[$post->language]) ){
				$post->language = language_default()['lang_slug'];
			}

		 	$post_connect = $post->getMeta('vn4-multiple-language-post-connect');

			if( ($route = $post->is_homepage) || (isset($post_connect['is_homepage']) && $route = $post_connect['is_homepage']) ){
				if( is_string($route) ) $route = json_decode($route,true);

				if( $route['route-name'] === 'index' ){
					return vn4_redirect(route('vn4-multiple-language.index',$post->language),301);
				}

				if( $route['route-name'] === 'page' ){
					return vn4_redirect(route('vn4-multiple-language.page',['language'=>$post->language, 'page'=>$route['parameter']['page']]),301);
				}

			}
			
			if( $post->language != $language 
				|| (isset($slugOfPostType[$post->type][$post->language]) && $post_type !== $slugOfPostType[$post->type][$post->language]) ){

				if( isset($slugOfPostType[$post->type][$post->language]) ){
					return Redirect::to(route('vn4-multiple-language.post.detail',['language'=>$post->language,'post_type'=>$slugOfPostType[$post->type][$post->language],'post_slug'=>$post->slug]), 301);
				}else{
					return Redirect::to(route('vn4-multiple-language.post.detail',['language'=>$post->language,'post_type'=>get_admin_object($post->type)['slug'],'post_slug'=>$post->slug]), 301);
				}
			}

		}

		return view_post($post);

	}

	return errorPage(404,'Not found post');

},['language'=>$regex_lang_page]);


add_route('/{language}/{post_type}/{post_slug}/{detail_slug}','vn4-multiple-language.post.detail.deep','frontend',function($r, $language, $post_type, $post_slug,$detail_slug) use ($custom_post_types, $languages, $plugin) {

	App::setLocale($language);

	$slugOfPostType = get_post_type_slug($post_type,$post_type2);
	
	if( !$post_type2 ){
		
		$post_type2 = convert_slug_custom_post_to_name($post_type);

		if( !$post_type2 ){
			return errorPage(404,'Page note found');
		}

	}

	$post = getPostBySlug($post_type2,$post_slug);

	if( $post ){

		if( !Auth::check() ){

			if( $post->status !== 'publish' ) return errorPage(404,'Not found post');

			if( $post->post_date_gmt - time() > 0 )  return errorPage(404,'Not found post');

		}

		if( array_search($post->type, $custom_post_types) !== false ){

			if( !$post->language || !isset($languages[$post->language]) ){
				$post->language = language_default()['lang_slug'];
			}

		 	$post_connect = $post->getMeta('vn4-multiple-language-post-connect');

			if( ($route = $post->is_homepage) || (isset($post_connect['is_homepage']) && $route = $post_connect['is_homepage']) ){
				if( is_string($route) ) $route = json_decode($route,true);

				if( $route['route-name'] === 'index' ){
					return vn4_redirect(route('vn4-multiple-language.index',$post->language),301);
				}

				if( $route['route-name'] === 'page' ){
					return vn4_redirect(route('vn4-multiple-language.page',['language'=>$post->language, 'page'=>$route['parameter']['page']]),301);
				}

			}
			
			if( $post->language != $language 
				|| (isset($slugOfPostType[$post->type][$post->language]) && $post_type !== $slugOfPostType[$post->type][$post->language]) ){

				if( isset($slugOfPostType[$post->type][$post->language]) ){
					return Redirect::to(route('vn4-multiple-language.post.detail',['language'=>$post->language,'post_type'=>$slugOfPostType[$post->type][$post->language],'post_slug'=>$post->slug]), 301);
				}else{
					return Redirect::to(route('vn4-multiple-language.post.detail',['language'=>$post->language,'post_type'=>get_admin_object($post->type)['slug'],'post_slug'=>$post->slug]), 301);
				}
			}

		}

		return view_post($post, $detail_slug);

	}

	return errorPage(404,'Not found post');

},['language'=>$regex_lang_page]);


add_action('theme_options_function',function($key1,$key2, $default = ''){
	return App::getLocale().'.'.$key1;
});

add_action('get_posts',function($posts,$post_type) use ($plugin, $languages) {

	$custom_post_types = $plugin->getMeta('custom-post-types');

	if( !is_array($custom_post_types) ) $custom_post_types = [];

	$admin_object = get_admin_object($post_type);

	if( array_search($post_type, $custom_post_types) !== false  ){

		$lang_default = language_default();

		$language_current = App::getLocale();

		if( $lang_default['lang_slug'] === $language_current ){
			$posts->where(function($q) use ($language_current) {
				$q->whereIn('language',[$language_current,''])->orWhereNull('language');
			});
		}else{
			$posts->where('language',$language_current);
		}

	}

});

add_filter('meta',function($meta_old) {
	$language = languages();
	$meta_old['fb_locale'] = '<meta property="og:locale" content="'.$language[App::getLocale()]['lang_locale'].'" />';
	return $meta_old;
},'zzzzzz',true);

add_action('get_permalinks',function($data, $type, $slug, $post, $deep) use ($plugin) {

	$custom_post_types = $plugin->getMeta('custom-post-types');

	if( !is_array($custom_post_types) ) $custom_post_types = [];


	if(  is_object($post) && array_search($type, $custom_post_types) !== false ){

		if( isset($post->language) && $post->language ){

			if( isset($post->is_homepage) && $post->is_homepage ){

				$route = json_decode($post->is_homepage, true);

				if( isset($route['route-name']) ){
					$route['route-name'] = $route['route-name'] === 'page'?'vn4-multiple-language.page':'vn4-multiple-language.index';
					$route['parameter']['language'] = $post->language;
	    			return route($route['route-name'],$route['parameter']);
				}

	    	}

			$slugOfPostType = get_post_type_slug($type,$post_type2);

			if( isset($slugOfPostType[$post->type][$post->language]) ){

				if( $deep ){
					return route('vn4-multiple-language.post.detail.deep',['language'=>$post->language, 'post_type'=>$slugOfPostType[$post->type][$post->language],'slug'=>$post->slug, 'detail_slug'=>$deep]);
				}

				return route('vn4-multiple-language.post.detail',['language'=>$post->language, 'post_type'=>$slugOfPostType[$post->type][$post->language],'slug'=>$post->slug]);
			}

			$admin_object = get_admin_object($post->type);

			if( $deep ){
				return route('vn4-multiple-language.post.detail.deep',['language'=>$post->language, 'post_type'=>$admin_object['slug'],'slug'=>$post->slug, 'detail_slug'=>$deep]);
			}

			return route('vn4-multiple-language.post.detail',['language'=>$post->language, 'post_type'=>$admin_object['slug'],'slug'=>$post->slug]);
		}else{

			$language = App::getLocale();

			$admin_object = get_admin_object($post->type);

			if( $deep ){
				return route('vn4-multiple-language.post.detail.deep',['language'=>$language, 'post_type'=>$admin_object['slug'],'slug'=>$post->slug, 'detail_slug'=>$deep]);
			}

			return route('vn4-multiple-language.post.detail',['language'=>$language, 'post_type'=>$admin_object['slug'],'slug'=>$post->slug]);
		}

	}
	
});