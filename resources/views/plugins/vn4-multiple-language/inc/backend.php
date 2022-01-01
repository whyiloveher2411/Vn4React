<?php
//icon language on top bar
add_action('vn4_adminbar_tool',function() use ($plugin) {
	echo '<a data-image="'.plugin_asset($plugin,'image-loading-refresh-lang.svg').'" data-message="'.e(__('Refreshing language, please wait a moment')).'" href="'.route('admin.plugin.controller',['plugin'=>$plugin->key_word,'controller'=>'tool','method'=>'refesh-translate']).'"><i class="fa fa-language" aria-hidden="true"></i> '.__p('Refresh Lang', $plugin->key_word).'</a>';
});

//show button copy menu
add_action('appearance-menu-button',function() use ($plugin){
	echo '<div class="dropdown" style="display:inline;"><a href="#" class="dropdown-toggle vn4-btn" data-toggle="dropdown" role="button" aria-expanded="false">Copy Menu <i class="fa fa-sort-desc" style="vertical-align: top;margin-top: 4px;"></i></a><ul class="dropdown-menu" role="menu" style="margin-top:8px;">';
	$languages = languages();
	foreach ($languages as $key => $value) {
		echo '<li><a href="#" onclick="window.location.href = \''.route('admin.plugin.controller',['plugin'=>$plugin->key_word,'controller'=>'menu','method'=>'copy-menu']).'?id=\'+document.getElementById(\'input_name_menu_current\').getAttribute(\'data-id\')+\'&language='.$value['lang_slug'].'\';return false;" ><img title="'.$value['lang_name'].'" style="" src="'.plugin_asset($plugin,'flags/'.$value['flag'].'.png').'"> '.$value['lang_name'].'</a></li>';
	}
	echo '</ul></div>';
});

//show button languages on theme options
add_action('admin.page.theme-options',function() use ($plugin){
	echo vn4_panel( function() use ($plugin) {
		return __p('Languages',$plugin->key_word).view_plugin($plugin,'views.page-theme-options');
	},null,null,null,['x_panel_style'=>'z-index:99;']);
	
});


//Edit function get theme options
add_action('admin.page.theme-options.get-value',function($key1, $key2){

	$language_default = language_default();
	$languages = languages();
	$lang = request()->get('language',$language_default['lang_slug']);

	if( !isset($languages[$lang]) ) $lang = $language_default['lang_slug'];

	if( !isset($GLOBALS['theme-options-language-'.$lang.$key1] ) ){
		$theme_name = theme_name();
		$option = Vn4Model::firstOrAddnew(vn4_tbpf().'theme_option',['key'=>$theme_name.'.'.$lang.'.'.$key1]);
		$content = json_decode($option->content,true);

		if( !is_array($content) ) $content = [];
		$GLOBALS['theme-options-language-'.$lang.$key1] = $content;
	}

	if( !$key2 ) return $GLOBALS['theme-options-language-'.$lang.$key1];

	if( isset($GLOBALS['theme-options-language-'.$lang.$key1][$key2]) ) return $GLOBALS['theme-options-language-'.$lang.$key1][$key2];

	return '';
});

//Edit function save theme options
add_action('save_theme_options_function',function($key1,$key2,$value){




	$language_default = language_default();
	$languages = languages();
	$lang = request()->get('language',$language_default['lang_slug']);

	if( $key1 === 'page' ){

		$post = get_post('page',$value);

		if( $post && $post->language && isset($languages[$post->language]) ){
			$lang = $post->language;
		}
	}

	if( !isset($languages[$lang]) ) $lang = $language_default['lang_slug'];

	$theme_name = theme_name();

	$option = Vn4Model::firstOrAddnew(vn4_tbpf().'theme_option',['key'=>$theme_name.'.'.$lang.'.'.$key1]);

	$content = json_decode($option->content,true);

	if( !is_array($content) ) $content = [];

	$content[$key2] = $value;

	$option->content = json_encode($content);

	return $option->save();
});



//Change language current
add_action('middleware_web',function(){

	if( Auth::check() ){
		$my_lang = Auth::user()->getMeta('vn4-lang-config',false);

		$languages = languages();

		if( !empty($languages) ){

			if( !isset($languages[$my_lang]) ){

				$my_lang = key($languages);

			}

			if( isset($languages[$my_lang]['lang_slug']) ){
				App::setLocale( $languages[$my_lang]['lang_slug'] );
			}

			$GLOBALS['my_lang'] = $languages[$my_lang];
		}
	}

});


add_action('nav-top',function() use ($plugin) {
	echo view_plugin($plugin, 'views.nav-top');
});

/**
ADD HOOK DELTE POST
*/
add_action('delete_post',function($post, $admin_object) use($plugin) {
	$customePostType = $plugin->getMeta('custom-post-types',[]);

	if( array_search($post->type, $customePostType) !== false ){

		$listPostConnect = $post->getMeta('vn4-multiple-language-post-connect');

		if( !is_array($listPostConnect) ) $listPostConnect = [];

		unset($listPostConnect['post'][$post->language]);

		if( $post->is_homepage ){
			$listPostConnect['is_homepage'] = 0;
		}

		if( !empty($listPostConnect) ){

			$idPostRelationShip = [];

			if( isset($listPostConnect['post']) ){
				foreach ($listPostConnect['post'] as $key => $value) {
					$idPostRelationShip[] = $value['id'];
				}

				$listPostConnect = $listPostConnect;

				$postConnect = (new Vn4Model($post->getTable()))->whereIn(Vn4Model::$id,$idPostRelationShip)->get();

				foreach ($postConnect as $p) {
					$p->updateMeta('vn4-multiple-language-post-connect',$listPostConnect);
				}
			}
			
		}
	}

});


/**
ADD HOOK CUSTOM POST CONFIG
*/
add_action('custome-post-table',function($data, $type, $result) use ($plugin) {

	$admin_object = get_admin_object($type);

	$custome_post_language = $plugin->getMeta('custom-post-types',[]);
 
	if( !is_array($custome_post_language) ){
		$custome_post_language = [];
	}

	if( $admin_object && array_search($type, $custome_post_language) !== false ){

		$languages = languages();

		$statusLanguage = [];

		$countlanguage = count($languages);

		if( $countlanguage < 4 ){

			$title = '';

			foreach ($languages as $key => $l) {

				$title = $title.'<img title="'.$l['lang_name'].'" style="margin-right:10px;" src="'.plugin_asset($plugin,'flags/'.$l['flag'].'.png').'" />';

				if( $l['is_default'] ){
					$statusLanguage[$l['lang_slug']] = ['key'=>'language','where'=>[['language','=',$l['lang_slug']]],'title'=>'<img src="'.plugin_asset($plugin,'flags/'.$l['flag'].'.png').'" /> '.$l['lang_name']];
				}else{
					$statusLanguage[$l['lang_slug']] = ['key'=>'language','where'=>[['language','=',$l['lang_slug']]],'title'=>'<img src="'.plugin_asset($plugin,'flags/'.$l['flag'].'.png').'" /> '.$l['lang_name']];
				}

			}

		}else{

			$title = __('Language');

			foreach ($languages as $key => $l) {

				if( $l['is_default'] ){
					$statusLanguage[$l['lang_slug']] = ['key'=>'language','where'=>[['language','=',$l['lang_slug']]],'title'=>'<img src="'.plugin_asset($plugin,'flags/'.$l['flag'].'.png').'" /> '.$l['lang_name']];
				}else{
					$statusLanguage[$l['lang_slug']] = ['key'=>'language','where'=>[['language','=',$l['lang_slug']]],'title'=>'<img src="'.plugin_asset($plugin,'flags/'.$l['flag'].'.png').'" /> '.$l['lang_name']];
				}

			}

			$statusLanguage = ['language'=>['key'=>'language','title'=>'Language','items'=>$statusLanguage]];

		}
		

		

		$result['filter'] = function($arg) use ($statusLanguage) {
			return array_merge($arg, $statusLanguage);
		};

		$result['fields']['language'] = [

			'title'=>'<span style="white-space: nowrap;">'.$title.'</span>',
			'show_data'=>function($post) use ($plugin, $languages,$countlanguage ) {

				$listPostConnect = $post->getMeta('vn4-multiple-language-post-connect');

				$listPostConnect = isset($listPostConnect['post'])? $listPostConnect['post'] : [];

				$result = '';
				$ul = '';
				$dropdown = '';

				if( $countlanguage < 0 ){

					foreach ($languages as $key => $l) {

						if( $post->language === $l['lang_slug'] || ( !isset($languages[$post->language]) && $l['is_default'] ) ){

							$has_show_my_lang_post = true;

							$result = $result.'<a style="display:inline-block;width:16px;margin-right:12px;font-size:16px;" href="'.route('admin.create_data',['type'=>$post->type,'post'=>$post->id,'action_post'=>'edit']).'"><i class="fa fa-check" aria-hidden="true"></i></a>';
						}else{
							if( isset($listPostConnect[$l['lang_slug']]) && $listPostConnect[$l['lang_slug']]['id'] != $post->id ) {
								$result = $result.'<a style="display:inline-block;width:16px;margin-right:12px;font-size:16px;" href="'.route('admin.create_data',['type'=>$post->type,'post'=>$listPostConnect[$l['lang_slug']]['id'],'action_post'=>'edit']).'"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
							}else{
								$result = $result.'<a style="display:inline-block;width:16px;margin-right:12px;font-size:16px;" href="'.route('admin.create_data',['type'=>$post->type,'translate_post'=>$post->id,'language'=>$key,'post'=>$post->id,'action_post'=>'copy']).'"><i class="fa fa-plus" style="width:16px;text-align:center;" aria-hidden="true"></i></a>';
							}
						}
					}

				}else{

					$not_translated_enough = '';

					foreach ($languages as $key => $l) {

						if( $post->language === $l['lang_slug'] || ( !isset($languages[$post->language]) && $l['is_default'] ) ){

							$has_show_my_lang_post = true;

							$dropdown = '<a href="'.route('admin.create_data',['type'=>$post->type,'post'=>$post->id,'action_post'=>'edit']).'" class="dropdown-toggle vn4-btn" data-toggle="dropdown" role="button" aria-expanded="false"><img title="'.$l['lang_name'].'" style="margin-top: -3px;" src="'.plugin_asset($plugin,'flags/'.$l['flag'].'.png').'"> '.$l['lang_name'].' <i class="fa fa-sort-desc" style="vertical-align: top;margin-top: 4px;"></i></a>';

						}else{

							if( isset($listPostConnect[$l['lang_slug']]) && $listPostConnect[$l['lang_slug']]['id'] != $post->id ) {

								$ul .= '<li><a href="'.route('admin.create_data',['type'=>$post->type,'post'=>$listPostConnect[$l['lang_slug']]['id'],'action_post'=>'edit']).'" ><label><img title="'.$l['lang_name'].'" style="" src="'.plugin_asset($plugin,'flags/'.$l['flag'].'.png').'"> '.$l['lang_name'].' - <span style="color:#666666;">1 version</span></label></a></li>';

							}else{

								// $not_translated_enough .= '<br><span style="margin-top:5px;display: inline-block;"><em>Incomplete language versions<em></span>';
								$not_translated_enough .= ', <a href="'.route('admin.create_data',['type'=>$post->type,'translate_post'=>$post->id,'language'=>$key,'post'=>$post->id,'action_post'=>'copy']).'" ><img title="'.$l['lang_name'].'" style="" src="'.plugin_asset($plugin,'flags/'.$l['flag'].'.png').'"> '.$l['lang_name'].'</a>';

								$ul .= '<li><a href="'.route('admin.create_data',['type'=>$post->type,'translate_post'=>$post->id,'language'=>$key,'post'=>$post->id,'action_post'=>'copy']).'" ><label><img title="'.$l['lang_name'].'" style="" src="'.plugin_asset($plugin,'flags/'.$l['flag'].'.png').'"> '.$l['lang_name'].'</label></a></li>';
							}
						}

					}

					if( $not_translated_enough ) $not_translated_enough = '<br><span style="margin-top:5px;display: inline-block;"><em>Post without translations: '.substr($not_translated_enough, 1).'<em></span>';

					$result = '<div class="dropdown" style="display:inline;">'.$dropdown.'<ul class="dropdown-menu" role="menu" style="margin-top:8px;">'.$ul.'</ul></div>'.$not_translated_enough;
				}

				if( isset($has_show_my_lang_post) ){
					return $result;
				}else{
					return $result.' - '.__p('(Not in any language)',$plugin->key_word);
				}
			}
		];

		return $result;

	} 

	
});

//show filter on many record (relationship)
add_action('many-record',function($q) use ($plugin) {

	$customPostMultiLanguage = $plugin->getMeta('custom-post-types',[]);
	
	if( array_search(Request::get('postType'), $customPostMultiLanguage) !== false ){

		$languages = languages();
		$language_default = language_default();

		$lang = Request::get('language', $language_default['lang_slug']);

		echo '<select style="float: left;height: 34px;" onchange="window.location.href = replaceUrlParam(window.location.href,\'language\',this.value)">';
		foreach ($languages as $l) {
			echo '<option '.($lang === $l['lang_slug']? 'selected="selected"':'').' value="'.$l['lang_slug'].'">'.$l['lang_name'].'</option>';
		}
		echo '</select>';

		$postDetailType = Request::get('postDetailType');
		$id = Request::get('post');

		if( $language = Request::get('language') ){

			return ['select'=>[Vn4Model::$id,'title','language'], 'callback'=>function($q) use ($language) { $q->where('language',$language); }];

		}else{

			if( array_search($postDetailType, $customPostMultiLanguage) !== false ){

				if( $postDetailType && $id && $post = get_post($postDetailType, $id) ){

					if( $post->language ){
						return ['select'=>[Vn4Model::$id,'title','language'], 'callback'=>function($q) use ($post) { $q->where('language',$post->language); }];
					}
				}

			}
			
			return ['select'=>[Vn4Model::$id,'title','language'], 'callback'=>function($q) use ($lang) { $q->where('language',$lang); }];

		}



	}
});

//Change Result of get category relationship one to many
add_action('getCategory',function() use ($plugin) {

	$r = request();

	$type = $r->get('type');
	$route_type = $r->get('route_type');

	$admin_object = get_admin_object($type);

	$customPostMultiLanguage = $plugin->getMeta('custom-post-types',[]);

	if( array_search($type, $customPostMultiLanguage) !== false && array_search($route_type, $customPostMultiLanguage) !== false ){

		$action = $r->get('action_post');
		$post = $r->get('post');

		$language_default = language_default()['lang_slug'];


		if($action === 'edit' && $post){
			$post = get_post($route_type,$post);
			$language = $post->language;
		}else{

			$language = $r->get('language',$language_default);
		}

		return DB::table($admin_object['table'])->where('language',$language)->orderBy('created_at','asc')->get();

	}
});

/** 
	Add Meta box Languages on create post page
*/
add_meta_box(
	'vn4-languages', function($customPost, $post, $post_type) use ($plugin) {

		$r = request();

		if( $r->get('action_post') === 'copy' ){
			$post = null;
		}

		return view_plugin($plugin,'views.meta-box',[
				'post_type'=>$post_type,
				'customPost'=>$customPost,
				'post'=>$post,
			]);
		return __('Languages').' <div class="dropdown" style="display:inline;"><a href="#" class="dropdown-toggle vn4-btn" data-toggle="dropdown" role="button" aria-expanded="false">English <i class="fa fa-sort-desc"></i></a><ul class="dropdown-menu" role="menu" style="margin-top:8px;" ><li><a href="#" class="only_show_data">Show Data</a></li><li><a href="#" class="create_and_show_data" >Create And Show Data</a></li><li><a href="#" class="only_create_data" >Create Data</a></li></ul></div>';
	},
	function($type, $post, $post_type) use ($plugin){
		return array_search($post_type, $plugin->getMeta('custom-post-types',[])) !== false;
	},
	'right',
	'avn4-multi-lang',
	null,
	function($post, $r){

		$language = $r->get('language_post');

		if( !$language ){
			 $language = language_default()['lang_slug'];
		}
		$post->language = $language;

		$postConnect = $r->get('postConnect',[]);
		$postConnect[$post->language] = ['id'=>$post->id,'title'=>$post->title];
		$listIdPost = [];

		foreach ($postConnect as $key => $p) {
			if( $key !== $post->language && $p['id'] === $post->id ){
				unset($postConnect[$key]);
			}else{
				$listIdPost[$p['id']] = $key;
			}
		}

		$post_update_relationship_language = (new Vn4Model(get_admin_object($post->type)['table']))->whereIn(Vn4Model::$id,array_keys($listIdPost))->get();

		$is_homepage = 0;

		foreach ($post_update_relationship_language as $p) {
			if( $p->is_homepage ){
				$is_homepage = json_decode($p->is_homepage,true);
				break;
			}
		}
		$metaLanguage = ['post'=>$postConnect,'is_homepage'=>$is_homepage];
		
		foreach ($post_update_relationship_language as $key => $p) {
			$p->updateMeta('vn4-multiple-language-post-connect',$metaLanguage);
		}

		$post->updateMeta('vn4-multiple-language-post-connect',$metaLanguage);

		$post->save([],false);
		
		return $post;

	},
	['positions'=>'top','toolbox'=>function() use ($plugin) { return '<li><a data-popup="1"  href="#" data-title="Languages" data-iframe="'.route('admin.plugin.controller',['plugin'=>$plugin->key_word, 'controller'=>'languages','method'=>'languages']).'" ><i class="fa fa-cog"></i></a></li>';  }, 'x_panel_style'=>"z-index:1000;"]
);


add_action('get_post_controller',function($data, $r,$type, $postobj = null ) use ($plugin){

	$custom_post_types = $plugin->getMeta('custom-post-types',[]);

	$admin_object = get_admin_object($type);

	if( array_search($type, $custom_post_types) !== false ){

		$post = $r->get('post');
		$action = $r->get('action_post');

		if( $post && $action && $action !== 'copy' ){

			if( $postobj && $postobj->language ){
				$language = [$postobj->language];
			}else{

				$language = $r->get('language');

				if( !$language ){
					$language = [language_default()['lang_slug'],''];
				}else{
					$list_lang = languages();

					$language = [$list_lang[$language]['lang_slug']];
				}
			}

		}else{

			$language = $r->get('language');

			if( !$language ){
				$language = [language_default()['lang_slug'],''];
			}else{
				$list_lang = languages();
				$language = [$list_lang[$language]['lang_slug']];

				if( $language[0] === language_default()['lang_slug']){
					$language[] = '';
				}
			}

		}

		if( isset($language[1]) ){
			return Vn4Model::table($admin_object['table'])->where('type',$type)->where('status','publish')->where(function($q) use ($language){
				return $q->whereIn('language',$language)->orWhereNull('language');
			})->orderBy('created_at','asc')->take(1000)->get();
		}else{
			return Vn4Model::table($admin_object['table'])->where('type',$type)->where('status','publish')->whereIn('language',$language)->orderBy('created_at','asc')->take(1000)->get();
		}

		return get_posts($type,
			[
				'count'=>1000,
				'callback'=>function($q) use ($language) {
		            return $q->whereIn('language',$language);
		        }
			]);
		
	}
});


add_action('vn4_create_taxonomy',function($data, $table_object, $title, $key, $post) use ($plugin) {

	$admin_object = get_admin_object($key);

	$custome_post_language = $plugin->getMeta('custom-post-types',[]);
 
	if( !is_array($custome_post_language) ){
		$custome_post_language = [];
	}

	if( array_search($key, $custome_post_language) !== false ){

		if( $post->language ){

			$tag = Vn4Model::firstOrAddnew($table_object,['title'=>$title,'language'=>$post->language]);
			$tag->language = $post->language;
			
	    }else{

	    	if( $language = request()->get('language') ){
	    		if( !isset(languages()[$language]) ){
	    			$language = language_default()['lang_slug'];
	    		}
	    	}else{
				$language = language_default()['lang_slug'];
	    	}


			$tag = Vn4Model::firstOrAddnew($table_object,['title'=>$title,'language'=>$language]);
	    	$tag->language = $language;

	    }

	    if( !$tag->exists ){
	        $tag->slug = registerSlug($title, $key);
	        $tag->type = $key;
	        $tag->post_date_gmt = $post->post_date_gmt;
	        $tag->visibility = 'publish';
	        $tag->status = 'publish';
	        $tag->template = '';
	        $tag->author = Auth::id();
	        $tag->status_old = 'publish';
	        $tag->ip = request()->ip();
	        $tag->meta = '';
	        $tag->order = 0;
	    }

		return $tag;

	}
	
});




add_action('get_permalinks',function($data, $type, $slug, $post) {


	if( isset( $post->language ) ){

		$post_connect = $post->getMeta('vn4-multiple-language-post-connect');

		if( isset($post_connect['is_homepage']['route-name']) ){

			$info_route = $post_connect['is_homepage'];

			$language = $post->language;

			if( $info_route['route-name'] === 'index' ){

				return url('/'.$language);
			}

			if( $info_route['route-name'] === 'page' ){

				$pageDetail = $info_route['parameter']['page'];

				$page_slug = get_page_slug( $info_route['parameter']['page'], $pageDetail);

				if( isset($page_slug[$info_route['parameter']['page']][$language]) ){
					return url('/'.$language.'/'.$page_slug[$info_route['parameter']['page']][$language]);
				}

				return url('/'.$language.'/'.$pageDetail);
				
			}

		}

		$slug = get_admin_object($post->type)['slug'];

		$postslug = get_post_type_slug( $slug, $postslug2);

		if( $postslug2 && isset($postslug[$postslug2]) ){
			$slug = $postslug[$postslug2][$post->language];
		} 

		return url('/'.$post->language.'/'.$slug.'/'.$post->slug);

	}else{
		return url('/'.language_default()['lang_slug'].'/'.$type.'/'.$slug);
	}

});
