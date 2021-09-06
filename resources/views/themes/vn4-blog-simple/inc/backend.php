<?php


add_sidebar_admin(function() {

    $filter['demo'] = [
        'title'=>'Blog',
        'icon'=>'fa-themeisle',
        'position'=>100,
        'submenu'=>[
            [
                'title'=>'Post',
                'url'=>route('admin.show_data','blog_post'),
            ],
            [
                'title'=>'Category',
                'url'=>route('admin.show_data','blog_category'),
            ],
            [
                'title'=>'Author',
                'url'=>route('admin.show_data','blog_author'),
            ],
        ]
    ];

    return $filter;

});



register_nav_menus([
    'header'=>'Nav Header',
    'footer'=>'Nav Footer',
]);



// register_nav_menus([
//     'header'=>'Nav Header',
// ]);

// register_sidebar([
// 	'sidebar-right'=>['title'=>'Sidebar Right','description'=>'Sidebar Right of Home page, category, post detail.']
// ]);