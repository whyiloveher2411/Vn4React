<?php

return [
	
	'get-template'=>function($r,$plugin){

		$postType = $r->get('type');
		$post = get_post($postType, $r->get('post'));

		$aptps = (new Vn4Model('ace_custom_fields'))->where('status','publish')->where('related','like','%|'.$postType.'|%')->get();

		$argRuleTemplate = [];

		$template = $post?$post->template:'';
		$theme_name = theme_name();

		$html = '';

		if( file_exists(cms_path('resource','views/themes/'.$theme_name.'/inc/advanced-custom-post-pro.php')) ){

			$postTypeCustomFields = include cms_path('resource','views/themes/'.$theme_name.'/inc/advanced-custom-post-pro.php');

			include __DIR__.'/../variable.php';

			if( is_array($postTypeCustomFields) ){

				$index = 1;
				foreach($postTypeCustomFields as $k => $dataTemplate){

					$dataLocation = explode('.', $k);

					if( $dataLocation[0]  !== $postType ) continue;

					if( isset($dataLocation[1]) ) $location_templates = [$dataLocation[1]];

					if( isset($dataTemplate['templates']) ){
						$location_templates = $dataTemplate['templates'];
					}

					foreach ($location_templates as $basenameTemplate) {

						$aptp = new stdClass();
						$aptp->id = 'fields_in_code_template_'.$dataLocation[0].($index++).'_'.$basenameTemplate;
						$aptp->title = $dataTemplate['title'];

						foreach ($dataTemplate['fields'] as $key => $value) {
							$field_type = isset($dataTemplate['fields'][$key]['view']) ? $dataTemplate['fields'][$key]['view']: 'text';

							$dataTemplate['fields'][$key][ $field_type ] =  array_merge($fieldTypeAttribute[ $field_type ], $dataTemplate['fields'][$key]);

							$dataTemplate['fields'][$key]['field_type'] = $field_type ;
							$dataTemplate['fields'][$key]['field_name'] = $key;
							$dataTemplate['fields'][$key]['field_required'] = 1 ;
							$dataTemplate['fields'][$key]['field_instructions'] = '' ;
						}

						$aptp->fields = json_encode($dataTemplate['fields']);


						if( $template === $basenameTemplate ){
		    				$show_aptp = 'style="display:block;" data-show="1"';
		    			}else{
		    				$show_aptp = 'style="display:none;" data-show="0"';
		    			}

						$html .= view_plugin($plugin,'views.post-type',['post'=>$post,'customField'=>$aptp,'postType'=>$postType,'show'=>$show_aptp]);

						$argRuleTemplate[] = ['param' => $postType.'_template','operator' => '==','value' => $basenameTemplate,'id'=>$aptp->id];
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
				$html .= view_plugin($plugin,'views.post-type',['post'=>$post,'customField'=>$aptp,'postType'=>$postType,'show'=>$show_aptp]);
			}
		}


		ob_start();
		
		do_action('vn4_footer');

		$footer = ob_get_clean();
		ob_flush();


		return ['html'=>$html,'footer'=>$footer,'rule'=>$argRuleTemplate];

	}

];