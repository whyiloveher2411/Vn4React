<?php
return [
	
	'page'=> [

		[
			'templates'=>['homepage'],
			'title'=>'Section Homepage',
			'fields'=>[
				'section'=>[
					'title'=>'Section',
					'view'=>'flexible',
					'templates'=>[
						'slider'=>[
							'title'=>'Slider',
							'layout'=>'block',
							'items'=>[
								'slider'=>[
									'title'=>'Slider',
									'view'=>'repeater',
									'sub_fields'=>[
										'title-top'=>[
											'title'=>'Title Top'
										],
										'line-1'=>[
											'title'=>'Line 1',
										],
										'line-2'=>[
											'title'=>'Line 2',
										],
										'title-bottom'=>[
											'title'=>'Title Bottom'
										],
										'background'=>[
											'title'=>'Background',
											'view'=>'image',
											'thumbnail'=>[
												'thumbnail'=>['width'=>1920,'height'=>1000],
											]
										],
										'link'=>[
											'title'=>'Link',
											'view'=>'link',
										],
									]
								],
							]
						],
						'popup'=>[
							'title'=>'Popup',
							'layout'=>'block',
							'items'=>[
								'button'=>['title'=>'Button'],
								'content'=>['title'=>'Content','view'=>'editor'],
							]
						],
						'services'=>[
							'title'=>'Services',
							'layout'=>'block',
							'items'=>[
								'front-text'=>['title'=>'Front Text'],
								'back-text'=>['title'=>'Back Text'],
								'services'=>[
									'title'=>'Services',
									'view'=>'relationship_manytomany',
									'object'=>'service',
									'type'=>'many_record',
								]
							]
						],
						'who-we-are'=>[
							'layout'=>'block',
							'title'=>'Who We Are',
							'items'=>[
								'front-text'=>['title'=>'Front Text'],
								'back-text'=>['title'=>'Back Text'],
								'content'=>['title'=>'Content','view'=>'editor'],
								'link'=>['title'=>'Link','view'=>'link'],
								'image'=>['title'=>'Image','view'=>'image'],
								'text-image'=>['title'=>'Text Image','view'=>'textarea']
							]
						],
						'projects'=>[
							'layout'=>'block',
							'title'=>'Projects',
							'items'=>[
								'front-text'=>['title'=>'Front Text'],
								'back-text'=>['title'=>'Back Text'],
							]
						],
						'lats-talk-with-us'=>[
							'layout'=>'block',
							'title'=>'Lat`s Chat',
							'items'=>[
								'front-text'=>['title'=>'Front Text'],
								'back-text'=>['title'=>'Back Text'],
								'content'=>['title'=>'Content','view'=>'editor'],
								'link'=>['title'=>'Link','view'=>'link'],
								'background'=>['title'=>'Background','view'=>'image']
							]
						],
						'counter'=>[
							'title'=>'Counter',
							'layout'=>'block',
							'items'=>[
								'counter'=>[
									'title'=>'Counter',
									'view'=>'repeater',
									'sub_fields'=>[
										'counter'=>[
											'title'=>'Counter',
										],
										'description'=>[
											'title'=>'Description',
											'view'=>'textarea',
										],
									]
								],
							]
						],
						'teams'=>[
							'title'=>'Teams',
							'layout'=>'block',
							'items'=>[
								'front-text'=>['title'=>'Front Text'],
								'back-text'=>['title'=>'Back Text'],
								'teams'=>[
									'title'=>'Teams',
									'view'=>'relationship_manytomany',
									'type'=>'many_record',
									'object'=>'team',
								]
							]
						],
						'testimonial'=>[
							'title'=>'Testimonial',
							'layout'=>'block',
							'items'=>[
								'front-text'=>['title'=>'Front Text'],
								'back-text'=>['title'=>'Back Text'],
								'testimonial'=>[
									'title'=>'Testimonial',
									'view'=>'repeater',
									'sub_fields'=>[
										'name'=>['title'=>'Name'],
										'title'=>['title'=>'Title'],
										'content'=>['title'=>'Content','view'=>'textarea'],
									]
								]
							]
						],
						'blogs'=>[
							'title'=>'Blogs',
							'layout'=>'block',
							'items'=>[
								'front-text'=>['title'=>'Front Text'],
								'back-text'=>['title'=>'Back Text'],
								'blogs'=>[
									'title'=>'Blogs',
									'view'=>'relationship_manytomany',
									'object'=>'blog_post',
									'type'=>'many_record',
								]
							]
						],
					]
				],
			]
		],


		[
			'title'=>'Custom Fields',
			'templates'=>['about'],
			'fields'=>[
				'background'=>['title'=>'Background Banner','view'=>'image', 'width'=>1920,'height'=>588],
				'section'=>[
					'title'=>'Section',
					'view'=>'flexible',
					'templates'=>[
						'who-we-are'=>[
							'layout'=>'block',
							'title'=>'Who We Are',
							'items'=>[
								'front-text'=>['title'=>'Front Text'],
								'back-text'=>['title'=>'Back Text'],
								'content'=>['title'=>'Content','view'=>'editor'],
								'link'=>['title'=>'Link','view'=>'link'],
								'image'=>['title'=>'Image','view'=>'image'],
								'text-image'=>['title'=>'Text Image','view'=>'textarea']
							]
						],
						'testimonial'=>[
							'layout'=>'block',
							'title'=>'Testimonial',
							'items'=>[
								'front-text'=>['title'=>'Front Text'],
								'back-text'=>['title'=>'Back Text'],
								'testimonial'=>[
									'title'=>'Testimonial',
									'view'=>'repeater',
									'sub_fields'=>[
										'name'=>['title'=>'Name'],
										'title'=>['title'=>'Title'],
										'content'=>['title'=>'Content','view'=>'textarea'],
									]
								]
							]
						],
						'teams'=>[
							'layout'=>'block',
							'title'=>'Teams',
							'items'=>[
								'front-text'=>['title'=>'Front Text'],
								'back-text'=>['title'=>'Back Text'],
								'teams'=>[
									'title'=>'Teams',
									'view'=>'relationship_manytomany',
									'type'=>'many_record',
									'object'=>'team',
								]
							]
						],
					]
				],
			]
		],

		[
			'title'=>'Custom Fields',
			'templates'=>['services'],
			'fields'=>[
				'background'=>['title'=>'Background Banner','view'=>'image', 'width'=>1920,'height'=>588],
				'front-text'=>['title'=>'Front Text'],
				'back-text'=>['title'=>'Back Text'],
				'order_data'=>['title'=>'Order Data','view'=>'group','sub_fields'=>[
					'orderBy'=>['title'=>'Order By','view'=>'select','list_option'=>['title'=>'Title','created_at'=>'Created At','id'=>'ID']],
					'orderType'=>['title'=>'Order Type','view'=>'select','list_option'=>['asc'=>'Ascending','desc'=>'Descending']]
				]],
			]
		],


		[
			'title'=>'Custom Fields',
			'templates'=>['project'],
			'fields'=>[
				'background'=>['title'=>'Background Banner','view'=>'image', 'width'=>1920,'height'=>588],
				'front-text'=>['title'=>'Front Text'],
				'back-text'=>['title'=>'Back Text'],
				'number_of_projects_in_each_page'=>['title'=>'Number of projects in each page','view'=>'number'],
			]
		],

		[
			'title'=>'Custom Fields',
			'templates'=>['contact'],
			'fields'=>[
				'background'=>['title'=>'Background Banner','view'=>'image', 'width'=>1920,'height'=>588],
				'iframe-map'=>['title'=>'Iframe map','view'=>'textarea'],
				'contact-method'=>[
					'title'=>'Contact Method',
					'view'=>'repeater',
					'sub_fields'=>[
						'title'=>['title'=>'Title'],
						'description'=>['title'=>'Description'],
						'icon'=>['title'=>'Icon (fontawesome class)'],
					]
				]
			]
		],

		[
			'title'=>'Custom Fields',
			'templates'=>['blog','search'],
			'fields'=>[
				'background'=>['title'=>'Background Banner','view'=>'image', 'width'=>1920,'height'=>588],
				'number_of_post_in_each_page'=>['title'=>'Number of post in each page','view'=>'number'],
			]
		],




	],

	'service'=>[
		[
			'title'=>'Custom Fields',
			'fields'=>[
				'background'=>['title'=>'Background Banner','view'=>'image', 'width'=>1920,'height'=>588],
			]
		],
	],

	'project_post'=>[
		[
			'title'=>'Custom Fields',
			'fields'=>[
				'background'=>['title'=>'Background Banner','view'=>'image', 'width'=>1920,'height'=>588],
			]
		],
	],

	'blog_post'=>[
		[
			'title'=>'Custom Fields',
			'fields'=>[
				'background'=>['title'=>'Background Banner','view'=>'image', 'width'=>1920,'height'=>588],
			]
		],
	],

	'project_category'=>[
		[
			'title'=>'Custom Fields',
			'fields'=>[
				'background'=>['title'=>'Background Banner','view'=>'image', 'width'=>1920,'height'=>588],
			]
		],
	]

];