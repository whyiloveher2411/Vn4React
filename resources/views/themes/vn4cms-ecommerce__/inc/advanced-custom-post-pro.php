<?php
return [

	'page.homepage'=> [
		'title'=>'Home Page',
		'fields'=>[
			'section'=>[
				'title'=>'Section',
				'view'=>'flexible',
				'templates'=>[
					'banners'=>[
						'title'=>'Banner',
						'layout'=>'block',
						'items'=>[
							'slider'=>[
								'title'=>'Slider',
								'view'=>'repeater',
								'sub_fields'=>[
									'title'=>[
										'title'=>'Title'
									],
									'description'=>[
										'title'=>'Description',
										'view'=>'textarea',
									],
									'scope-of-work'=>[
										'title'=>'Scope Of Work',
									],
									'client'=>[
										'title'=>'Client',
									],
									'link'=>[
										'title'=>'Link',
										'view'=>'link',
									],
									'image-desktop'=>[
										'title'=>'Image Desktop',
										'view'=>'image',
									],
									'image-mobile'=>[
										'title'=>'Image Mobile',
										'view'=>'image',
									],
								]
							],
							'list-post'=>[
								'title'=>'List Post',
								'view'=>'group',
								'layout'=>'table',
								'sub_fields'=>[
									'title'=>[
										'title'=>'Title',
										'view'=>'text',
										'width_column'=>'200px',
									],
									'description'=>[
										'title'=>'Description',
										'view'=>'textarea',
										'width_column'=>'200px',
									],
									'link'=>[
										'title'=>'Link All Post',
										'view'=>'link',
									],
									'posts'=>[
										'title'=>'Posts',
										'view'=>'repeater',
										'width_column'=>'auto',
										'sub_fields'=>[
											'title'=>[
												'title'=>'Title',
												'view'=>'text',
											],
											'description'=>[
												'title'=>'Description',
												'view'=>'textarea',
											],
											'link'=>[
												'title'=>'Link',
												'view'=>'link',
											],
											'image'=>['title'=>'Image','view'=>'image'],
										]
									]
								]
							]
						]
					],
					'values'=>[
						'title'=>'Values',
						'items'=>[
							'value-left'=>[
								'title'=>'Value Left',
								'view'=>'group',
								'sub_fields'=>[
									'title'=>['title'=>'Title'],
									'value'=>['title'=>'Value'],
									'description'=>['title'=>'Description'],
									'image'=>['title'=>'Image','view'=>'image'],
								]
							],
							'value-right'=>[
								'title'=>'Value Right',
								'view'=>'repeater',
								'sub_fields'=>[
									'title'=>['title'=>'Title'],
									'value'=>['title'=>'Value'],
									'image'=>['title'=>'Image','view'=>'image'],
									'type'=>['title'=>'Type','view'=>'select','list_option'=>['number-on-bottom'=>'Number On Bottom','number-on-left'=>'Number On Left']]
								]
							]
						]
					],
					'map'=>[
						'title'=>'Map',
						'items'=>[
							'map-left'=>[
								'title'=>'Map Left',
								'view'=>'group',
								'sub_fields'=>[
									'title'=>['title'=>'Title'],
									'image'=>['title'=>'Image','view'=>'image'],
									'locate'=>[
										'title'=>'locate',
										'view'=>'repeater',
										'layout'=>'block',
										'sub_fields'=>[
											'title'=>['title'=>'Title'],
											'top'=>['title'=>'Top'],
											'left'=>['title'=>'Left'],
										]
									],
								]
							],
							'map-right'=>[
								'title'=>'Map Right',
								'view'=>'group',
								'sub_fields'=>[
									'title'=>['title'=>'Title'],
									'locate'=>[
										'title'=>'locate',
										'view'=>'repeater',
										'sub_fields'=>[
											'title'=>['title'=>'Title'],
											'image'=>['title'=>'Image','view'=>'image'],
										]
									],
								]
							],
						]
					],
					'box-link'=>[
						'title'=>'Box Link',
						'items'=>[
							'boxs'=>[
								'title'=>'Boxs',
								'view'=>'repeater',
								'sub_fields'=>[
									'title'=>['title'=>'Title'],
									'image'=>['title'=>'Image','view'=>'image','multiple'=>true],
									'link'=>['title'=>'Link','view'=>'link'],
								]
							],
						]
					]
				]
			],
		]
	],
	'page.about'=> [
		'title'=>'Home Page',
		'fields'=>[
			'section'=>[
				'title'=>'Section',
				'view'=>'flexible',
				'templates'=>[
					'banner-with-carousel'=>[
						'title'=>'Banner with Carousel',
						'layout'=>'tab',
						'items'=>[
							'top'=>[
								'title'=>'Content Top',
								'view'=>'group',
								'sub_fields'=>[
									'image'=>['title'=>'Image','view'=>'image'],
									'title-small'=>['title'=>'Title Small'],
									'title'=>['title'=>'Title'],
									'description'=>['title'=>'Description','view'=>'textarea'],
								]
							],
							'carousel'=>[
								'title'=>'Carousel',
								'view'=>'repeater',
								'sub_fields'=>[
									'title'=>['title'=>'Title'],
									'image'=>['title'=>'Image','view'=>'image'],
								]
							],
							'quote'=>[
								'title'=>'Quote',
								'view'=>'group',
								'sub_fields'=>[
									'name'=>['title'=>'Name'],
									'content'=>['title'=>'Content','view'=>'textarea'],
									'signature'=>['title'=>'Signature']
								]
							]
						]
					],
					'list-post'=>[
						'title'=>'List Post',
						'layout'=>'tab',
						'items'=>[
							'post-1'=>[
								'title'=>'Post 1',
								'view'=>'group',
								'sub_fields'=>[
									'title'=>['title'=>'Title'],
									'description'=>['title'=>'Description','view'=>'textarea'],
									'image'=>['title'=>'Image','view'=>'image'],
									'link'=>['title'=>'Link','view'=>'link'],
								]
							],
							'post-2'=>[
								'title'=>'Post 2',
								'view'=>'group',
								'sub_fields'=>[
									'title'=>['title'=>'Title'],
									'description'=>['title'=>'Description','view'=>'textarea'],
									'image'=>['title'=>'Image','view'=>'image'],
									'link'=>['title'=>'Link','view'=>'link'],
									'list-style'=>['title'=>'List Style','view'=>'editor']
								]
							],
							'box-service'=>[
								'title'=>'Box Service',
								'view'=>'repeater',
								'sub_fields'=>[
									'title'=>['title'=>'Title'],
									'image'=>['title'=>'Image','view'=>'image'],
									'link'=>['title'=>'Link','view'=>'link'],
								]
							]
						]
					]
				]
			]
		]
	],
];