<?php


add_filter('object_admin_all',function($admin_object){

	if( isset( $admin_object['ecommerce_product_attribute_value']['fields']['content'] ) ){
		$admin_object['ecommerce_product_attribute_value']['fields']['content'] = [
			'title'=>'Content',
			'view'=>'textarea'
		];
	}

	return $admin_object;
});