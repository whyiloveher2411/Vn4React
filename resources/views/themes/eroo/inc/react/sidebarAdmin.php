<?php

$sidebar['content']['pages'][] = [
    'name' =>  'Blogs',
    'title' =>  'Blogs',
    'icon' =>  'PostAddRounded',
    'href' =>  '/post-type/eroo_blog',
    'children'=>[
        [
            'name'=>'Posts',
            'title'=>'Posts',
            'href'=>'/post-type/eroo_blog/list',
        ],
        [
            'name'=>'Categories',
            'title'=>'Categories',
            'href'=>'/post-type/eroo_blog_category/list',
        ],
        [
            'name'=>'Tags',
            'title'=>'Tags',
            'href'=>'/post-type/eroo_blog_tag/list',
        ],
        
    ]
];


$sidebar['content']['pages'][] = [
    'name' =>  'Projects',
    'title' =>  'Projects',
    'icon' =>  'AppsRounded',
    'href' =>  '/post-type/eroo_project',
    'children'=>[
        [
            'name'=>'Projects',
            'title'=>'Projects',
            'href'=>'/post-type/eroo_project/list',
        ],
        [
            'name'=>'Categories',
            'title'=>'Categories',
            'href'=>'/post-type/eroo_project_category/list',
        ],
        [
            'name'=>'Tags',
            'title'=>'Tags',
            'href'=>'/post-type/eroo_project_tag/list',
        ],
        
    ]
    
];


$sidebar['content']['pages'][] = [
    'name' =>  'Services',
    'title' =>  'Services',
    'icon' =>  'WorkOutlineOutlined',
    'href' =>  '/post-type/eroo_service/list',
];


$sidebar['content']['pages'][] = [
    'name' =>  'Staff',
    'title' =>  'Staff',
    'icon' =>  'PeopleOutlineRounded',
    'href' =>  '/post-type/eroo_staff/list',
];
$sidebar['content']['pages'][] = [
    'name' =>  'Testimonial',
    'title' =>  'Testimonial',
    'icon' =>  'MessageOutlined',
    'href' =>  '/post-type/eroo_testimonial/list',
];
