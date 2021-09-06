<?php

register_post_type(function($list_post_type){

	$add_object[] = [
        'ace_custom_fields',
        2,
        [
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
		    'row_actions'=>function( $post, $action) {
				if( isset($action['edit']) ){
			    	$action['edit'] = '<a class="" action="edit" href="'.route('admin.aptp.update',['post'=>$post->id,'action_post'=>'edit']).'">Edit</a>';
				}
				unset($action['detail']);
				unset($action['quick-edit']);
				unset($action['copy']);
				return $action;
			},
        ]
    ];

    return $add_object;
});
