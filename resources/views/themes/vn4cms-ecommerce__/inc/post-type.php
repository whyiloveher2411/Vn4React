<?php

add_filter('object_admin_all',function($post_type){

	if( isset($post_type['ecommerce_product']) ){

		$post_type['ecommerce_product']['fields'] +=[
			'description'=>[
				'title'=>'Description',
				'view'=>'editor',
			]
		]; 

	}
	return $post_type;
});