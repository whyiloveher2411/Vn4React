<?php

return [
	'create'=>function($r){

		if( !check_permission('appearance-theme_view') ){
			vn4_create_session_message( __('Error'), __('Sorry, you are not allowed to access this page'), 'error' , true );
            return redirect()->route('admin.index');
		}

		if( !$r->has('iframe') ){
			return redirect()->route('admin.page',['page'=>'appearance-theme']);
		}
		
		if( $r->isMethod('GET') ){
	        return vn4_view(backend_theme('particle.create_theme'));
		}
		if( $r->isMethod('POST') ){

			if( env('EXPERIENCE_MODE') ){
				return experience_mode();
			}

			$theme_name = str_slug($r->get('theme_name',false));

			if( !$theme_name ){
				vn4_create_session_message( __('Fail'), 'Please enter theme name', 'fail', true );
				return redirect()->back();
			}

			$description = $r->get('description','');
			$author = $r->get('author','');
			$author_url = $r->get('author_url','');
			$tags = $r->get('tags','');


			$content_json = [
				'name' => $r->get('theme_name',false),
				'description' => $description,
				'author' => $author,
				'author_url' => $author_url,
				'version' => '1.0.0',
				'tags'=>$tags
			];
			if( !File::exists( cms_path('resource').'views/themes/'.str_slug($theme_name)) ) {

				$success = File::copyDirectory( cms_path('resource').'views/default/theme-struct', cms_path('resource').'views/themes/'.$theme_name);

				file_put_contents(  cms_path('resource').'views/themes/'.$theme_name.'/info.json', json_encode($content_json, JSON_PRETTY_PRINT) );

				if (!file_exists( $public_folder_theme = cms_path().'themes/'.$theme_name )) {
				    mkdir( $public_folder_theme, 0777, true);
				}

				$img = json_decode($r->get('screenshot'));

				if( isset($img->link) ){

					if( $img->type_link === 'local' ){
						$img = cms_path().$img->link;
					}else{
						$img = $img->link;
					}

				}

				if( $img ){
					copy($img, cms_path('resource').'views/themes/'.$theme_name.'/public/screenshot.png');
					copy($img, cms_path().'themes/'.$theme_name.'/screenshot.png');
				}

				vn4_create_session_message( __('Success'), 'Create successful theme', 'success', true );
				return redirect()->back();

			}else{
				vn4_create_session_message( __('Fail'), 'Theme already exists, please choose another theme name', 'fail', true );
				return redirect()->back();
			}

		}
	}
];