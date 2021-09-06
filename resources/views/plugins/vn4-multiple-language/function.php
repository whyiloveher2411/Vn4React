<?php

$GLOBALS['languages'] = $plugin->getMeta('vn4-languages',[]);

foreach ($GLOBALS['languages'] as $key => $value) {
	if( $value['is_default'] ){
		$GLOBALS['lang_default'] = $value;
	}
}

if( !isset($GLOBALS['lang_default']) ) $GLOBALS['lang_default'] = reset($GLOBALS['languages']);

$GLOBALS['plugin_languages'] = $plugin;

function languages(){
	return $GLOBALS['languages'];
}

$languages = languages();

function get_flag_language($lang){
	return plugin_asset($GLOBALS['plugin_languages'], 'flags/'.$lang['flag'].'.png');
}

function language_default(){
	return $GLOBALS['lang_default'];
}


function get_page_slug(&$keyPage = null){

	if( isset($GLOBALS['get_page_slug']) ){
		$keyPage = $GLOBALS['get_page_slug']['keypage'];
		return $GLOBALS['get_page_slug']['list_page_slug'];
	}

	$register_page_slug = apply_filter('list_page_slug');

	$languages = languages();

	$page_current = (isset($GLOBALS['route_current']->parameters['page']) )? $GLOBALS['route_current']->parameters['page']: null;

	foreach ($register_page_slug as $key => $value) {

		foreach ($languages as $key2 => $value2) {

			if( !isset($value[$value2['lang_slug']]) ){
				$register_page_slug[$key][$value2['lang_slug']] = $key;
			}

			if( $register_page_slug[$key][$value2['lang_slug']] === $page_current ){

				$keyPage = ['lang'=>$value2['lang_slug'],'slug'=>$page_current,'key_page'=>$key];

			}

		}
	}

	$GLOBALS['get_page_slug'] = ['keypage'=>$keyPage,'list_page_slug'=>$register_page_slug];

	return $register_page_slug;

}


function get_post_type_slug($post_type = null, &$post_type_match = null ){

	if( isset($GLOBALS['custom_post_slug2']) ){
		return $GLOBALS['custom_post_slug2'];
	}

	$list_custom_post_slug = apply_filter('list_custom_post_slug');

	$languages = languages();

	foreach ($list_custom_post_slug as $key => $value) {

		foreach ($languages as $key2 => $value2) {

			if( !isset($value[$value2['lang_slug']]) ){
				$list_custom_post_slug[$key][$value2['lang_slug']] = $key;
			}

			if( $post_type === $list_custom_post_slug[$key][$value2['lang_slug']] ){
				$post_type_match = $key;
			}

		}
	}

	$GLOBALS['custom_post_slug2'] = $list_custom_post_slug;
	return $list_custom_post_slug;
}


if( is_admin() ){
	
		include __DIR__.'/inc/backend.php';
}else{

	if($languages){
		include __DIR__.'/inc/frontend.php';
	}
}
