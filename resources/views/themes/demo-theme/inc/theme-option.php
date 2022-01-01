<?php

add_filter('theme_options',function($filter){

	$filter['theme-option'] = [
		'title'=>'Theme option demo',
		'fields'=>[
			'title'=>['title'=>'Title','view'=>'text'],
			'description'=>['title'=>'Description','view'=>'textarea'],
		]
	];

	return $filter;
});
