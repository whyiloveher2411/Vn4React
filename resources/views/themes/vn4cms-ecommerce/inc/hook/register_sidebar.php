<?php

add_action('register_sidebar',function( $sidebar ){


    $sidebar['sidebar-right'] = ['title'=>'Sidebar Right','description'=>'Sidebar Right of Home page, category, post detail.'];

    return $sidebar;
});