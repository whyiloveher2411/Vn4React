<?php
$object['page'] = [
    'table'=>vn4_tbpf().'page',
    'title'=>__('Page'),
    'way_show'=>'title',
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
        'description' => [
            'title'=>__('Description'),
            'show_data'=>false,
            'view' =>'textarea',
            'note'=>'Mô tả bình thường không được sử dụng trong giao diện, tuy nhiên có vài giao diện hiện thị mô tả này.',
        ],
        'content' => [
            'title'=>__('Content'),
            'view' =>'editor',
            'show_data'=>false,
            'required'=>true,
        ],
    ],
];

$object['user'] = [
		'table'=>vn4_tbpf().'user',
		'title'=>__('User'),
		'is_post_system'=>true,
		'fields' => [
			'email' => [
				'title'=>__('Email'),
				'view' =>'email',
				'unique'=>true,
				'note'=>'Email used to login.'],
			'slug'=>[
				'title'=>__('Slug'),
				'view'=>'slug',
				'key_slug'=>'email',
				'show_data'=>false,
			],
			'first_name'=>[
				'title'=>__('First Name'),
				'view'=>'text',
				'show_data'=>false,
			],
			'last_name'=>[
				'title'=>__('Last Name'),
				'view'=>'text',
				'show_data'=>false,
			],
			'profile_picture'=>[
				'title'=>'Avata',
				'view'=>'image',
				'show_data'=>false,
				'thumbnail'=>[
					'nav-top'=>['title'=>'Nav Top','type'=>1,'width'=>74,'height'=>74]
				]
			],
			'password'  => [
				'title'=>__('Password'),
				'show_data'=>false,
				'view' =>'password',
				'note'=>'Password used to log in the user'
			],
			'role'=>[
				'title'=>'Role',
				'view'=>'text',
				'length'=>60,
			],
			'customize_time'=>[
				'title'=>'Customize Time',
				'show_data'=>false,
				'view'=>'text'
			]
		],
		'show_in_nav_menus'=>false,
		'public'=>false,
	];

return $object;
