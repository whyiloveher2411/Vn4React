<?php

if( is_admin() ){

    include cms_path('resource','views/admin/themes/default/post-type/function-template-table-data.php');

    $object['page'] = [
        'table'=>vn4_tbpf().'page',
        'title'=>__('Page'),
        'way_show'=>'title',
        'public_view'=>true,
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
                'note'=>__('Normal descriptions are not used in the interface, however some interfaces display this description.'),
            ],
            'content' => [
                'title'=>'Content',
                'show_data'=>false,
                'view' =>'editor',
            ],
        ],
    ];

    $object = apply_filter('object_admin',$object);
    $object = apply_filter('register_post_type',$object);

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


    $custom_post_slug = [];

    $theme = theme_name();

    foreach ($object as $key => $value) {

        if( isset($value['slug']) ){
            $custom_post_slug[$value['slug']] = $key;
        }else{
            $object[$key]['slug'] = $key;
            $custom_post_slug[$key] = $key;
        }

        if( !isset($value['public_view']) ){

            if( view()->exists('themes.'.$theme.'.post-type.'.$key) || file_exists(cms_path('resource','views/themes/'.$theme.'/post-type/'.$key)) ){
                $object[$key]['public_view'] = true;
            }else{
                $object[$key]['public_view'] = false;
            }
        }

    }

    $object = apply_filter('object_admin_all',$object);

    $object = array_merge( $object, include cms_path('root','cms/core/data-object-admin.php'));

    $list_post_type = ['data'=>$object,'custom_post_slug'=>$custom_post_slug];

}else{

    $list_post_type = cache_tag ('curd', App::getLocale(),function() {

        include cms_path('resource','views/admin/themes/default/post-type/function-template-table-data.php');

        $object['page'] = [
            'table'=>vn4_tbpf().'page',
            'title'=>__('Page'),
            'way_show'=>'title',
            'public_view'=>true,
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
                ],
                'content' => [
                    'title'=>'Content',
                    'show_data'=>false,
                    'view' =>'editor',
                ],
            ],
        ];

        $object = apply_filter('object_admin',$object);
        $object = apply_filter('register_post_type',$object);

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

        $custom_post_slug = [];

        $theme = theme_name();

        $object = apply_filter('object_admin_all',$object);

        function set_string_closure($value){

            if( !is_string($value) && is_callable($value) ){
                return 'closure';
            }

            if( is_array($value) ){
                foreach ($value as $key2 => $value2) {
                    $value[$key2] = set_string_closure($value2);
                }
            }

            return $value;

        }

        foreach ($object as $key => $value) {

            $object[$key] = set_string_closure($object[$key]);

            if( isset($value['slug']) ){
                $custom_post_slug[$value['slug']] = $key;
            }else{
                $object[$key]['slug'] = $key;
                $custom_post_slug[$key] = $key;
            }

            if( !isset($value['public_view']) ){

                if( view()->exists('themes.'.$theme.'.post-type.'.$key) || file_exists(cms_path('resource','views/themes/'.$theme.'/post-type/'.$key)) ){
                    $object[$key]['public_view'] = true;
                }else{
                    $object[$key]['public_view'] = false;
                }
            }

        }

        return ['data'=>$object,'custom_post_slug'=>$custom_post_slug];

    });
}

$GLOBALS['custom_post_slug'] = $list_post_type['custom_post_slug'];
return $list_post_type['data'];






