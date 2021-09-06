<?php

add_action('register_nav_menus',function($menu){

    $menu['nav-header'] = [
        'title'=>'Nav Header',
    ];

    $menu['nav-footer'] = [
        'title'=>'Nav Footer'
    ];

    return $menu;
});