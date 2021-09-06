<?php

return [
	
	'index'=>function($r, $plugin){

				
		if( $r->isMethod('GET') ){
			return view_plugin($plugin,'view.setting',['plugin'=>$plugin]);
		}

		if( $r->isMethod('POST') ){

			if( env('EXPERIENCE_MODE') ){
			    return experience_mode();
			}

			$form = $r->get('form');

			if( $form === 'webmaster_tools' ){

				function get_string_between($string, $start, $end){
				    $string = ' ' . $string;
				    $ini = strpos($string, $start);
				    if ($ini == 0) return '';
				    $ini += strlen($start);
				    $len = strpos($string, $end, $ini) - $ini;
				    return substr($string, $ini, $len);
				}


				$webmaster_tools_google = $r->get('webmaster-tools');
				$webmaster_tools = [];

				if( isset($webmaster_tools_google['google']['tag']) ){

					$google = get_string_between($webmaster_tools_google['google']['tag'],'content="','"')?get_string_between($webmaster_tools_google['google']['tag'],'content="','"'):$webmaster_tools_google['google']['tag'];

					$webmaster_tools['google']['tag'] = $google;

				}

				if( isset($webmaster_tools_google['google']['file']) ){
					$file = json_decode($webmaster_tools_google['google']['file'],true);

					if( isset($file['link']) ){
						$file_info = pathinfo(cms_path('public',$file['link']));
						copy(cms_path('public',$file['link']), cms_path('public',$file_info['basename']));
						$webmaster_tools['google']['file'] = $webmaster_tools_google['google']['file'];
					}else{
						$file_veri = $plugin->getMeta('webmaster-tools');

						if( isset($file_veri['google']['file']) ){

							$file = json_decode($file_veri['google']['file'],true);

							if( isset($file['link']) ){
								$file_info = pathinfo(cms_path('public',$file['link']));

								try {
									unlink(cms_path('public',$file_info['basename']));
								} catch (Exception $e) {
									
								}
							}
						}
					}
				}

				$plugin->updateMeta('webmaster-tools',$webmaster_tools);


				vn4_create_session_message( __('Success'), __p('Update Webmaster Tools Success.',$plugin->key_word), 'success' , true);
				return redirect()->back();
			}

			if( $form === 'sitemap' ){

				if( $r->get('active_sitemap') ){
					$plugin->updateMeta('active_sitemap', '["active"]');
					$plugin->updateMeta('post-type-sitemap',$r->get('post-type-sitemap',[]));
				}else{
					$plugin->updateMeta('active_sitemap', '');
				}

				vn4_create_session_message( __('Success'), __p('Update Sitemap Setting Success.',$plugin->key_word), 'success' , true);

				return redirect()->back();

			}

		}

		return redirect()->route('admin.plugin.controller',['plugin'=>$plugin->key_word,'controller'=>'setting','method'=>'index']);


	}
	
];