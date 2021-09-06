<?php

$r = request();

$post = get_post($r->get('type'), $r->get('id',0));

$aptps = (new Vn4Model('ace_custom_fields'))->where('status','publish')->where('related','like','%|'.$r->get('type').'|%')->get();

$argRuleTemplate = [];

$template = $post?$post->template:'';
$theme_name = theme_name();

$template = [];

if( file_exists(cms_path('resource','views/themes/'.$theme_name.'/inc/advanced-custom-post-pro.php')) ){
	$postTypeCustomFields = include cms_path('resource','views/themes/'.$theme_name.'/inc/advanced-custom-post-pro.php');

	if( isset($postTypeCustomFields[ $r->get('type') ]) ){
		$template = $postTypeCustomFields[ $r->get('type') ];
	}
}


return ['template'=>$template];
