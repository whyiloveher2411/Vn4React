<?php

return [
	'index'=>function($r, $plugin){
		if( $r->isMethod('GET') ){
			return view_plugin($plugin,'view.page_setting',['plugin'=>$plugin]);
		}

		if( env('EXPERIENCE_MODE') ){
		    return experience_mode();
		}

		$theme_name = theme_name();

		if( file_exists(cms_path('resource','views/themes/'.$theme_name.'/page/'.$r->get('file_page').'.blade.php') ) ){

			$file = $r->get('file_page');

			$input = $r->get('plugin_vn4seo');

			$arg = [
				'plugin_vn4seo_google_title',
				'plugin_vn4seo_google_description',
				'plugin_vn4seo_focus_keyword',
				'plugin_vn4seo_facebook_title',
				'plugin_vn4seo_facebook_description',
				'plugin_vn4seo_facebook_image',
				'plugin_vn4seo_twitter_title',
				'plugin_vn4seo_twitter_description',
				'plugin_vn4seo_twitter_image',
				'plugin_vn4seo_canonical_url'
			];

			foreach ($input as $key => $value) {
				if( array_search($key, $arg) !== false && $value && $value !== 'null' ){
					save_theme_options($file.'_page',$key,$value);
				}
			}


			$meta = '<meta name="description" content="'.e(vn4_one_or($input['plugin_vn4seo_google_description'],'##title_head##')).'" />';
			if( isset($input['plugin_vn4seo_canonical_url']) && $input['plugin_vn4seo_canonical_url'] ){
				$meta .= '<link rel="canonical" href="'.$input['plugin_vn4seo_canonical_url'].'" />';
			}
			
			$meta .= '<meta property="og:type" content="article" />';
			$meta .= '<meta property="og:title" content="'.e(vn4_one_or($input['plugin_vn4seo_facebook_title'],'##title_head##')).'" />';
			$meta .= '<meta property="og:description" content="'.e(vn4_one_or($input['plugin_vn4seo_facebook_description'],'##title_head##')).'" />';
			$meta .= '<meta property="og:site_name" content="'.e(setting('general_site_title')).'" />';
			if( $input['plugin_vn4seo_facebook_image'] && $img = get_media($input['plugin_vn4seo_facebook_image']) ){
				$meta .= '<meta property="og:image" content="'.$img.'" />';
			}

			$meta .= '<meta name="twitter:card" content="summary" />';
			$meta .= '<meta name="twitter:title" content="'.e(vn4_one_or($input['plugin_vn4seo_twitter_title'],'##title_head##')).'" />';
			$meta .= '<meta name="twitter:description" content="'.e(vn4_one_or($input['plugin_vn4seo_twitter_description'],'##title_head##')).'" />';
			if( $input['plugin_vn4seo_twitter_image'] && $img = get_media($input['plugin_vn4seo_twitter_image']) ){
				$meta .= '<meta name="twitter:image" content="'.$img.'" />';
			}

			save_theme_options($file.'_page_meta','meta',$meta);
			vn4_create_session_message( __('Success'), __p('Update SEO Setting Success.',$plugin->key_word), 'success' , true);
			return redirect()->back();
		}

		return redirect()->route('admin.plugin.controller',['plugin'=>$plugin->key_word,'controller'=>'page-setting','method'=>'index']);
	}
];