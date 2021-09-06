<?php

$sidebar['data'] = [
    'home'=>[
         'title'=>__('Dashboard'),
         'url'=>route('admin.index'),
         'icon'=>'fa-home'
    ],
    'page'=>[
        'title'=>__('Page'),
        'icon'=>'fa-clipboard',
        'url'=>route('admin.show_data',['type'=>'page']),
        'permission'=>['page_list'],
    ],
];

$sidebar['channels'] = [
    'website'=>[
        'title'=>'Website',
        'icon'=>'fa-globe',
        'submenu'=>[

             'themes'=>[
                'title'=>__('Theme'),
                'url'=>route('admin.page',['page'=>'appearance-theme']),
                'permission'=>['appearance-theme_view'],
            ],
            'widget'=>[
                'title'=>__('Widget'),
                'url'=>route('admin.page',['page'=>'appearance-widget']),
                'permission'=>['appearance-widget_view'],
            ],
            'menu'=>[
                'title'=>__('Menu'),
                'url'=>route('admin.page',['page'=>'appearance-menu']),
                'permission'=>['appearance-menu_view'],
            ],
            'email-templates'=>[
                'title'=>__('Mail Templates'),
                'url'=>route('admin.page',['page'=>'mail-templates']),
                'permission'=>['mail-templates_view'],
            ],
            'theme-options'=>[
                'title'=>__('Theme Options'),
                'url'=>route('admin.page',['page'=>'theme-options']),
                'permission'=>['theme-options_view'],
            ]
        ]
    ]
];
$sidebar['add-on'] = [];

// $sidebar['manage'] = [
//     'log'=>[
//         'title'=>__('Log'),
//         'icon'=>'fa-file-text',
//         'url'=>route('admin.page','log'),
//         'permission'=>['log_view'],
//     ],
//     'media'=>[
//         'title'=>__('Media'),
//         'icon'=>'fa-archive',
//         'url'=>route('admin.page',['page'=>'media']),
//         'permission'=>['media_view'],
//     ],
//     'user'=>[
//         'title'=>__('User'),
//         'icon'=>'fa-user',
//         'submenu'=>[
//         'a'=>[
//             'title'=>__('All User'),
//             'url'=>route('admin.show_data',['type'=>'user']),
//             'permission'=>['user_list'],
//         ],
//         'b'=>[
//             'title'=>__('Create User'),
//             'url'=>route('admin.page',['page'=>'user-new']),
//             'permission'=>['user_create'],
//         ],
//         'c'=>[
//             'title'=>__('Profile'),
//             'url'=>route('admin.page',['page'=>'profile']),
//             'permission'=>['profile_view'],
//         ],
//         'd'=>[
//             'title'=>__('User Role Editor'),
//             'url'=>route('admin.page',['page'=>'user-role-editor']),
//             'permission'=>['user-role-editor_view'],
//         ],
//       ]  
//     ],
//      'appearance'=>[
//         'title'=>__('Appearance'),
//         'icon'=>'fa-paint-brush',
//         'submenu'=>[
//             'a'=>[
//                 'title'=>__('Theme'),
//                 'url'=>route('admin.page',['page'=>'appearance-theme']),
//                 'permission'=>['appearance-theme_view'],
//             ],
//             'c'=>[
//                 'title'=>__('Widget'),
//                 'url'=>route('admin.page',['page'=>'appearance-widget']),
//                 'permission'=>['appearance-widget_view'],
//             ],
//             'd'=>[
//                 'title'=>__('Menu'),
//                 'url'=>route('admin.page',['page'=>'appearance-menu']),
//                 'permission'=>['appearance-menu_view'],
//             ],
//             [
//                 'title'=>__('Mail Templates'),
//                 'url'=>route('admin.page',['page'=>'mail-templates']),
//                 'permission'=>['mail-templates_view'],
//             ],
//             [
//                 'title'=>__('Theme Options'),
//                 'url'=>route('admin.page',['page'=>'theme-options']),
//                 'permission'=>['theme-options_view'],
//             ]
//         ]  
//     ],
//     'tool' => [
//         'title'=>__('Tool'),
//         'icon'=>'fa-wrench',
//         'url'=>route('admin.page',['page'=>'tool-genaral']),
//     ],
//     'plugin'=>[
//         'title'=>__('Plugin'),
//         'icon'=>'fa-plug',
//         'url'=>route('admin.page',['page'=>'plugin']),
//         'permission'=>['plugin_view'],
//     ],
//      'system'=>[
//         'title'=>__('System'),
//         'icon'=>'fa-cog',
//         'submenu'=>[
//           ['title'=>__('Setting'),'url'=>route('admin.page','setting'),'permission'=>['view_setting']],
//           ['title'=>__('Environment'),'url'=>route('admin.page','environment'),'permission'=>['environment_view']],
//           ['title'=>__('Cache Management'),'url'=>route('admin.page','cache-management'),'permission'=>['cache-management_view']],
//         ],
//     ],
// ];

$sidebar['data'] = apply_filter('add_sidebar_admin_data',$sidebar['data']);
$sidebar['add-on'] = apply_filter('add_sidebar_admin_add-on',$sidebar['add-on']);
$sidebar['channels'] = apply_filter('add_sidebar_admin_channels',$sidebar['channels']);

$sidebar = apply_filter('add_sidebar_admin_',$sidebar);

return $sidebar;


