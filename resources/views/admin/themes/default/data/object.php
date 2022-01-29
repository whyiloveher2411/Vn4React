<?php

if( is_admin() ){

    include __DIR__.'/load_post_type.php';

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
            'image' => [
                'title'=>'image',
                'show_data'=>false,
                'view' =>'image',
            ],
            'images' => [
                'title'=>'image',
                'show_data'=>false,
                'multiple'=>true,
                'view' =>'image',
            ],
            'checkbox' => [
                'title'=>'Checkbox',
                'show_data'=>false,
                'view' =>'checkbox',
                'list_option'=>[
                    'option1'=>['title'=>'Option 1'],
                    'option2'=>['title'=>'Option 2'],
                    'option3'=>['title'=>'Option 3'],
                ]
            ],
            'color'=>[
                'title'=>'Color',
                'show_data'=>false,
                'view' =>'color',
            ],
            'date_picker'=>[
                'title'=>'Date picker',
                'show_data'=>false,
                'view' =>'date_picker',
            ],
            'date_range_start'=>[
                'title'=>'Date Start',
                'view'=>'date',
                'hidden'=>true,
            ],
            'date_range_end'=>[
                'title'=>'Date End',
                'view'=>'date',
                'hidden'=>true,
            ],
            'date_range'=>[
                'title'=>'Date range',
                'show_data'=>false,
                'view' =>'date_range',
                'names'=>['date_range_start','date_range_end']
            ],
            'date_time'=>[
                'title'=>'Date Time',
                'show_data'=>false,
                'view' =>'date_time',
            ],
            'email'=>[
                'title'=>'Email',
                'show_data'=>false,
                'view' =>'email',
            ],
            'flexible'=>[
                'title'=>'Flexible',
                'show_data'=>false,
                'view' =>'flexible',
                'templates'=>[
                    'option1'=>[
                        'title'=>'Option 1',
                        'description'=>'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
                        'items'=>[
                            'title'=>['title'=>'Title','view'=>'text'],
                            'description'=>['title'=>'Description','view'=>'textarea'],
                        ]
                    ],
                    'option2'=>[
                        'title'=>'Option 2',
                        'description'=>'but also the leap into electronic typesetting, remaining essentially unchanged',
                        'items'=>[
                            'category'=>['title'=>'Category','view'=>'relationship_onetomany','object'=>'ecom_prod'],
                            'tag'=>['title'=>'Category','view'=>'relationship_manytomany','object'=>'ecom_prod_cate'],
                        ]
                    ],
                    'option3'=>[
                        'title'=>'Option 3',
                        'description'=>'discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero',
                        'items'=>[
                            'section'=>[
                                'title'=>'Section',
                                'view'=>'flexible',
                                'templates'=>[
                                    'option1'=>[
                                        'title'=>'Option 1',
                                        'description'=>'but also the leap into electronic typesetting, remaining essentially unchanged',
                                        'items'=>[
                                            'title'=>['title'=>'Title','view'=>'text'],
                                            'description'=>['title'=>'Description','view'=>'textarea'],
                                        ]
                                    ],
                                    'option2'=>[
                                        'title'=>'Option 2',
                                        'description'=>'discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero',
                                        'items'=>[
                                            'category'=>['title'=>'Category','view'=>'relationship_onetomany','object'=>'ecom_prod'],
                                            'tag'=>['title'=>'Category','view'=>'relationship_manytomany','object'=>'ecom_prod_cate'],
                                        ]
                                    ]
                                ]
                            ],
                        ]
                    ]
                ]
            ],
            'hidden'=>[
                'title'=>'Hidden',
                'view'=>'hidden',
                'defaultValue'=>'sdfsfds sdf sdf sdf',
            ],
            'input'=>[
                'title'=>'Input date',
                'view'=>'input',
                'type'=>'date',
                'labelProps'=>[
                    'shrink'=> true,
                ]
            ],
            'json'=>[
                'title'=>'Json',
                'view'=>'json',
            ],
            'link'=>[
                'title'=>'Link',
                'view'=>'link',
            ],
            'menu'=>[
                'title'=>'Menu',
                'view'=>'menu',
            ],
            'number'=>[
                'title'=>'Number',
                'view'=>'number',
            ],
            'password'=>[
                'title'=>'Password',
                'view'=>'password',
                'generator'=>true,
            ],
            'radio'=>[
                'title'=>'radio',
                'view'=>'radio',
                'list_option'=>[
                    'option1'=>['title'=>'option 1','color'=>'red'],
                    'option2'=>['title'=>'option 2','color'=>'green'],
                    'option3'=>['title'=>'option 3','color'=>'yellow'],
                ]
            ],
            'relationship_onetomany'=>[
                'title'=>'Relationship onetomany',
                'view'=>'relationship_onetomany',
                'object'=>'ecom_prod_cate',
                'hierarchical'=>'parent',
            ],
            'relationship_manytomany'=>[
                'title'=>'Relationship manytomany',
                'view'=>'relationship_manytomany',
                'object'=>'ecom_prod_cate',
                'hierarchical'=>'parent',
            ],
            'repeater'=>[
                'title'=>'Repeater',
                'view'=>'repeater',
                'layout'=>'block',
                'sub_fields'=>[
                    'title'=>['title'=>'Title','view'=>'text'],
                    'description'=>['title'=>'Description','view'=>'textarea'],
                ],
            ],
            'select'=>[
                'title'=>'Select',
                'view'=>'select',
                'list_option'=>[
                    'option1'=>['title'=>'option 1','color'=>'red','description'=>'des 1'],
                    'option2'=>['title'=>'option 2','color'=>'green','description'=>'des 2'],
                    'option3'=>['title'=>'option 3','color'=>'yellow','description'=>'des 3'],
                ]
            ],
            'slug2'=>[
                'title'=>'Slug',
                'view'=>'slug',
                'referenceKey'=>'title',
            ],
            'true_false'=>[
                'title'=>'True False',
                'view'=>'true_false',
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
            ],
            'last_name'=>[
                'title'=>__('Last Name'),
                'view'=>'text',
            ],
            'profile_picture'=>[
                'title'=>'Avata',
                'view'=>'image',
                'show_data'=>false,
                'thumbnail'=>[
                    'nav-top'=>['title'=>'Nav Top','type'=>1,'width'=>74,'height'=>74]
                ],
                'size'=>[
                    'width'=>100,
                    'height'=>100,
                    'maxWidth'=>200,
                    'maxHeight'=>200,
                    'minWidth'=>50,
                    'minHeight'=>50,
                    'ratio'=>'1x1',
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

        include __DIR__.'/load_post_type.php';

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
                ],
                'last_name'=>[
                    'title'=>__('Last Name'),
                    'view'=>'text',
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






