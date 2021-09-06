<?php

$list_sidebar = [];

$list_sidebar2 = do_action('register_sidebar',$list_sidebar);

if( $list_sidebar2 ) $list_sidebar = $list_sidebar2;


$list_widgets = use_module('widget');

$theme_name = theme_name();

foreach ($list_sidebar as $key => $value) {

	$sidebarDetail = Vn4Model::table(vn4_tbpf().'widget')->where('sidebar_id',$key)->where('theme',$theme_name)->first();
	if( $sidebarDetail ){

		$list_sidebar[$key]['post'] = json_decode($sidebarDetail->content);

	}
}

return [
	'widgets'=>$list_widgets,
	'sidebars'=>$list_sidebar
];
// $theme_name = theme_name();


