<?php

function backend_asset( $file = '' ){

	if( $file === ''){
		return asset('admin/themes/'.$GLOBALS['backend_theme'].'/').'/';
	}
	return asset('admin/themes/'.$GLOBALS['backend_theme'].'/'.$file);

}

function capital_letters($string){
	return ucwords(trim(preg_replace('/(?<!\ )[A-Z]/', ' $0', str_replace(['-','_'], ' ', $string))));
}

function backend_resources($view){
	return __DIR__.'/../resources/views/admin/themes/'.$GLOBALS['backend_theme'].'/'.$view;
}

function setting_save($keyword, $value, $group = null, $isJson = false){
	if( is_string($value) ){
		$value = trim($value);
	}
	if(is_array($value)) $value = json_encode($value);

	if( DB::table( vn4_tbpf().'setting' )->where('key_word',$keyword )->count() ){
		DB::table( vn4_tbpf().'setting' )->where('key_word',$keyword )->update([
			'content' => $value,
			'group'=>$group,
			'is_json'=>$isJson
		]);
	}else{
		DB::table(vn4_tbpf().'setting')->updateOrInsert(['key_word'=>$keyword],
		[
			'content'=>$value,
			'group'=>$group,
			'is_json'=>$isJson
		]);
	}

	Cache::forget('setting');

 	return true;
}

function admin_data_table($type, $parameter = []){
	echo vn4_view(backend_theme('particle.template-table-data'),array_merge( ['type'=>$type], $parameter ) );
}

function get_field($name, $fields, $post = null ){

	$fields['post'] = $post;
	
	if( isset($name['form']) && is_callable($name['form']) ){
		return call_user_func_array($name['form'], [$fields, $post]);
	}

	return vn4_view(backend_theme('particle.input_field.'.$name.'.form'),$fields);

}

function get_valude_field( $name, $value = [] ){

	$key = $value['key'];

	$input[$key] = $value['value'];

	if(  File::exists( $resources = backend_resources('particle/input_field/'.$name.'/post.php') ) ){
        include $resources;
    }

    return $input[$key];
}


function experience_mode(){

	$r = request();

	if( $r->ajax() ){
		return response()->json(['message'=>['content'=>'This is a trial version, you cannot do it','title'=>'Error','icon'=>'fa-times-circle','color'=>'#CA2121']]);
	}

	return redirect()->back();
}


function removeSlug($slug, $type, $id ){
	return Vn4Model::table(vn4_tbpf().'slug')->where('slug',$slug)->where('type',$type)->where('post_id',$id)->delete();
}

/**
	SIDEBAR
*/

function array_insert_after($key, array &$array, $new_key, $new_value) {

	if (array_key_exists($key, $array)) {
		$new = [];
		foreach ($array as $k => $value) {
			$new[$k] = $value;
			if ($k === $key) {
				$new[$new_key] = $new_value;
			}
		}
		return $new;
	}
	return FALSE;
}


function get_setting_object(){

    if ( isset($GLOBALS['get_setting_object']) ){
        return $GLOBALS['get_setting_object'];
    }

    $object = include cms_path('resource').'views/admin/themes/'.$GLOBALS['backend_theme'].'/page/setting/setting.php';
    $GLOBALS['get_setting_object'] = $object;
    return $object;
}


function check_post_layout($post_type, $layout_name){

    $admin_object = get_admin_object($post_type);

    if( isset($admin_object['layout']) ){

        if( (is_string($admin_object['layout']) && $admin_object['layout'] === $layout_name) || (is_array($admin_object['layout']) && array_search($layout_name, $admin_object['layout']) !== false ) ){
            return true;
        }

        return false;

    }

    return true;

}

function add_custom_menu($id,$title, $description,  $view, $form_attr ){

	add_filter('appearance-menu',function($filters) use ($id, $title, $view, $form_attr,  $description) {

		$filters[$id] = ['title'=>$title,'description'=> $description,'view'=>$view,'form_attr'=>$form_attr];

		return $filters;
	});

}

include_once backend_resources('function.php');







