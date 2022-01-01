<?php
namespace CMS\Admin;

class Sidebar{

    public static function get(){
                
        $sidebar = [
            'dashboard'=>[
                'title'=>'Dashboard',
                'show'=>true,
                'icon'=>'DashboardOutlined',
                'pages' =>  [
                    [
                        'name' =>  'dashboard',
                        'title' =>  'Dashboard',
                        'icon' =>  'DashboardOutlined',
                        'href' =>  '/dashboard',
                    ],
                ]
            ],
            'content'=>[
                'title'=>'Content',
                'icon'=>[
                    'custom'=>'<path d="M0 0h24v24H0V0z" fill="none"/><path d="M19 2h-4.18C14.4.84 13.3 0 12 0S9.6.84 9.18 2H5c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm7 18H5V4h2v3h10V4h2v16z"/>'
                ],
                'show'=>false,
                'description'=>'Page, Posts, Products, Categories, Tags,...',
                'pages' =>  [
                    [
                        'name' =>  'pages',
                        'title' =>  'Pages',
                        'icon' =>  'InsertDriveFileOutlined',
                        'href' =>  '/post-type/page/list',
                    ],
                ]
            ],
            'management'=>[
                'title' =>'Settings',
                'icon'=>'SettingsOutlined',
                'show'=>false,
                'description'=>'Users, Settings, Appearance, Plugin, Logs, Media,...',
                'pages' =>  [
                    [
                        'name' =>  'log',
                        'title' =>  'Log',
                        'icon' =>  'FileCopyOutlined',
                        'href' =>  '/log',
                    ],
                    [
                        'name' =>  'media',
                        'title' =>  'Media',
                        'icon' =>  'FolderOpenOutlined',
                        'href' =>  '/media',
                    ],
                    [
                        'name' =>  'entity-relationship',
                        'title' =>  'Entity Relationship',
                        'icon' =>  'ViewModuleRounded',
                        'href' =>  '/entity-relationship',
                    ],
                    [
                        'name' =>  'appearance',
                        'title' =>  'Appearance',
                        'icon' =>  'BrushOutlined',
                        'href' =>  '/appearance',
                        'children' =>  [
                            [
                                'name' =>  'theme',
                                'title' =>  'Theme',
                                'href' =>  '/appearance/theme',
                            ],
                            [
                                'name' =>  'menu',
                                'title' =>  'Menu',
                                'href' =>  '/appearance/menu',
                            ],
                            [
                                'name' =>  'widget',
                                'title' =>  'Widget',
                                'href' =>  '/appearance/widget',
                            ],

                            [
                                'name' =>  'theme-options',
                                'title' =>  'Theme Options',
                                'href' =>  '/appearance/theme-options',
                            ],
                        ]
                    ],
                    [
                        'name' =>  'plugins',
                        'title' =>  'Plugins',
                        'icon' =>  'AppsOutlined',
                        'href' =>  '/plugins',
                    ],
                    [
                        'name' =>  'users',
                        'title' =>  'Users',
                        'icon' =>  'PeopleAltOutlined',
                        'href' =>  '/users',
                        'children' =>  [
                            [
                                'name' =>  'all-users',
                                'title' =>  'All Users',
                                'href' =>  '/post-type/user/list',
                            ],
                            [
                                'name' =>  'add-new',
                                'title' =>  'Add New',
                                'href' =>  '/post-type/user/new',
                            ],
                            [
                                'name' =>  'profile',
                                'title' =>  'Profile',
                                'href' =>  '/user/profile',
                            ],
                        ]
                    ],
                    [
                        'name' =>  'tool',
                        'title' =>  'Tool',
                        'icon' =>  'BuildOutlined',
                        'href' =>  '/tool',
                    ],
                    [
                        'name' =>  'localization',
                        'title' =>  'Localization',
                        'icon' =>  'Translate',
                        'href' =>  '/localization',
                    ],
                    [
                        'name' =>  'setting',
                        'title' =>  'Settings',
                        'icon' =>  'SettingsOutlined',
                        'href' =>  '/settings',
                    ],
                ]
            ],
            'support'=>[
                'title' =>  'Support',
                'show'=>false,
                'icon'=>'HelpOutlineOutlined',
                'description'=>'Version, Contact, Feedback, Development,...',
                'pages' =>  [
                    [
                        'name' =>  'getting-started',
                        'title' =>  'Getting Started',
                        'icon' =>  'Code',
                        'href' =>  '/getting-started'
                    ],
                    [
                        'name' =>  'changelog',
                        'title' =>  'Changelog',
                        'icon' =>  'ViewModule',
                        'href' =>  '/changelog',
                        'label' =>  [
                            'shape' =>  'square',
                            'color' =>  'rgb(33, 150, 243)',
                            'title' =>  'V1.0.0',
                        ]
                    ],

                ]
            ],
        ];


        $sidebar = do_action('admin_sidebar', $sidebar);

        return $sidebar;

    }

}