<?php


add_sidebar_admin(function() {

    $filter['demo'] = [
        'title'=>'PNJ',
        'icon'=>'fa-themeisle',
        'position'=>100,
        'submenu'=>[
            [
                'title'=>'Post',
                'url'=>route('admin.show_data','pnj_post'),
            ],
            [
                'title'=>'Category',
                'url'=>route('admin.show_data','pnj_category'),
            ],
            [
                'title'=>'Topic',
                'url'=>route('admin.show_data','pnj_topic'),
            ],
        ]
    ];

    return $filter;

});



// register_nav_menus([
//     'header'=>'Nav Header',
// ]);

// register_sidebar([
// 	'sidebar-right'=>['title'=>'Sidebar Right','description'=>'Sidebar Right of Home page, category, post detail.']
// ]);