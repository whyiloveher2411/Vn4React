<?php



register_post_type(function($list_post_type){



	$add_object = [];

	$add_object[] = [
		'blog_author',
    	1,
		[
		    'table'=>'blog_author',
		    'title'=>'Author',
		    'slug'=>'author',
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
		            'show_data'=>false,
		        ],
		        'description' => [
		            'title'=>'description',
					'view' =>'textarea',
					'show_data'=>false,
		        ],
		        'thumbnail'=>[
					'title'=>'Thumbnail',
					'view'=>'image',
					'thumbnail'=>[
						'small'=>['title'=>'Small','width'=>50,'height'=>50]
					],
					'advance'=>'right',
		            'show_data'=>false,
				],
		    ],
		]
	];


	$add_object[] = [
		'blog_category',
    	1,
		[
		    'table'=>'blog_category',
		    'title'=>'Category',
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
		'blog_tag',
    	1,
		[
		    'table'=>'blog_tag',
		    'title'=>'Tag',
		    'slug'=>'tag',
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
		'blog_post',
    	1,
		[
		    'table'=>'blog_post',
		    'title'=>'Blog',
		    'slug'=>'blog',
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
				'blog_author'=>[
					'title'=>'Author',
					'view'=>'relationship_onetomany',
					'object'=>'blog_author',
					'type'=>'many_record',
					'advance'=>'right',
				],
				'blog_category'=>[
					'title'=>'Category',
					'view'=>'relationship_onetomany',
					'object'=>'blog_category',
					'advance'=>'right',
					'type'=>'many_record',
				],
				'blog_tag'=>[
					'title'=>'Tag',
					'view'=>'relationship_manytomany',
					'type'=>'many_record',
					'object'=>'blog_tag',
					'advance'=>'right',
					'template'=>function($post){
						return $post->title.': <img src="http://blog.vn4cms.test/admin/images/face_user_default.jpg">';
					}
				],
				'thumbnail'=>[
					'title'=>'Thumbnail',
					'view'=>'image',
					'thumbnail'=>[
						'listting'=>['title'=>'Listting','width'=>280,'height'=>190]
					],
					'advance'=>'right',
		            'show_data'=>false,
				]
		    ],
		]
	];

	return $add_object;

});