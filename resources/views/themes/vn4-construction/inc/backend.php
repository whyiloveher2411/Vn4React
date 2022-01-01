<?php


// add_sidebar_admin(function() {

//      $filter['vn4blog'] = [
//         'title'=>'Blog',
//         'icon'=>'fa-pencil',
//         'position'=>100,
//         'submenu'=>[
//             [
//                 'title'=>'Blog',
//                 'url'=>route('admin.show_data','blog_post'),
//             ],
//             [
//                 'title'=>'Category',
//                 'url'=>route('admin.show_data','blog_category'),
//             ],
//             [
//                 'title'=>'Tag',
//                 'url'=>route('admin.show_data','blog_tag'),
//             ],
//         ]
//     ];
    
//     $filter['project_post'] = [
//         'title'=>'Project',
//         'icon'=>'fa-briefcase',
//         'position'=>100,
//         'submenu'=>[
//             [
//                 'title'=>'Post',
//                 'url'=>route('admin.show_data','project_post'),
//             ],
//             [
//                 'title'=>'Category',
//                 'url'=>route('admin.show_data','project_category'),
//             ],
//         ]
//     ];
    
//     $filter['team'] = [
//         'title'=>'Team',
//         'icon'=>'fa-users',
//         'position'=>100,
//         'url'=>route('admin.show_data','team'),
//     ];

//     $filter['service'] = [
//         'title'=>'Service',
//         'icon'=>'fa-book',
//         'position'=>100,
//         'url'=>route('admin.show_data','service'),
//     ];

//     $filter['newsletters'] = [
//         'title'=>'Newsletters',
//         'icon'=>'fa-newspaper-o',
//         'position'=>100,
//         'url'=>route('admin.show_data','newsletters'),
//     ];

//     $filter['contact'] = [
//         'title'=>'Contact',
//         'icon'=>'fa-envelope',
//         'position'=>100,
//         'url'=>route('admin.show_data','contact'),
//     ];


//     return $filter;

// });



// register_nav_menus([
//     'header'=>'Nav Header',
//     'footer'=>'Nav Footer',
//     'sidebar'=>'Nav Sidebar',
// ]);

// register_sidebar([
//     'sidebar-primary'=>['title'=>'Primary Sidebar','description'=>'Sidebar Right of blog'],
//     'sidebar-footer'=>['title'=>'Sidebar Footer','description'=>'Sidebar Footer'],
// ]);

// add_filter('list_widget',function($widgets){

//     $widgets['search'] = [
//         'title'=>'Serach',
//         'description'=>'Serach box',
//         'fields'=>[
            
//         ]
//     ];

//     $widgets['category'] = [
//         'title'=>'Category',
//         'description'=>'Category box',
//         'fields'=>[
//             'number_display'=>['title'=>'Number Post Display' ,'view'=>'number']
//         ]
//     ];

//     $widgets['recent-post'] = [
//         'title'=>'Recent Post',
//         'description'=>'Recent Post box',
//         'fields'=>[
//             'number_display'=>['title'=>'Number Post Display' ,'view'=>'number']
//         ]
//     ];

//     $widgets['tag-clouds'] = [
//         'title'=>'Tag Clouds',
//         'description'=>'Tag Clouds box',
//         'fields'=>[
//             'number_display'=>['title'=>'Number Post Display' ,'view'=>'number']
//         ]
//     ];

//     $widgets['image-list'] = [
//         'title'=>'Image List',
//         'description'=>'Image List box',
//         'fields'=>[
//             'images'=>[
//                 'title'=>'Images',
//                 'view'=>'repeater',
//                 'sub_fields'=>[
//                     'link'=>['title'=>'Link','view'=>'link'],
//                     'image'=>['title'=>'Image','view'=>'image','thumbnail'=>['listing'=>['width'=>90,'height'=>90]]],
//                 ]
//             ]
//         ]
//     ];

//     $widgets['info'] = [
//         'title'=>'Info',
//         'description'=>'Info box',
//         'fields'=>[
//             'description'=>[
//                 'title'=>'Description',
//                 'view'=>'textarea',
//             ]
//         ]
//     ];

//     $widgets['quick-link'] = [
//         'title'=>'Quick Link',
//         'description'=>'Quick Link box',
//         'fields'=>[
//             'links'=>[
//                 'title'=>'Links',
//                 'view'=>'menu',
//             ]
//         ]
//     ];

//     $widgets['contact'] = [
//         'title'=>'Contact',
//         'description'=>'Contact box',
//         'fields'=>[

//         ]
//     ];


//     $widgets['newsletter'] = [
//         'title'=>'Newsletter',
//         'description'=>'Newsletter box',
//         'fields'=>[
//             'map'=>[
//                 'title'=>'Map',
//                 'view'=>'image'
//             ]
//         ]
//     ];

//     return $widgets;
// });


// add_filter('theme_options',function($theme_options){

//     $theme_options['general'] = [
//         'fields'=>[
//             'logo'=>[
//                 'title'=>'Logo',
//                 'view'=>'image',
//             ],
//             'loder-logo'=>[
//                 'title'=>'Loder Logo',
//                 'view'=>'image',
//             ],
//             'copyright'=>'text',
//             'button-header'=>[
//                 'view'=>'group',
//                 'sub_fields'=>[
//                     'label'=>['title'=>'Label','view'=>'text'],
//                     'link'=>['title'=>'Link','view'=>'link'],
//                 ]
//             ],
//             'cookie-accept'=>'textarea',
//         ]
//     ];

//     $theme_options['contact'] = [
//         'fields'=>[
//             'address'=>'textarea',
//             'phone'=>'text',
//             'email'=>'email',
//             'openTime'=>'text',
//             'openTime'=>'text',
//             'social'=>[
//                 'title'=>'Social',
//                 'view'=>'repeater',
//                 'sub_fields'=>[
//                     'title'=>['title'=>'Title'],
//                     'icon'=>['title'=>'Icon (fontawesome class)'],
//                     'link'=>['title'=>'Link'],
//                 ]
//             ]
//         ],
//     ];


//     return $theme_options;

// });
