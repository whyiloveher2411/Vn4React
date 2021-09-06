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
	    'title'=>'User',
	    'layout'=>'show_data',
	    'is_post_system'=>true,
	    'fields' => [
	        'email' => [
	            'title'=>'Email',
	            'view' =>'email',
	            'unique'=>true,
	            'note'=>'Email dùng để đăng nhập.'],
	        'slug'=>[
	            'title'=>__('Slug'),
	            'view'=>'slug',
	            'key_slug'=>'email',
	            'show_data'=>false,
	        ],
	        'first_name'=>[
	            'title'=>'First Name',
	            'view'=>'text',
	            'show_data'=>false,
	        ],
	        'last_name'=>[
	            'title'=>'Last Name',
	            'view'=>'text',
	            'show_data'=>false,
	        ],
	        'password'  => [
	            'title'=>'Password',
	            'show_data'=>false,
	            'view' =>'password',
	            'note'=>'Password dùng để đăng nhập vào user'
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
	        ],
	    ],
	];

return $object;
