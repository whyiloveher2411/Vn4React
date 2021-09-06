<?php
return [
	'blog_post'=>[
		[
			'title'=>'Custom Fields',
			'fields'=>[
				'advance_content'=>[
					'title'=>'Advance Content',
					'view'=>'flexible',
					'templates'=>[
						'editor'=>['title'=>'Editor','items'=>['content'=>['title'=>'content','view'=>'editor']]],
						'content_box'=>['title'=>'Content Box','items'=>['title'=>['title'=>'Title'],'content'=>['title'=>'content','view'=>'textarea']]],
					]
				],
			]
		],
	],
];