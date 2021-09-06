<?php
return [
	'page'=>[
		[
			'templates'=>['home'],
			'title'=>'Custom Fields',
			'layout'=>'block',
			'fields'=>[
				'banner'=>[
					'title'=>'Banner',
					'view'=>'group',
					'sub_fields'=>[
						'title'=>['title'=>'Title'],
						'description'=>['title'=>'Description','view'=>'textarea'],
						'button_label'=>['title'=>'Button Label'],
						'link'=>['title'=>'Link'],
						'background'=>['title'=>'Background','view'=>'image',
							'thumbnail'=>[
								'384w'=>['title'=>'384w', 'max_width'=>384,'max_height'=>2000],
								'768w'=>['title'=>'768w', 'max_width'=>768,'max_height'=>2000],
								'1152w'=>['title'=>'1152w', 'max_width'=>1152,'max_height'=>2000],
								'1536w'=>['title'=>'1536w', 'max_width'=>1536,'max_height'=>2000],
								'1920w'=>['title'=>'1920w', 'max_width'=>1920,'max_height'=>2000],
							]
						],
					]
				],
				'video_id'=>[
					'title'=>'Video ID',
					'view'=>'text',
				],
				'gallery'=>[
					'title'=>'Gallery',
					'view'=>'image',
					'multiple'=>true,
				],
				'testimonial'=>[
					'title'=>'Testimonial',
					'view'=>'repeater',
					'sub_fields'=>[
						'name'=>['title'=>'Name'],
						'position'=>['title'=>'Position'],
						'content'=>['title'=>'Content','view'=>'textarea'],
						'link'=>['title'=>'Link'],
						'date'=>['title'=>'Date','view'=>'text'],
						'image'=>['title'=>'Image PC','view'=>'image'],
						'image2'=>['title'=>'Image Mobile','view'=>'image'],
					]
				],
			]
		],
		[
			'templates'=>['faq'],
			'title'=>'Custom Fields',
			'layout'=>'block',
			'fields'=>[
				'faq'=>[
					'title'=>'FAQ',
					'view'=>'repeater',
					'sub_fields'=>[
						'title'=>['title'=>'Title'],
						'content'=>[
							'title'=>'Content',
							'view'=>'repeater',
							'sub_fields'=>[
								'question'=>['title'=>'Question'],
								'answer'=>['title'=>'Answer','view'=>'textarea'],
							]
						]
					]
				],
			]
		],
	],
];