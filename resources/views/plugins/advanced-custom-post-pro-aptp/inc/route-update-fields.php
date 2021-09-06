<?php

if( $r->isMethod('GET') ){
	return view_plugin($plugin,'views.custom-fields');
}

if( $r->isMethod('POST') ){

	if( env('EXPERIENCE_MODE') ){
	    return experience_mode();
	}

	$action = $r->get('action','get-field');

	if( $action === 'get-value-rule' && $r->ajax() ){

		$type = $r->get('ruleType');
		if( $type === 'template' ){
			$typePost = $r->get('typePost');

			$result = [['id'=>'default','title'=>'Default']];

			if( !file_exists( cms_path('resource','views/themes/'.theme_name().'/post-type/'.$typePost) ) ){
				return response()->json(['data'=>$result]);
			}

			$file_page = File::allFiles(cms_path('resource','views/themes/'.theme_name().'/post-type/'.$typePost));

			sort($file_page);
			
			foreach($file_page as $page){

	              $name = explode('/', $page->getFilename());

	              $name = substr(end($name), 0, -10);

	              $file_content = File::get($page->getRealPath());

	              $tokens = token_get_all($file_content);

	              $comment_first = ucwords(preg_replace('/-/', ' ', str_slug($name)));

	              foreach($tokens as $token) {
	                  if($token[0] == T_COMMENT || $token[0] == T_DOC_COMMENT) {
                      		$comment_first = $token[1];
                      		break;
	                  }
	              }

	              $v = basename($page,'.blade.php');

	              $result[] = ['id'=>$v,'title'=>__t(trim(preg_replace('/[\/\*\r\n]/', '', $comment_first)))];
	       }

			return response()->json(['data'=>$result]);

		}elseif( $type === 'post' ){
			$typePost = $r->get('typePost');

			$admin_object = get_admin_object($typePost);
			$posts = Vn4Model::table($admin_object['table'])->limit(10000)->get([Vn4Model::$id,'title']);

			$result = [];
			foreach($posts as $p){
            	$result[] = ['id'=>$p->id,'title'=>$p->title];
            }

			return response()->json(['data'=>$result]);

		}else{
			$result = [];
			$get_admin_object = get_admin_object();
			foreach($get_admin_object as $k => $v){
	            if( !isset($v['is_post_system']) || !$v['is_post_system']){
	            	$result[] = ['id'=>$k,'title'=>$v['title']];
	            }
            }

			return response()->json(['data'=>$result]);
		}
	}

	if( $action === 'get-field' && $r->ajax() ){

		include __DIR__.'/variable.php';
		
		return view_plugin($plugin,'views.field-type.'.$r->get('field-type'),array_merge($fieldTypeAttribute[$r->get('field-type')],['id_field'=>$r->get('field-key')]));
	}

 		$post_type = 'ace_custom_fields';

	    $get_admin_object = get_admin_object();

	    $postTypeConfig = $get_admin_object[$post_type];

	    $id = $r->get('post', false);

	    $action_post =	$r->get('action_post','add');

	    $input = $r->only(['title','location','fields','status']);

	    $input['location'] = isset($input['location'])?$input['location']:[];
	    $input['fields'] = isset($input['fields'])?$input['fields']:[];
	    $input['type'] = $post_type;


	    if( $id ){
	    	$postDetail =  Vn4Model::firstOrAddnew($postTypeConfig['table'], [Vn4Model::$id =>  $id]);
	    }else{
	    	$postDetail =  Vn4Model::createPost($post_type, []);
	    }

	    $postRelated = [];

	    foreach ($input['location'] as  $group) {

	    	foreach ($group as $rule) {
	    		
	    		if( $rule['param'] === 'post-type' ){

	    			if( $rule['operator'] === '!=' ){

	    				$get_admin_object = get_admin_object();

	    				foreach($get_admin_object as $k => $v){
				            if( !isset($v['is_post_system']) || !$v['is_post_system']){
				            	$postRelated[$k] = 1;
				            }
			            }

	    			}else{
	    				$postRelated[ $rule['value']] = 1;
	    			}
	    			
	    		}elseif(  substr($rule['param'],-3) === Vn4Model::$id ){
	    			$postRelated[substr($rule['param'],0,-3)] = 1;
	    		}else{
	    			$postRelated[substr($rule['param'],0,-9)] = 1;

	    		}

	    	}
	    }
	    $postRelated = array_keys($postRelated);

	    $postRelated = '|'.implode('|',$postRelated).'|';

	    $input['location'] = json_encode($input['location']);
		$input['number_field'] = count($input['fields']);	
		$input['related'] = $postRelated;
		$count = count($input['fields']);
		$input_field = [];
		

		$keys = $r->get('field-key',[]);

		$fields = $r->get('fields');

		function getFileds($fieldsData){

			$data = isset($fieldsData[$fieldsData['field_type']])?$fieldsData[$fieldsData['field_type']]:[];

			$result = [
				'title'=>$fieldsData['title'],
	    		'field_name'=>$fieldsData['field_name'],
	    		'view'=>$fieldsData['field_type'],
	    		'field_type_title'=>$fieldsData['field_type_title'],
	    		'field_type'=>$fieldsData['field_type'],
	    		'field_instructions'=>$fieldsData['field_instructions'],
	    		'field_required'=>isset($fieldsData['field_required'])?$fieldsData['field_required']:0,
	    		$fieldsData['field_type'] => $data,
    		];

			switch ($fieldsData['field_type']) {
				case 'repeater':
					$sub_fields = [];
					// dd($data);
					foreach ($data['sub_fields']['field-key'] as $key) {
						$key = explode('[', $key);
		    			$key = end($key);
		    			$sub_fields[$data['sub_fields'][$key]['field_name']] = getFileds($data['sub_fields'][$key]);
					}
					$result[$fieldsData['field_type']]['sub_fields'] = $sub_fields;
					$result['sub_fields'] = $sub_fields;
					$result['button_label'] = $fieldsData['repeater']['button_label'];
					break;
				case 'group':
					$sub_fields = [];
					foreach ($data['sub_fields']['field-key'] as $key) {
						$key = explode('[', $key);
		    			$key = end($key);
		    			$sub_fields[$data['sub_fields'][$key]['field_name']] = getFileds($data['sub_fields'][$key]);
					}
					$result[$fieldsData['field_type']]['sub_fields'] = $sub_fields;
					$result['sub_fields'] = $sub_fields;
					break;
				case 'flexible':

					$templates = [];

					foreach ($data['index_templates'] as $key) {

						$title = $data['templates'][$key]['title'];
						$name = $data['templates'][$key]['name'];
						$layout = $data['templates'][$key]['layout'];

						unset($data['templates'][$key]['title']);
						unset($data['templates'][$key]['name']);
						unset($data['templates'][$key]['layout']);

						$items = [];

						foreach ($data['templates'][$key] as $item) {
							$items[$item['field_name']] = getFileds($item);
						}

						$templates[$name] = ['title'=>$title,'name'=>$name,'layout'=>$layout,'items'=>$items];
					}
					$result[$fieldsData['field_type']]['templates'] = $templates;
					unset($result[$fieldsData['field_type']]['index_templates']);

					break;
				default:
					# code...
					break;
			}
			if( !isset($fieldsData['field_required']) ) $fieldsData['field_required'] = '1';
			
			return $result;

		}
	    foreach ( $keys as $key ) {

	    	if(isset($fields[$key]) ){
	    		$input_field[$fields[$key]['field_name']] = getFileds($fields[$key]);
	    	}

	    }	
	    $input['fields'] = json_encode($input_field);
		    
	    $postDetail->fillDynamic($input);

	    $postDetail->save();

	    return redirect()->route('admin.aptp.update',['post'=>$postDetail->id]);
}