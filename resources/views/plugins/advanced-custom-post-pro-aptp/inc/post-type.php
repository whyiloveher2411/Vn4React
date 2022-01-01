<?php

register_post_type(function($list_post_type){

	$add_object['ace_custom_fields'] = [
		'table'=>'ace_custom_fields',
		'title'=> __('Custom Fields'),
		'way_show'=>'title',
		'public_view'=>false,
		'layout'=>'show_data',
		'route_update'=>'admin.aptp.update',
		'is_post_system'=>true,
		'fields'=>[
			'title'=>[
				'title'=>__('Title'),
				'view'=>'input',
				'type'=>'text',
				'required'=>true,
			],
			'location'=>[
				'title'=>'location',
				'view'=>'editor',
				'show_data'=>false,
			],
			'fields'=>[
				'title'=>'fields',
				'view'=>'editor',
				'show_data'=>false,
			],
			'number_field'=>[
				'title'=>'Fields',
				'view'=>'input',
			],
			'related'=>[
				'title'=>'Related',
				'view'=>'input',
				'show_data'=>false,
			]
		],
    ];

    return $add_object;
});
