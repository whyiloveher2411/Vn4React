<?php

return [
	'create'=>function($r){

		if( !check_permission('plugin_view') ){
			vn4_create_session_message( __('Error'), __('Sorry, you are not allowed to access this page'), 'error' , true );
            return redirect()->route('admin.index');
		}

		if( !$r->has('iframe') ){
			return redirect()->route('admin.page',['page'=>'plugin']);
		}

		if( $r->isMethod('GET') ){
	        return vn4_view(backend_theme('particle.create_plugin'));
		}
		if( $r->isMethod('POST') ){
			if( env('EXPERIENCE_MODE') ){
		        return experience_mode();
		    }

			$name = str_slug($r->get('name',false));

			if( !$name ){
				vn4_create_session_message( __('Fail'), 'Please enter the plugin name', 'fail', true );
				return redirect()->back();
			}

			$description = $r->get('description','');
			$author = $r->get('author','');
			$author_url = $r->get('author_url','');


			$content_json = [
				'name' => $r->get('name',false),
				'description' => $description,
				'author' => $author,
				'author_url' => $author_url,
				'version' => '1.0.0',
			];

			if( !File::exists( cms_path('resource').'views/plugins/'.$name) ) {
				$success = File::copyDirectory( cms_path('resource').'views/default/plugin-struct', cms_path('resource').'views/plugins/'.$name);

				file_put_contents(  cms_path('resource').'views/plugins/'.$name.'/info.json', json_encode($content_json, JSON_PRETTY_PRINT) );


				if (!file_exists( $public_folder_theme = cms_path().'plugins/'.$name )) {
				    mkdir( $public_folder_theme, 0777, true);
				}

				$img = json_decode($r->get('image'));

				if( isset($img->link) ){

					if( $img->type_link === 'local' ){

						$img = cms_path().trim(str_replace(URL::to('/'), '', $img->link),'/');
					}else{
						$img = $img->link;
					}

				}

				if( $img ){
					copy($img, cms_path('resource').'views/plugins/'.$name.'/public/plugin.png');
					copy($img, cms_path().'plugins/'.$name.'/plugin.png');
				}


				vn4_create_session_message( __('Success'), 'Create the plugin successfully', 'success', true );
				return redirect()->back();

			}else{
				vn4_create_session_message( __('Fail'), 'Plugin directory name already exists, please choose another one', 'fail', true );
				return redirect()->back();
			}
		}
	}
];