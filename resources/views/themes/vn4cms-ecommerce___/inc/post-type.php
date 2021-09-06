<?php

add_filter('object_admin_all',function($post_type){

	$post_type['ecommerce_product']['fields'] +=[
		'description'=>[
			'title'=>'Description',
			'view'=>'textarea',
		]
	]; 

	return $post_type;
});