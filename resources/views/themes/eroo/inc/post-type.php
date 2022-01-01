<?php

register_post_type(function($list_post_type){

	$add_object = [];

	$add_object['eroo_service'] = [
		'table'=>'eroo_service',
		'title'=>'Service',
		'slug'=>'Service',
		'fields'=>[
			'title'=>[
				'title'=>__('Title'),
				'view'=>'text',
				'required'=>true,
			],
		],
	];

	$add_object['eroo_staff'] = [
		'table'=>'eroo_staff',
		'title'=>'Staff',
		'slug'=>'staff',
		'fields'=>[
			'title'=>[
				'title'=>__('Title'),
				'view'=>'text',
				'required'=>true,
			],

		],
	];

	$add_object['eroo_project_category'] = [
		'table'=>'eroo_project_category',
		'title'=>'Project Category',
		'slug'=>'project-category',
		'fields'=>[
			'title'=>[
				'title'=>__('Title'),
				'view'=>'text',
				'required'=>true,
			],
			'slug' => [
				'title'=>__('Slug'),
				'view' =>'slug',
				'key_slug'=> 'title',
				'show_data'=>false,
			],
			'eroo_projects'=>[
				'title'=>'Projects',
				'view'=>'relationship_onetomany_show',
				'field'=>'category',
				'object'=>'eroo_project',
				'show_data'=>false,
			]
		],
	];
	$add_object['eroo_project_tag'] = [
		'table'=>'eroo_project_tag',
		'title'=>'Project Tag',
		'slug'=>'project-tag',
		'fields'=>[
			'title'=>[
				'title'=>__('Title'),
				'view'=>'text',
				'required'=>true,
			],
			'slug' => [
				'title'=>__('Slug'),
				'view' =>'slug',
				'key_slug'=> 'title',
				'show_data'=>false,
			],
			'eroo_projects'=>[
				'title'=>'Projects',
				'view'=>'relationship_manytomany_show',
				'field'=>'tags',
				'object'=>'eroo_project',
				'show_data'=>false,
			]
		],
	];

	$add_object['eroo_project'] = [
		'table'=>'eroo_project',
		'title'=>'Project',
		'slug'=>'project',
		'fields'=>[
			'title'=>[
				'title'=>__('Title'),
				'view'=>'text',
				'required'=>true,
			],
			'slug' => [
				'title'=>__('Slug'),
				'view' =>'slug',
				'key_slug'=> 'title',
				'show_data'=>false,
			],
			'banner'=>[
				'title'=>'Banner','view'=>'image',
				'advance'=>'right',
				'show_data'=>false,
			],
			'thubnail'=>[
				'title'=>'Thubnail','view'=>'image',
				'advance'=>'right',
				'show_data'=>false,
			],
			'category'=>[
				'title'=>'Category',
				'view'=>'relationship_onetomany',
				'object'=>'eroo_project_category',
				'advance'=>'right',
			],
			'tags'=>[
				'title'=>'Tags',
				'view'=>'relationship_manytomany',
				'object'=>'eroo_project_tag',
				'advance'=>'right',
				'show_data'=>false,
			],
			'content'=>[
				'title'=>'Content',
				'view'=>'editor',
				'show_data'=>false,
			],
			// 'project_detail'=>[
			// 	'title'=>'Project Detail',
			// 	'view'=>'relationship_onetoone_show',
			// 	'object'=>'eroo_project_detail',
			// 	'field'=>'project',
			// 	'show_data'=>false,
			// ],

			// 'assetFile'=>[
			// 	'title'=>'asset File','view'=>'asset-file',
			// ],
			// 'image0'=>[
			// 	'title'=>'Image','view'=>'image',
			// 	'multiple'=>true,
			// ],
			// 'image'=>[
			// 	'title'=>'Image','view'=>'image',
			// 	'multiple'=>true,
			// 	'size'=>[
			// 		'width'=>900,
			// 		'minWidth'=>100,
			// 		'maxWidth'=>1920,
			// 		'height'=>1350,
			// 		'minHeight'=>100,
			// 		'maxHeight'=>1920,
			// 		'ratio'=>'900:1350',
			// 	],
			// 	'thumbnail'=>[
			// 		'small'=>['width'=>320, 'height'=>200],
			// 		'medium'=>['maxWidth'=>500, 'maxHeight'=>500],
			// 		'large'=>['maxWidth'=>1440, 'maxHeight'=>500],
			// 	]
			// ],
			// 'image2'=>[
			// 	'title'=>'Image','view'=>'image',
			// 	'size'=>[
			// 		'width'=>900,
			// 		'minWidth'=>100,
			// 		'maxWidth'=>1920,
			// 		'height'=>1350,
			// 		'minHeight'=>100,
			// 		'maxHeight'=>1920,
			// 		'ratio'=>'900:1350',
			// 	],
			// 	'thumbnail'=>[
			// 		'small'=>['width'=>320, 'height'=>200],
			// 		'medium'=>['maxWidth'=>500, 'maxHeight'=>500],
			// 		'large'=>['maxWidth'=>1440, 'maxHeight'=>500],
			// 	]
			// ],
			// 'image3'=>[
			// 	'title'=>'Image 3','view'=>'image',
			// 	'thumbnail'=>[
			// 		'small'=>['width'=>320, 'height'=>200],
			// 		'medium'=>['maxWidth'=>500, 'maxHeight'=>500],
			// 		'large'=>['maxWidth'=>1440, 'maxHeight'=>500],
			// 	]
			// ],
			// 'image4'=>[
			// 	'title'=>'Image 4','view'=>'image',
			// 	'size'=>[
			// 		'width'=>400,
			// 		'minWidth'=>100,
			// 		'maxWidth'=>1920,
			// 		'height'=>600,
			// 		'minHeight'=>100,
			// 		'maxHeight'=>1920,
			// 		'ratio'=>'400:600',
			// 	],
			// ],
			// 'image5'=>[
			// 	'title'=>'Image 5','view'=>'image',
			// ],

			// 'assetFile'=>[
			// 	'title'=>'asset File','view'=>'asset-file',
			// ],
		],
	];

	$add_object['eroo_project_detail'] = [
		'table'=>'eroo_project_detail',
		'title'=>'Project Detail',
		'slug'=>'project-detail',
		'fields'=>[
			'title'=>[
				'title'=>'title 1',
				'view'=>'text',
				'required'=>true,
			],
			'title2'=>[
				'title'=>'title 2',
				'view'=>'text',
				'required'=>true,
			],
			'title3'=>[
				'title'=>'title 3',
				'view'=>'text',
				'required'=>true,
			],
			'title4'=>[
				'title'=>'title 4',
				'view'=>'text',
				'required'=>true,
			],
			'title5'=>[
				'title'=>'title 5',
				'view'=>'text',
				'required'=>true,
			],
			'title6'=>[
				'title'=>'title 6',
				'view'=>'text',
				'required'=>true,
			],
			'project'=>[
				'title'=>'Project',
				'view'=>'relationship_onetoone',
				'object'=>'eroo_project',
				'advance'=>'right',
			],
		],
	];
	

	$add_object['eroo_testimonial'] = [
		'table'=>'eroo_testimonial',
		'title'=>'Testimonial',
		'slug'=>'testimonial',
		'fields'=>[
			'title'=>[
				'title'=>__('Title'),
				'view'=>'text',
				'required'=>true,
			],
		],
	];


	$add_object['eroo_blog_category'] = [
		'table'=>'eroo_blog_category',
		'title'=>'Blog Category',
		'slug'=>'blog-category',
		'fields'=>[
			'title'=>[
				'title'=>__('Title'),
				'view'=>'text',
				'required'=>true,
			],
			'slug' => [
				'title'=>__('Slug'),
				'view' =>'slug',
				'key_slug'=> 'title',
				'show_data'=>false,
			],
			'eroo_blogs'=>[
				'title'=>'Blogs',
				'view'=>'relationship_onetomany_show',
				'field'=>'category',
				'object'=>'eroo_blog',
				'show_data'=>false,
			]
		],
	];
	$add_object['eroo_blog_tag'] = [
		'table'=>'eroo_blog_tag',
		'title'=>'Blog Tag',
		'slug'=>'blog-tag',
		'fields'=>[
			'title'=>[
				'title'=>__('Title'),
				'view'=>'text',
				'required'=>true,
			],
			'slug' => [
				'title'=>__('Slug'),
				'view' =>'slug',
				'key_slug'=> 'title',
				'show_data'=>false,
			],
			'eroo_blogs'=>[
				'title'=>'Blogs',
				'view'=>'relationship_manytomany_show',
				'field'=>'tags',
				'object'=>'eroo_blog',
				'show_data'=>false,
			]
		],
	];

	$add_object['eroo_blog'] = [
		'table'=>'eroo_blog',
		'title'=>'Blog',
		'slug'=>'blog',
		'fields'=>[
			'title'=>[
				'title'=>__('Title'),
				'view'=>'text',
				'required'=>true,
			],
			'slug' => [
				'title'=>__('Slug'),
				'view' =>'slug',
				'key_slug'=> 'title',
				'show_data'=>false,
			],
			'description'=>[
				'title'=>'Description',
				'view'=>'textarea',
				'required'=>true,
				'show_data'=>false,
			],
			'content'=>[
				'title'=>'Content',
				'view'=>'editor',
				'show_data'=>false,
			],
			'banner'=>[
				'title'=>'Banner','view'=>'image',
				'advance'=>'right',
				'show_data'=>false,
			],
			'thubnail'=>[
				'title'=>'Thubnail','view'=>'image',
				'advance'=>'right',
				'show_data'=>false,
			],
			'category'=>[
				'title'=>'Category',
				'view'=>'relationship_onetomany',
				'object'=>'eroo_blog_category',
				'advance'=>'right',
			],
			'tags'=>[
				'title'=>'Tags',
				'view'=>'relationship_manytomany',
				'object'=>'eroo_blog_tag',
				'advance'=>'right',
				'show_data'=>false,
			],
		],
	];

	

	return $add_object;

});