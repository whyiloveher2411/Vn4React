<?php

return [
	'languages'=>function($r, $plugin){

		if( $r->isMethod('GET') ){

			$languages = languages();
			include __DIR__.'/../lang_flags.php';

			if( $r->get('action') === 'default-lang' && $lang_default = $r->get('lang') ){

				$not_set = true;

				foreach ($languages as $key => $value) {
					if( $value['lang_slug'] === $lang_default ){
						$languages[$key]['is_default'] = true;
						$not_set = false;
					}else{
						$languages[$key]['is_default'] = false;
					}
				}

				if( $not_set ){
					$languages[key($languages)]['is_default'] = true;
				}

				$plugin->updateMeta('vn4-languages', $languages);

				vn4_create_session_message( __('Success'), __p('Set Language Default Success.',$plugin->key_word), 'success' , true);
				return redirect()->route('admin.plugin.controller',['plugin'=>$plugin->key_word,'controller'=>'languages','medthod'=>'languages']);
			}

			if( $r->get('action') === 'delete' && $lang_delete = $r->get('lang') ){
				
				if( $languages[$lang_delete]['is_default'] ){
					foreach ($languages as $key => $value) {
						if( $key !== $lang_delete ){
							$languages[$key]['is_default'] = true;
							break;
						}
					}
				}

				if( isset($languages[$lang_delete]) ){
					unset($languages[$lang_delete]);

					$index = 1;
					foreach ($languages as $k => $v) {
						$languages[$k]['order'] = $index++;
					}
					vn4_create_session_message( __('Success'), __p('Delete Language Success.',$plugin->key_word), 'success' , true);
					$plugin->updateMeta('vn4-languages', $languages);
				}

				return redirect()->route('admin.plugin.controller',['plugin'=>$plugin->key_word,'controller'=>'languages','medthod'=>'languages']);

			}


			return view_plugin($plugin, 'views.setting.languages',['languages'=>$arg_languages,'flags'=>$flags]);
		}

		if( $r->isMethod('POST') ){

			if( env('EXPERIENCE_MODE') ){
			    return experience_mode();
			}
			
			if( $r->has('add-language') ){

				$lang = languages();

				$language_default = language_default();

				if( !is_array($lang) ) $lang = [];

				$lang_slug = $r->get('lang_slug');

				foreach ($lang as $key => $l) {
					if( $l['lang_slug'] === $lang_slug ){
						unset($lang[$key]);
					}				
				}

				$order = intval($r->get('order'));

				$lang_list = explode(':', $r->get('lang_list'));

				$lang[$r->get('lang_slug')] = ['lang_slug'=>$lang_slug,'lang_locale'=>$r->get('lang_locale'),'lang_name'=>$r->get('lang_name'),'order'=>$order,'flag'=>$r->get('flag'),'country_name'=>$r->get('country_name'),'text_direction'=>$r->get('text_direction'),'is_default'=>false];

				if( count($lang) < 2 ){
					$lang[$r->get('lang_slug')]['is_default'] = true;
				}

				$lang2 = [];

				usort($lang,function($a, $b){
					return $a['order'] >= $b['order'];
				});

				$index = 1;

				foreach ($lang as $value) {
					if( $value['lang_slug'] ){
						$value['order'] = $index++;

						if( $value['lang_slug'] === ($language_default['lang_slug']??App::getLocale()) ) $value['is_default'] = true;
						$lang2[$value['lang_slug']] = $value;
					}
				}

				$plugin->updateMeta('vn4-languages', $lang2);
				vn4_create_session_message( __('Success'), __p('Add Language Success.',$plugin->key_word), 'success' , true);
				return redirect(URL::previous());

			}

		}
	},
	'setting'=>function($r, $plugin){
		if( $r->isMethod('GET') ){
			return view_plugin($plugin, 'views.setting');
		}

		if( $r->isMethod('POST') ){

			$post_type = $r->get('post-type');

			if( !is_array($post_type) ) $post_type = [];

			$plugin->updateMeta('custom-post-types', $post_type);

			include __DIR__.'/../activate.php';

		 	vn4_create_session_message( __('Success'), __('Update setting successful.'), 'success' , true);

			return redirect()->route('admin.plugin.controller',['plugin'=>$plugin->key_word,'controller'=>'languages','medthod'=>'setting']);
		}
	},
	'get-my-lang-backend'=>function($r, $plugin){

		if( $r->isMethod('POST') ){

			$languages = languages();

			$result = [];

			foreach ($languages as $key => $lang) {
				$result[$key] = ['name'=>__($lang['lang_name']),'flag'=>plugin_asset($plugin,'flags/'.$lang['flag'].'.png')];
			}

			return response()->json(['langs'=>$result]);

		}

		return redirect()->route('admin.index');

	},
	'set-my-lang-backend'=>function($r, $plugin){

		if( $r->isMethod('POST') ){

			$lang = explode(':', trim($r->get('lang')));

			Auth::user()->updateMeta([
				'lang'=>end($lang),
				'vn4-lang-config'=>trim($r->get('lang')),
			]);
			
			return response()->json(['reload'=>true]);

		}

		return redirect()->route('admin.index');
		
	},
	'create-connect-post'=>function($r, $plugin ){

		if( $r->isMethod('GET') ){
			return view_plugin($plugin, 'views.create-connect-post',['plugin'=>$plugin]);
		}


		$post_type = $r->get('post_type');

		$post_connect = $r->get('post-connect');

		foreach ($post_connect as $v) {
			unset($v['delete']);

			$posts = get_posts($post_type, ['callback'=>function($q) use ($v) {
				return $q->whereIn(Vn4Model::$id,$v);
			}]);

			$postsTemp = [];
			$is_homepage = 0;
			foreach ($posts as $p) {
				$postsTemp[$p->id] = $p;
				if( $p->is_homepage ){
					$is_homepage = json_decode($p->is_homepage,true);
				}
			}

			foreach ($v as $k => $v2) {

				if( isset($postsTemp[$v2]) ){
					$v[$k] = ['id'=>$v2, 'title'=>$postsTemp[$v2]->title];
				}else{
					unset($v[$k]);
				}
			}


			$metaLanguage = ['post'=>$v,'is_homepage'=>$is_homepage];

			foreach ($metaLanguage['post'] as $lang => $p) {
				$postsTemp[$p['id']]->language = $lang;
				$postsTemp[$p['id']]->save();
				$postsTemp[$p['id']]->updateMeta('vn4-multiple-language-post-connect',$metaLanguage);
			}
		}

	 	vn4_create_session_message( __('Success'), __p('Create Post Connect Success',$plugin->key_word), 'success' , true);
		return redirect()->back();

	}

];