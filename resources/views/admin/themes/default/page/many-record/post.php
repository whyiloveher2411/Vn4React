<?php

$admin_object = get_admin_object($r->get('postDetailType'));

$post_type = $r->post('post_type');

$field = $r->get('postDetailField');

$input_name = $r->get('input_name');

$posts = $r->get('posts');

$posts = get_posts($post_type,['callback'=>function($q) use ($posts){
	$q->whereIn('id',$posts)->orderByRaw('FIELD(id, '.implode(',', $posts).')');
}]);

$columns = $r->get('columns');

$result = '';

$template = $r->get('template');


if( $template ){

	foreach ($posts as $key => $value) {
		$result .= '<div class="vn4-btn margin-2dot5"><input type="hidden" name="'.$input_name.'" value="'.$value->id.'" >'.vn4_view($template,['post'=>$value]).' <i class="fa fa-times remove-item-relationship"></i></div>';
	}

}else{


	if( isset($admin_object['fields'][$field]['template']) ){
		foreach ($posts as $key => $value) {
			$result .= '<div class="vn4-btn margin-2dot5"><input type="hidden" name="'.$input_name.'" value="'.$value->id.'" >'.$admin_object['fields'][$field]['template']($value).' <i class="fa fa-times remove-item-relationship"></i></div>';
		}
	}else{

		if( isset($columns[0]) ){

			
			// dd($template);
			foreach ($posts as $key => $value) {

				$result .= '<div class="vn4-btn margin-2dot5"><input type="hidden" name="'.$input_name.'" value="'.$value->id.'" >';
				$showHtmlPost = [];

				foreach ($columns as $v) {
					$showHtmlPost[] = $value->{$v};
				}

				$result .= join(' - ', $showHtmlPost).' <i class="fa fa-times remove-item-relationship"></i></div>';

			}

		}else{
			// dd($template);
			foreach ($posts as $key => $value) {
				$result .= '<div class="vn4-btn margin-2dot5"><input type="hidden" name="'.$input_name.'" value="'.$value->id.'" >'.$value->title.' <i class="fa fa-times remove-item-relationship"></i></div>';
			}
		}
	}
}


return response()->json(['html'=>$result]);


// if( $admin_object)