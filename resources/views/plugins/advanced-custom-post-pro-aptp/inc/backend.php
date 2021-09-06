<?php


add_action('api_save_post_type',function($post){
	
	$request = request();

	$keysMeta = $request->get('aptp_field');


	if( isset($keysMeta[0]) ){

		$metaUpdate = [];
		$meta = $request->get('meta');

		foreach( $keysMeta as $key ){
			$metaUpdate[$key] = isset($meta[ $key ]) ? $meta[ $key ] : '';
		}

		$post->updateMeta($metaUpdate);
	}

	return $post;
});




// Route::any('plugin/advanced-custom-post-pro-aptp/{name}',function($name) use ($plugin) {

// 	$r = request();

// 	return include __DIR__.'/api/'.$name.'.php';
// });



add_action('add_meta_box_left',function($postTypeConfig,$post, $postType) use ($plugin){

	$aptps = (new Vn4Model('ace_custom_fields'))->where('status','publish')->where('related','like','%|'.$postType.'|%')->get();

	$argRuleTemplate = [];

	$template = $post?$post->template:'';
	$theme_name = theme_name();

	if( file_exists(cms_path('resource','views/themes/'.$theme_name.'/inc/advanced-custom-post-pro.php')) ){

		$postTypeCustomFields = include cms_path('resource','views/themes/'.$theme_name.'/inc/advanced-custom-post-pro.php');

		include __DIR__.'/variable.php';

		if( is_array($postTypeCustomFields) ){

			$index = 1;
			foreach($postTypeCustomFields as $k => $dataTemplate){

				if( $k !== $postType ) continue;


				foreach ($dataTemplate as $k2 => $v2) {
					
					if( isset($v2['templates']) ){
						$location_templates = $v2['templates'];

						foreach ($location_templates as $basenameTemplate) {

							$aptp = new stdClass();
							$aptp->id = 'fields_in_code_template_'.$k.($index++).'_'.$basenameTemplate;
							$aptp->title = $v2['title']??'Custom Fields';

							foreach ($v2['fields'] as $key => $value) {
								$field_type = isset($v2['fields'][$key]['view']) ? $v2['fields'][$key]['view']: 'text';

								$v2['fields'][$key][ $field_type ] =  array_merge($fieldTypeAttribute[ $field_type ], $v2['fields'][$key]);

								$v2['fields'][$key]['field_type'] = $field_type ;
								$v2['fields'][$key]['field_name'] = $key;
								$v2['fields'][$key]['field_required'] = 1 ;
								$v2['fields'][$key]['field_instructions'] = '' ;
							}

							$aptp->fields = json_encode($v2['fields']);


							if( $template === $basenameTemplate ){
			    				$show_aptp = 'style="display:block;" data-show="1"';
			    			}else{
			    				$show_aptp = 'style="display:none;" data-show="0"';
			    			}

							echo view_plugin($plugin,'views.post-type',['post'=>$post,'customField'=>$aptp,'postType'=>$postType,'show'=>$show_aptp]);

							$argRuleTemplate[] = ['param' => $postType.'_template','operator' => '==','value' => $basenameTemplate,'id'=>$aptp->id];
						}

					}else{

						$aptp = new stdClass();
						$aptp->id = 'fields_in_code_'.$postType;
						$aptp->title = $v2['title'];

						foreach ($v2['fields'] as $key => $value) {

							$field_type = isset($v2['fields'][$key]['view']) ? $v2['fields'][$key]['view']: 'text';

							$v2['fields'][$key][ $field_type ] =  array_merge($fieldTypeAttribute[ $field_type ], $v2['fields'][$key]);

							$v2['fields'][$key]['field_type'] = $field_type ;
							$v2['fields'][$key]['field_name'] = $key;
							$v2['fields'][$key]['field_required'] = 1 ;
							$v2['fields'][$key]['field_instructions'] = '' ;
						}

						$aptp->fields = json_encode($v2['fields']);

	    				$show_aptp = 'style="display:block;" data-show="1"';
		    			
						echo view_plugin($plugin,'views.post-type',['post'=>$post,'customField'=>$aptp,'postType'=>$postType,'show'=>$show_aptp]);

					}

					

				}
			}
		}
	}
	foreach ($aptps as $aptp) {
		
		$location = json_decode($aptp->location,true);

		$dk = false;

		$index = 1;

		$show_aptp = 'data-show="1"';

		foreach ($location as $group) {

			$dk2 = true;

			foreach ($group as $rule) {
	    		
	    		if( $rule['param'] === 'post-type' ){

	    			if( !(($rule['operator'] === '!=' && $postType != $rule['value']) 
	    				|| ($rule['operator'] === '==' && $postType == $rule['value'])) ){
	    				$dk2 = false;
	    				break;
	    			}
	    			
	    		}elseif(  substr($rule['param'],-3) === '_id' ){
	    			
	    			$paramType = substr($rule['param'],0,-3);
	    			if( $paramType !== $postType ){
	    				$dk2 = false;
	    				break;
	    			}


	    			if( !(( $rule['operator'] === '!=' && ( !$post || $post->id != $rule['value'] ) ) 
	    				|| ($rule['operator'] === '==' && $post && $post->id == $rule['value'])) ){
	    				$dk2 = false;
	    				break;
	    				
	    			}


	    		}else{
	    			$paramType = substr($rule['param'],0,-9);

	    			if( $paramType !== $postType ){
	    				$dk2 = false;
	    				break;
	    			}

	    			if( ($rule['operator'] === '==' && $template === $rule['value']) || ($rule['operator'] === '!=' && $template !== $rule['value']) ){
	    				$show_aptp = 'style="display:block;" data-show="1"';
	    			}else{
	    				$show_aptp = 'style="display:none;" data-show="0"';
	    			}


	    			$argRuleTemplate[] = array_merge($rule,['id'=>$aptp->id]);

	    		}

	    	}

	    	if($dk2){
	    		$dk = true;
	    	}

    		$index++;
		}

		if( $dk ){
			echo view_plugin($plugin,'views.post-type',['post'=>$post,'customField'=>$aptp,'postType'=>$postType,'show'=>$show_aptp]);
		}
	}

	echo '<div class="list_customfield_post"></div>';

	add_action('vn4_footer',function() use ($argRuleTemplate) {
	?>
		<script>
			$(window).load(function(){
				window.___list_customfield_post = [];

				window.__rule_template = JSON.parse('<?php echo json_encode($argRuleTemplate); ?>');

				window.show_customfield_post = function(id){
					$('.list_customfield_post').append($(___list_customfield_post[id]).show());
				}

				window.hide_customfield_post = function(id){
					if( $('.customfield-post[data-id='+id+']').length > 0 ){
						___list_customfield_post[id] = $('.customfield-post[data-id='+id+']').detach();
					}
					
				}

				$('.customfield-post').each(function(index, el) {
					if( !$(el).data('show') ){
						___list_customfield_post[$(el).data('id')] = $(el).detach();
					}
				});
				
				function eventChangeTemplate(){
					var $value = $('#attributes_template').val(), list_show = [],list_hide = [];

					for (var i = 0; i < __rule_template.length; i++) {
						
						if( (__rule_template[i].operator == '==' && $value == __rule_template[i].value) || (__rule_template[i].operator == '!=' && $value != __rule_template[i].value) ){
							list_show.push( __rule_template[i].id );
						}else{
							list_hide.push( __rule_template[i].id );
						}
					}
					for (var i = 0; i < list_hide.length; i++) {
						hide_customfield_post(list_hide[i]);
					}

					for (var i = 0; i < list_show.length; i++) {
						show_customfield_post(list_show[i]);
					}

				}

				eventChangeTemplate();

				

				$(document).on('change','#attributes_template',function(event) {

					eventChangeTemplate();

				});

				
			});
		</script>
	<?php
	},'add_meta_box_left',true);
});

add_action('saved_post',function($post){

	$field = Request::get('aptp_field', null );

	if( $field ){


		$fieldValue = Request::only($field);
		
		$fieldValueFesh = [];

		foreach ($field as $key) {
			if( isset($fieldValue[$key]) ){
				$fieldValueFesh[$key] = $fieldValue[$key];
			}else{
				$fieldValueFesh[$key] = '';
			}
		}
		return $post->updateMeta($fieldValueFesh);

	}

	return $post;
});

add_route('/plugin/ace-'.str_slug($plugin->title).'/update-fields','admin.aptp.update','backend',function($r) use ($plugin){
	return include __DIR__.'/route-update-fields.php';
});

