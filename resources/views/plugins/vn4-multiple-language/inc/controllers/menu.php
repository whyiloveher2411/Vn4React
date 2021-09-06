<?php

return [
	'copy-menu'=>function($r, $plugin){

		if( env('EXPERIENCE_MODE') ){
		    return experience_mode();
		}
		
		$id = $r->get('id');
		$lang = $r->get('language');

		$menu = (new Vn4Model(vn4_tbpf().'menu'))->find($id);

		$json = json_decode($menu->json,true);


		$customePostType = $plugin->getMeta('custom-post-types',[]);

		function convert_language_menu($json,$lang, $customePostType){
			$json2 = [];

			foreach ($json as $key => $value) {
		    	
		    	if( isset($value['children']) ){
					$value['children'] = convert_language_menu($value['children'],$lang,$customePostType);
				}

		    	switch ($value['posttype']) {
		    		case 'custom links':
		    			$json2[] = $value;
		    			break;
		    		case 'page-static':
		    			$json2[] = $value;
		    			break;
		            case 'route-static':
		                $json2[] = $value;
		                break;
		    		case 'page-theme':
		    			$json2[] = $value;
		    			break;
		    		case 'menu-items':
		    			$json2[] = $value;
		    			break;
		    		default:

		                if( array_search($value['posttype'], $customePostType) !== false ) {

		        			if( $admin_object = get_admin_object($value['posttype']) ){

		        				$post = get_post($value['posttype'],$value['id']);
		        				if( $post->language !== $lang ){

		        					$listPostConnect = $post->getMeta('vn4-multiple-language-post-connect');
		    						$listPostConnect = isset($listPostConnect['post'])? $listPostConnect['post'] : [];
		    						if( isset($listPostConnect[$lang]) ){
		    							$post2 = get_post($value['posttype'],$listPostConnect[$lang]['id']);

		    							if( $post2 ){
		    								$value2 = $value;
		    								$value2['id'] = $post2->id;
		    								$value2['slug'] = $post2->slug;
		    								$value2['label'] = $post2->title;
		    								$json2[] = $value2;


		    							}else{
		                                    echo '<h1>Can\'t get post id </h1>';
		        							dd($post);
		        							$json2[] = $value;
		    							}
		    						}else{
		        						$value2 = $value;
		                                $value2['id'] = $post->id;
		                                $value2['slug'] = $post->slug;
		                                $value2['label'] = $post->title.'(Not isset Post connect)';
		                                $json2[] = $value2;
		    						}
		        				}else{
		                            echo '<h1>Not define language of post</h1>';
		        					dd($post);
		        					$json2[] = $value;
		        				}
		        			}else{
		                        dd($value);
		        				dd(1);
		        				$json2[] = $value;
		        			}

		                }else{
		                    $json2[] = $value;
		                }

		    			break;
		    	}


		    }

		    return $json2;
		}

		$newMenu = new Vn4Model(vn4_tbpf().'menu');

		$newMenu->title = $menu->title.' (Copy to '.$lang.') ';
		$newMenu->json = json_encode(convert_language_menu($json,$lang,$customePostType));
		$newMenu->status = 1;
		$newMenu->type = 'menu_item';
		$newMenu->theme = theme_name();
		$newMenu->save();

		return redirect()->route('admin.page',['page'=>'appearance-menu','id'=>$newMenu->id]);

	}
];