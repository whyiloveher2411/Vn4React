<?php

$sidebar = array_slice($sidebar, 0, 2, true) +

    array('ThemeBuilder' => [
        'title'=>'Theme builder',
    'show' => false,
    'icon'=>['custom'=>'<image style="width:100%;" href="/plugins/vn4-theme-builder/img/colour.svg" />'],
    'component'=>'SidebarThemeBuilder'
    ]) 

    + array_slice($sidebar, 2, count($sidebar), true);
