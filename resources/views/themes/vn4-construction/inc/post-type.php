<?php

register_post_type(function($list_post_type){

	$add_object = [];

	$add_object[] = [
		'blog_category',
    	1,
		[
		    'table'=>'blog_category',
		    'title'=>'Blog Category',
		    'slug'=>'blog-category',
		    'cache'=>function($post){
		    	cache_tag('blog-category - '.$post->id ,null,'clear');
		    },
		    'fields'=>[
		        'title'=>[
		            'title'=>__('Title'),
		            'view'=>'text',
		            'required'=>true,
		        ],
		        'slug' => [
		            'title'=>'Slug',
		            'view' =>'slug',
		            'key_slug'=> 'title',
		            'type' =>'text',
		        ],
		        'parent' => [
		            'title'=>__('Parent'),
		            'view' =>'relationship_onetomany',
		            'show_data'=>false,
		            'object'=>'blog_category',

		        ],
		        'description' => [
		            'title'=>__('Description'),
		            'show_data'=>false,
		            'view' =>'textarea',
		        ],
				'blog_post'=>[
					'title'=>'Post',
					'view'=>'relationship_onetomany_show',
					'object'=>'blog_post',
					'field'=>'category',
		            'show_data'=>false,
				],
		    ],
			'tabs'=>[
				'general'=>['title'=>'General','fields'=>['title','slug','description']],
				'realtionship'=>['title'=>'Realtionship','fields'=>['parent','blog_post']],
			],
		]
	];


	$add_object[] = [
		'blog_tag',
    	2,
		[
		    'table'=>'blog_tag',
		    'title'=> 'Blog Tag',
		    'slug'=>'blog-tag',
		    'fields'=>[
		        'title'=>[
		            'title'=>__('Title'),
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
		            'title'=>__('Description'),
		            'show_data'=>false,
		            'view' =>'textarea',
		        ],
				'blog_post'=>[
					'title'=>'Post',
					'view'=>'relationship_manytomany_show',
					'object'=>'blog_post',
					'field'=>'tag',
		            'show_data'=>false,
				],
		    ],
		]
	];



	$add_object[] = [
		'blog_post',
    	3,
		[
		    'table'=>'blog_post',
		    'title'=> 'Blog Post',
		    'button_new_toolbar'=>true,
		    'slug'=>'blog',
		    'icon'=>'fa fa-pencil',
		    'cache'=>function($post){
		    	cache_tag('blog-category - '.$post->category ,null,'clear');
		    },
		    'fields'=>[
		        'title'=>[
		            'title'=>__('Title'),
		            'view'=>'text',
		            'required'=>true,
		            'note'=>'note 1'
		        ],
		        'slug' => [
		            'title'=>__('Slug'),
		            'view' =>'slug',
		            'key_slug'=>'title',
		            'type' => 'text',
		            'show_data'=>false,
		            'note'=>'note 2'
		        ],
		        'description' => [
		            'title'=>__('Description'),
		            'view' =>'textarea',
		            'show_data'=>false,
		            'note'=>'note 3'
		        ],
		        'content' => [
		            'title'=>__('Content'),
		            'view' =>'editor',
		            'show_data'=>false,
		            'required'=>true,
		            'note'=>'note 4'
				],
				'content2' => [
		            'title'=>__('Content 2'),
		            'view' =>'editor',
		            'show_data'=>false,
		            'required'=>true,
		            'note'=>'note 444'
		        ],
		        'category' => [
		            'title'=>__('Category'),
		            'view' =>'relationship_onetomany',
		            'object'=>'blog_category',
		            'show_data'=>true,
		            'advance'=>'right',
		            'note'=>'relationship_onetomany'
		        ],
		        'category2' => [
		            'title'=>__('Post Language'),
		            'view' =>'relationship_onetoone',
		            'object'=>'blog_post',
		            'show_data'=>false,
		            'advance'=>'right',
		            'note'=>'relationship_onetoone'
		        ],
		        'tag' => [
		            'title'=>__('Tag'),
		            'view' =>'relationship_manytomany',
		            'object'=>'blog_tag',
		            'type'=>'many_record',
		            'advance'=>'right',
		            'note'=>'note 6',
		            'show_data'=>false,
		        ],
		        'image' => [
		            'title'=>__('Featured Image'),
		            'view' =>'image',
		            'required'=>true,
		            'show_data'=>false,
		            'advance'=>'right',
		            'thumbnail'=>[
		            	'listing'=>['width'=>770,'height'=>385],
		            	'widget'=>['width'=>80,'height'=>80],
		            ],
		            'note'=>'note 7'
		        ],
				'image2' => [
		            'title'=>__('Featured Image 2'),
		            'view' =>'image',
		            'required'=>true,
		            'show_data'=>false,
		            'advance'=>'right',
		            'thumbnail'=>[
		            	'listing'=>['width'=>770,'height'=>385],
		            	'widget'=>['width'=>80,'height'=>80],
		            ],
		            'note'=>'note 7'
		        ],
		        'asset_file' => [
		        	'title'=>'Asset File 1',
		        	'view'=>'asset-file',
		            'note'=>'note 8',
		            'show_data'=>false,
		            'advance'=>'right',
		        ],
		        'checkbox'=>[
		        	'title'=>'Checkbox 2',
		        	'view'=>'checkbox',
		        	'list_option'=>['demo1'=>['title'=>'Demo 1'],'demo2'=>['title'=>'Demo 2']],
		            'note'=>'note 9',
		            'show_data'=>false,
		        ],
		        'color'=>[
		        	'title'=>'Color 3',
		        	'view'=>'color',
		            'note'=>'note 10',
		            'show_data'=>false,
		        ],
		        'date_picker'=>[
		        	'title'=>'Date Picker 4',
		        	'view'=>'date_picker',
		            'note'=>'note 11',
		            'show_data'=>false,
		        ],
		        'email'=>[
		        	'title'=>'Email 5',
		        	'view'=>'email',
		            'note'=>'note 12',
		            'show_data'=>false,
		        ],
		        'flexible'=>[
		        	'title'=>'Flexible 6',
		        	'view'=>'flexible',
		        	'templates'=>[
		        		'template1'=>[
		        			'title'=>'Template 1',
		        			'items'=>['title'=>['title'=>'Title 1'],'description'=>['title'=>'Description 1','view'=>'textarea']]
		        		],
		        		'template2'=>[
		        			'title'=>'Template 2',
		        			'layout'=>'block',
		        			'items'=>[
		        				'title'=>['title'=>'Title 2','view'=>'text'],
		        				'description'=>['title'=>'Description 2','view'=>'textarea'],
		        				'repeater'=>[
						        	'title'=>'Repeater Children',
						        	'view'=>'repeater',
						        	'sub_fields'=>[
						        		'title'=>['title'=>'Title','view'=>'text'],
						        		'description'=>['title'=>'Description','view'=>'textarea'],
						        		'radio'=>[
								        	'title'=>'Radio 15',
								        	'view'=>'radio',
								        	'list_option'=>['demo1'=>['title'=>'Demo 1'],'demo2'=>['title'=>'Demo 2']],
								            'note'=>'note 22',
								        ],
								        'category' => [
								            'title'=>__('Category'),
								            'view' =>'relationship_onetomany',
								            'object'=>'blog_category',
								            'advance'=>'right',
								            'note'=>'relationship_onetomany'
								        ],
						        	],
						            'note'=>'note 23',
						        ]
	        				]
		        		],
		        	],
		            'note'=>'note 13',
		            'show_data'=>false,
				],
				'repeater'=>[
		        	'title'=>'Repeater 16',
		        	'view'=>'repeater',
		        	'sub_fields'=>[
		        		'title'=>['title'=>'Title'],
		        		'description'=>['title'=>'Description','view'=>'textarea'],
		        		'radio'=>[
				        	'title'=>'Radio 15',
				        	'view'=>'radio',
				        	'list_option'=>['demo1'=>['title'=>'Demo 1'],'demo2'=>['title'=>'Demo 2']],
				            'note'=>'note 22',
				        ],
				        'repeater'=>[
				        	'title'=>'Repeater Children',
				        	'view'=>'repeater',
				        	'sub_fields'=>[
				        		'title'=>['title'=>'Title'],
				        		'description'=>['title'=>'Description','view'=>'textarea'],
				        		'radio'=>[
						        	'title'=>'Radio 15',
						        	'view'=>'radio',
						        	'list_option'=>['demo1'=>['title'=>'Demo 1'],'demo2'=>['title'=>'Demo 2']],
						            'note'=>'note 22',
						        ],
						        'category' => [
						            'title'=>__('Category'),
						            'view' =>'relationship_onetomany',
						            'object'=>'blog_category',
						            'advance'=>'right',
						            'note'=>'relationship_onetomany'
						        ],
				        	],
				            'note'=>'note 23',
				        ]
		        	],
		        	'layout'=>'block',
		            'note'=>'note 23',
		            'show_data'=>false,
		        ],
		        'group'=>[
		        	'title'=>'Group 7',
		        	'view'=>'group',
		        	'sub_fields'=>[
		        		'title'=>['title'=>'Title'],
		        		'description'=>['title'=>'Description','view'=>'textarea'],
		        		'radio'=>[
				        	'title'=>'Radio 15',
				        	'view'=>'radio',
				        	'list_option'=>['demo1'=>['title'=>'Demo 1'],'demo2'=>['title'=>'Demo 2']],
				            'note'=>'note 22',
				        ],
				        'repeater'=>[
				        	'title'=>'Repeater Children',
				        	'view'=>'repeater',
				        	'sub_fields'=>[
				        		'title'=>['title'=>'Title'],
				        		'description'=>['title'=>'Description','view'=>'textarea'],
				        		'radio'=>[
						        	'title'=>'Radio 15',
						        	'view'=>'radio',
						        	'list_option'=>['demo1'=>['title'=>'Demo 1'],'demo2'=>['title'=>'Demo 2']],
						            'note'=>'note 22',
						        ],
						        'category' => [
						            'title'=>__('Category'),
						            'view' =>'relationship_onetomany',
						            'object'=>'blog_category',
						            'advance'=>'right',
						            'note'=>'relationship_onetomany'
						        ],
				        	],
				            'note'=>'note 23',
						],
						'flexible'=>[
							'title'=>'Flexible 6',
							'view'=>'flexible',
							'templates'=>[
								'template1'=>[
									'title'=>'Template 1',
									'items'=>['title'=>['title'=>'Title 1'],'description'=>['title'=>'Description 1','view'=>'textarea']]
								],
								'template2'=>[
									'title'=>'Template 2',
									'layout'=>'block',
									'items'=>[
										'title'=>['title'=>'Title 2','view'=>'text'],
										'description'=>['title'=>'Description 2','view'=>'textarea'],
										'repeater'=>[
											'title'=>'Repeater Children',
											'view'=>'repeater',
											'sub_fields'=>[
												'title'=>['title'=>'Title','view'=>'text'],
												'description'=>['title'=>'Description','view'=>'textarea'],
												'radio'=>[
													'title'=>'Radio 15',
													'view'=>'radio',
													'list_option'=>['demo1'=>['title'=>'Demo 1'],'demo2'=>['title'=>'Demo 2']],
													'note'=>'note 22',
												],
												'category' => [
													'title'=>__('Category'),
													'view' =>'relationship_onetomany',
													'object'=>'blog_category',
													'advance'=>'right',
													'note'=>'relationship_onetomany'
												],
											],
											'note'=>'note 23',
										]
									]
								],
							],
							'note'=>'note 13',
						],
		        	],
		        	'layout'=>'block',
		            'note'=>'note 14',
		            'show_data'=>false,
		        ],
		        'group_type'=>[
		        	'title'=>'Group Type 8',
		        	'view'=>'group-type',
		        	'list_group'=>['Group 1'=>['category'],'Group 2'=>['tag']],
		            'note'=>'note 15',
		            'show_data'=>false,
		        ],
		        'input'=>[
		        	'title'=>'Input 9',
		        	'view'=>'input',
		        	'type'=>'number',
		            'note'=>'note 16',
		            'show_data'=>false,
		        ],
		        'json'=>[
		        	'title'=>'Json 10',
		        	'view'=>'json',
		            'note'=>'note 17',
		            'show_data'=>false,
		        ],
		        'link'=>[
		        	'title'=>'Link 11',
		        	'view'=>'link',
		            'note'=>'note 18',
		            'show_data'=>false,
		        ],
		        'menu'=>[
		        	'title'=>'Menu 12',
		        	'view'=>'menu',
		            'note'=>'note 19',
		            'show_data'=>false,
		        ],
		        'number'=>[
		        	'title'=>'Number 13',
		        	'view'=>'number',
		            'note'=>'note 20',
		            'show_data'=>false,
		        ],
		        'password2'=>[
		        	'title'=>'Password 14',
		        	'view'=>'password',
		            'note'=>'note 21',
		            'show_data'=>false,
		        ],
		        'radio'=>[
		        	'title'=>'Radio 15',
		        	'view'=>'radio',
		        	'list_option'=>['demo1'=>['title'=>'Demo 1'],'demo2'=>['title'=>'Demo 2']],
		            'note'=>'note 22',
		            'show_data'=>false,
		        ],
		        'select'=>[
		        	'title'=>'select 17',
		        	'view'=>'select',
		        	'list_option'=>['demo1'=>['title'=>'Demo 1'],'demo2'=>['title'=>'Demo 2']],
		            'note'=>'note 24',
		            'show_data'=>false,
		        ],
		        'true_false'=>[
		        	'title'=>'True/False 18',
		        	'view'=>'true_false',
		            'note'=>'note 25',
		            'show_data'=>false,
		        ]
		    ],
			'tabs'=>[
				'general'=>['title'=>'General','fields'=>['title','slug','description','email']],
				'security'=>['title'=>'Security','fields'=>[ 'password2']],
				'template'=>['title'=>'Template','fields'=>['flexible', 'repeater', 'group','group_type']],
				'detail'=>['title'=>'Detail','fields'=>['content','content2']],
				'realtionship'=>['title'=>'Realtionship','fields'=>['category','category2', 'tag','menu']],
				'media'=>['title'=>'Media','fields'=>['image','image2', 'asset_file']],
				'other'=>['title'=>'Other','fields'=>['number', 'radio','select', 'true_false', 'link', 'json','input','color']],
			],
		]
	];
	

	$add_object[] = [
			'project_category',
	    	4,
			[
		    'table'=>vn4_tbpf().'project_category',
		    'slug'=>'project-category',
		    'title'=> __t('Project Category'),
		    'fields'=>[
		        'title'=>[
		            'title'=>__t('Title'),
		            'view'=>'text',
		            'required'=>true,
		        ],
		        'slug' => [
		            'title'=>__t('Slug'),
		            'view' =>'slug',
		            'key_slug'=>'title',
		            'type' => 'text',
		            'show_data'=>false,
		        ],
		        'description' => [
		            'title'=>__t('Description'),
		            'view' =>'textarea',
		            'show_data'=>false,
		        ],
			]
		]
	];


	$add_object[] = [
			'project_post',
	    	5,
			[
		    'table'=>vn4_tbpf().'project',
		    'title'=> __t('Project'),
		    'slug'=>'project',
		    'icon'=>'fa fa-briefcase',
		    'button_new_toolbar'=>true,
		    'fields'=>[
		        'title'=>[
		            'title'=>__t('Title'),
		            'view'=>'text',
		            'required'=>true,
		        ],
		        'slug' => [
		            'title'=>__t('Slug'),
		            'view' =>'slug',
		            'key_slug'=>'title',
		            'type' => 'text',
		            'show_data'=>false,
		        ],
		        'description' => [
		            'title'=>__t('Description'),
		            'view' =>'textarea',
		            'show_data'=>false,
		        ],
		        'content' => [
		            'title'=>__t('Content'),
		            'view' =>'editor',
		            'show_data'=>false,
		            'required'=>true,
		        ],
		         'category' => [
		            'title'=>__t('Category'),
		            'view' =>'relationship_onetomany',
		            'show_data'=>true,
		            'object'=>'project_category',
		            'advance'=>'right',
		        ],
		        'banner'=>[
		        	'title'=>__t('Banner'),
		            'view' =>'image',
		            'required'=>true,
		            'show_data'=>false,
		            'advance'=>'right',
		            'width'=>1920,
		            'min_height'=>600,
		        ],
		        'image' => [
		            'title'=>__t('Featured Image'),
		            'view' =>'image',
		            'required'=>true,
		            'show_data'=>false,
		            'advance'=>'right',
		            'thumbnail'=>[
		            	'listing'=>['width'=>370,'height'=>390]
		            ]
		    	],
			]
		]
	];


	$add_object[] = [
			'service',
	    	6,
			[
		    'table'=>vn4_tbpf().'service',
		    'title'=> __('Service'),
		    'slug'=>'service',
		    'icon'=>'fa fa-book',
		    'fields'=>[
		        'title'=>[
		            'title'=>__t('Title'),
		            'view'=>'text',
		            'required'=>true,
		        ],
		        'slug' => [
		            'title'=>__t('Slug'),
		            'view' =>'slug',
		            'key_slug'=>'title',
		            'type' => 'text',
		            'show_data'=>false,
		        ],
		        'description' => [
		            'title'=>__t('Description'),
		            'view' =>'textarea',
		            'show_data'=>false,
		        ],
		        'content'=>[
		        	'title'=>'Content',
		        	'view'=>'editor',
		            'show_data'=>false,
		        ],
		        'image' => [
		            'title'=>__t('Featured Image'),
		            'view' =>'image',
		            'required'=>true,
		            'show_data'=>false,
		            'advance'=>'right',
		            'thumbnail'=>[
		            	'listing'=>['width'=>370,'height'=>268]
		            ]
		    	],
			]
		]
	];

	$add_object[] = [
			'team',
	    	7,
			[
		    'table'=>vn4_tbpf().'team',
		    'title'=> __('Team'),
		    'slug'=>'team',
		    'icon'=>'fa fa-users',
		    'button_new_toolbar'=>true,
		    'fields'=>[
		        'title'=>[
		            'title'=>__t('Name'),
		            'view'=>'text',
		            'required'=>true,
		        ],
				'position'=>['title'=>'Position'],
				'image'=>['title'=>'Image','advance'=>'right','view'=>'image','thumbnail'=>['listing'=>['width'=>370,'height'=>400]]],
				'contact'=>[
					'title'=>'Contact',
					'view'=>'repeater',
					'sub_fields'=>[
						'title'=>['title'=>'Title'],
						'icon'=>['title'=>'Icon'],
						'link'=>['title'=>'Link'],
					]
				]
			]
		]
	];

	$add_object[] = [
			'newsletters',
	    	8,
			[
		    'table'=>vn4_tbpf().'newsletters',
		    'title'=> __('Newsletters'),
		    'icon'=>'fa fa-newspaper-o',
		    'fields'=>[
		        'title'=>[
		            'title'=>__('Email'),
		            'view'=>'text',
		            'required'=>true,
		            'validation'=>[
		            	'required'=>__('Email là trường bắt buộc'),
		            	'email'=>__('Không đúng định dạng email')
		            ]
		        ],
			]
		]
	];

	$add_object[] = [
			'contact',
	    	9,
			[
		    'table'=>vn4_tbpf().'contact',
		    'title'=> __('Contact'),
		    'icon'=>'fa fa-envelope',
		    'fields'=>[
		        'title'=>[
		            'title'=>__('Name'),
		            'view'=>'text',
		            'required'=>true,
		            'validation'=>[
		            	'required'=>__('Name là trường bắt buộc'),
		            	'max:255'=>__('Name tối đa 255 ký tự'),
		            ]
		        ],
		        'email'=>[
		            'title'=>__('Email'),
		            'view'=>'email',
		            'validation'=>[
		            	'required'=>__('Email là trường bắt buộc'),
		            	'email'=>__('Không đúng định dạng email'),
		            ]
		        ],
		        'subject'=>[
		            'title'=>__('Subject'),
		            'view'=>'text',
		            'validation'=>[
		            	'required'=>__('Subject là trường bắt buộc'),
		            ]
		        ],
		        'message'=>[
		            'title'=>__('Message'),
		            'view'=>'editor',
		            'validation'=>[
		            	'required'=>__('Message là trường bắt buộc'),
		            	'max:500'=>__('Message tối đa 500 ký tự'),
		            	'min:8'=>__('Message tối thiểu 8 ký tự'),
		            ]
		        ],
			]
		]
	];

	return $add_object;

});