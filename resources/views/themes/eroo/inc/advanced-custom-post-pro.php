<?php
return [
	
	'page'=> [

		[
			'templates'=>['eroo'],
			'title'=>'Section Homepage',
			'fields'=>[
				'section'=>[
					'title'=>'Sections',
					'view'=>'flexible',
					'singular_name'=>'Section',
					'templates'=>[
						'slider'=>[
							'title'=>'Slider',
							'items'=>[
								'slider'=>[
									'title'=>'Sliders',
									'view'=>'repeater',
									'singular_name'=>'Slider',
									'layout'=>'block',
									'sub_fields'=>[
										'heading'=>[
											'title'=>'Heading'
										],
										'subheading'=>[
											'title'=>'Sub Heading',
										],
										'description'=>[
											'title'=>'Description',
											'view'=>'textarea'
										],
										'background'=>[
											'title'=>'Background',
											'view'=>'image',
										],
										'buttons'=>[
											'title'=>'Buttons',
											'view'=>'repeater',
											'singular_name'=>'Button',
											'sub_fields'=>[
												'label'=>['title'=>'Lable'],
												'type'=>[
													'title'=>'Type', 
													'view'=>'select', 
													'list_option'=>['btn-primary'=>['title'=>'Primary'], 'btn-white'=>['title'=>'White']]
												]
											]
										]
									]
								],
							]
						],
						'banner_with_breadcrumbs'=>[
							'title'=>'Banner With Breadcrumbs',
							'items'=>[
								'title'=>['title'=>'Title'],
								'breadcrumbs'=>[
									'title'=>'breadcrumbs','view'=>'repeater','singular_name'=>'Link',
									'sub_fields'=>[
										'title'=>['title'=>'Title'],
										'link'=>['title'=>'Link'],
									]
								],
								'banner'=>['title'=>'Banner','view'=>'image']
							]
						],
						'service'=>[
							'title'=>'Service',
							'items'=>[
								'title'=>['title'=>'Title'],
								'description'=>['title'=>'Description'],
								'services'=>[
									'title'=>'Services',
									'view'=>'repeater',
									'singular_name'=>'Service',
									'sub_fields'=>[
										'title'=>['title'=>'Title'],
										'icon'=>['title'=>'Icon'],
										'active'=>['title'=>'Active','view'=>'true_false'],
										'link'=>['title'=>'Link'],
									]
								]
							]
						],
						'aboutIntro'=>[
							'title'=>'About Intro',
							'items'=>[
								'heading'=>['title'=>'Heading'],
								'subheading'=>['title'=>'Sub Heading'],
								'description'=>['title'=>'Description'],
								'number_primary'=>[
									'title'=>'Number Primary',
									'view'=>'group',
									'sub_fields'=>[
										'number'=>['title'=>'Number'],
										'description'=>['title'=>'Description'],
										'icon'=>['title'=>'Icon'],
									]
								]
							]
						],
						'counter'=>[
							'title'=>'Counter',
							'items'=>[
								'background'=>['title'=>'Background','view'=>'image'],
								'counters'=>[
									'title'=>'Counters',
									'view'=>'repeater',
									'singular_name'=>'Counter',
									'sub_fields'=>[
										'number'=>['title'=>'Number'],
										'description'=>['title'=>'Description'],
										'icon'=>['title'=>'Icon'],
										'color'=>['title'=>'Color'],
									]
								]
							]
						],
						'faq'=>[
							'title'=>'FAQs',
							'items'=>[
								'content_left'=>[
									'title'=>'Content Left',
									'view'=>'group',
									'sub_fields'=>[
										'heading'=>['title'=>'Title'],
										'subheading'=>['title'=>'Sub Heading'],
										'q&a'=>[
											'title'=>'Q&A',
											'view'=>'repeater',
											'singular_name'=>'Question',
											'sub_fields'=>[
												'question'=>['title'=>'Question'],
												'anwser'=>['title'=>'Anwser','view'=>'editor'],
											]
										]
									]
								],
								'content_right'=>[
									'title'=>'Content Right',
									'view'=>'group',
									'sub_fields'=>[
										'heading'=>['title'=>'Heading'],
										'image'=>[
											'title'=>'Image','view'=>'image',
										],
										'skill'=>[
											'title'=>'Skills',
											'view'=>'repeater',
											'singular_name'=>'Skill',
											'sub_fields'=>[
												'title'=>['title'=>'Title'],
												'progress'=>['title'=>'Progress','view'=>'number'],
											]
										]
									]
								]

							]
						],
						'team'=>[
							'title'=>'Team',
							'items'=>[
								'heading'=>['title'=>'Heading'],
								'subheading'=>['title'=>'Sub Heading'],
								'teams'=>[
									'title'=>'Teams',
									'view'=>'repeater',
									'singular_name'=>'Team',
									'sub_fields'=>[
										'name'=>['title'=>'Name'],
										'position'=>['title'=>'Position'],
										'avata'=>['title'=>'Avata','view'=>'image'],
										'contact'=>['title'=>'Contacts','view'=>'repeater','singular_name'=>'Contact','sub_fields'=>['icon'=>['title'=>'Icon'],'link'=>['title'=>'Link']]],
									]
								]
							]
						],
						'price_and_plans'=>[
							'title'=>'Price & Plans',
							'items'=>[
								'heading'=>['title'=>'Heading'],
								'subheading'=>['title'=>'Sub Heading'],
								'price_list'=>[
									'title'=>'Price List ','view'=>'repeater',
									'singular_name'=>'Price',
									'sub_fields'=>[
										'image'=>['title'=>'Image','view'=>'image'],
										'plans'=>['title'=>'Plans','singular_name'=>'Plan','view'=>'repeater','sub_fields'=>['title'=>['title'=>'Title']]],
										'price'=>['title'=>'Price']
									]
								],
							]
						],
						'project'=>[
							'title'=>'Project',
							'items'=>[
								'heading'=>['title'=>'Heading'],
								'subheading'=>['title'=>'Sub Heading'],
								'button_right'=>[
									'title'=>'Button Right',
									'view'=>'group',
									'sub_fields'=>[
										'label'=>['title'=>'Label'],
										'link'=>['title'=>'Link']
									]
								],
								'posts_per_page'=>['title'=>'Posts Per Page ','view'=>'number'],
							]
						],
						'all_project'=>[
							'title'=>'All Project',
							'items'=>[
								'posts_per_page'=>['title'=>'Posts Per Page ','view'=>'number'],
							]
						],
						'testimonial'=>[
							'title'=>'Testimonial',
							'items'=>[
								'heading'=>['title'=>'Heading'],
								'subheading'=>['title'=>'Sub Heading'],
								'testimonial'=>[
									'title'=>'Testimonials',
									'view'=>'repeater',
									'singular_name'=>'Testimonial',
									'sub_fields'=>[
										'name'=>['title'=>'Name'],
										'avata'=>['title'=>'Avata','view'=>'image'],
										'position'=>['title'=>'Position'],
										'star'=>['title'=>'Star'],
										'content'=>['title'=>'Content','view'=>'textarea'],
									]
								]
							]
						],
						'posts'=>[
							'title'=>'Posts',
							'items'=>[
								'heading'=>['title'=>'Heading'],
								'subheading'=>['title'=>'Sub Heading'],
								'posts_per_page'=>['title'=>'Posts Per Page ','view'=>'number'],
							]
						],
						'blog'=>[
							'title'=>'Blog',
							'items'=>[
								'posts_per_page'=>['title'=>'Posts Per Page ','view'=>'number'],
							]
						],
						'newsletter'=>[
							'title'=>'Newsletter',
							'items'=>[
								'heading'=>['title'=>'Heading'],
								'description'=>['title'=>'Description'],
							]
						],
						'contact'=>[
							'title'=>'Contact',
							'items'=>[
								'heading-left'=>['title'=>'Heading Left'],
								'heading-right'=>['title'=>'Heading Right'],
								'iframe-map'=>['title'=>'Iframe Map','view'=>'textarea'],
								'contact_channels'=>[
									'title'=>'Contact Channels',
									'view'=>'repeater',
									'singular_name'=>'Channel',
									'sub_fields'=>[
										'title'=>['title'=>'Title'],
										'content'=>['title'=>'Content','view'=>'textarea'],
										'icon'=>['title'=>'Icon (Font Awesome 4.7.0)']
									]
								]
							]
						],
					]
				],
			]
		],

	],
];