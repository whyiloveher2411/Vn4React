<?php

add_action('admin_sidebar', function($data, $sidebar){
    
    $sidebar = array_slice($sidebar, 0, 100, true) +
    array('vn4-messenger' => [
        'title'=>'Chat',
        'show' => false,
        'icon'=>['custom'=>'<image style="width:100%;" href="'.plugin_asset('vn4-messenger','img/chat.svg').'" />'],
        'component'=>'Custom/SubMenu',
        'pages'=>[
            
        ]
    ]) +
    array_slice($sidebar, 1, count($sidebar), true);
    
    return $sidebar;
});