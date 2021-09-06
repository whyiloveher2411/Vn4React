<?php

return [
	'email-verify'=>[
		'title'=>'Email Verify',
		'description'=>'Email send to user when user register',
		'template'=>'email-verify',
		'parameters'=>[
			'email'=>[
				'title'=>'Email',
				'description'=>'Email needs authentication',
				'view'=>'email',
				'default'=>setting('general_email_address'),
			],
			'link'=>[
				'title'=>'Link',
				'description'=>'Authentication link',
				'view'=>'text',
				'default'=>'https://google.com',
			]
		],
	],
	'email-forgot-password'=>[
		'title'=>'Email Forgot Password',
		'description'=>'Email send to user when user forgot password',
		'template'=>'email-forgot-password',
		'parameters'=>[
			'email'=>[
				'title'=>'Email',
				'description'=>'Email needs authentication',
				'view'=>'email',
				'default'=>setting('general_email_address'),
			],
			'link'=>[
				'title'=>'Link',
				'description'=>'Authentication link',
				'view'=>'text',
				'default'=>'https://google.com',
			]
		],
	]
];