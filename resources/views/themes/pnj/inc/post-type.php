<?php

register_post_type(function($list_post_type){

	$add_object = [];

	$add_object[] = [
		'pnj_category',
    	1,
		[
		    'table'=>'pnj_category',
		    'title'=>'Category',
		    'slug'=>'category',
		    'fields'=>[
		        'title'=>[
		            'title'=>'Name',
		            'view'=>'text',
		            'required'=>true,
		        ],
		        'slug' => [
		            'title'=>'Slug',
		            'view' =>'slug',
		            'key_slug'=> 'title',
		            'type' =>'text',
		        ],
				'description' => [
		            'title'=>'Mô tả',
		            'show_data'=>false,
		            'view' =>'textarea',
				],
				'featured'=>[
					'title'=>'Featured Image',
					'view'=>'image',
					'advance'=>'right',
					'thumbnail'=>[
						'555x750'=>['title'=>'Thubnail 1','width'=>555,'height'=>750],
						'440x600'=>['title'=>'Thubnail 1','width'=>440,'height'=>600],
					],
		            'show_data'=>false,
				],
		    ],
		]
	];


	$add_object[] = [
		'pnj_topic',
    	1,
		[
		    'table'=>'pnj_topic',
		    'title'=>'Topic',
		    'slug'=>'topic',
		    'fields'=>[
		        'title'=>[
		            'title'=>'Name',
		            'view'=>'text',
		            'required'=>true,
		        ],
		        'slug' => [
		            'title'=>'Slug',
		            'view' =>'slug',
		            'key_slug'=> 'title',
		            'type' =>'text',
		        ],
				'description' => [
		            'title'=>'Mô tả',
		            'show_data'=>false,
		            'view' =>'textarea',
				],
		    ],
		]
	];



	$add_object[] = [
		'pnj_post',
    	1,
		[
		    'table'=>'pnj_post',
		    'title'=>'Post',
		    'slug'=>'post',
		    'fields'=>[
		        'title'=>[
		            'title'=>'Name',
		            'view'=>'text',
		            'required'=>true,
		        ],
		        'slug' => [
		            'title'=>'Slug',
		            'view' =>'slug',
		            'key_slug'=> 'title',
		            'type' =>'text',
		        ],
				'description' => [
		            'title'=>'Mô tả',
		            'show_data'=>false,
		            'view' =>'textarea',
				],
				'content'=>[
					'title'=>'Content',
					'view'=>'editor',
					'show_data'=>false,
				],
				'pnj_category'=>[
					'title'=>'Category',
					'view'=>'relationship_onetomany',
					'object'=>'pnj_category',
					'advance'=>'right',
				],
				'pnj_topic'=>[
					'title'=>'Topic',
					'view'=>'relationship_manytomany',
					'object'=>'pnj_topic',
					'advance'=>'right',
				],
				'featured'=>[
					'title'=>'Featured Image',
					'view'=>'image',
					'advance'=>'right',
		            'show_data'=>false,
				],		
		    ],
		]
	];

	return $add_object;

});