<?php

$list_permission = [
    'post_type'=>[
      'title'=>'Post Type',
      'children'=>[]
    ],
    'page_admin'=>[
      'title'=>'Management',
      'children'=>[]
    ],
    // 'setting'=>[
    //   'title'=>'Setting',
    //   'children'=>[]
    // ],
    'plugin'=>[
      'title'=>'Plugin',
      'children'=>[]
    ],
];

//POST TYPE
$admin_object = get_admin_object();

foreach ($admin_object as $key => $object) {
  $list_permission['post_type']['children']['post_type_'.$key] = [
    'title'=>$object['title'],
    'permission'=>[
        $key.'_list'=>'List '.$object['title'],
        $key.'_create'=>'Create '.$object['title'],
        $key.'_edit'=>'Edit '.$object['title'],
        $key.'_publish'=>'Publish '.$object['title'],
        $key.'_trash'=>'Trash '.$object['title'],
        $key.'_delete'=>'Delete '.$object['title'],
        $key.'_restore'=>'Restore '.$object['title'],
        $key.'_detail'=>'Detail '.$object['title'],
    ]
  ];
}

//Login Add user
$list_permission['post_type']['children']['post_type_user']['permission']['login_as_user_other'] = 'Login As User Other';


// MENU
// $list_permission['page_admin']['children']['page_menu'] = ['title'=>'Appearance Menu','permission'=>['appearance_menu_client_edit'=>'Edit Menu','appearance_menu_client_delete'=>'Delete Menu']];



// PAGE ADMIN
// $list_permission['page_admin']['children']['core'] = ['title'=>'Core','permission'=>[]];

$list_permission['page_admin']['permission']['log_management'] = 'Log management';
$list_permission['page_admin']['permission']['media_management'] = 'Media management';
$list_permission['page_admin']['permission']['theme_management'] = 'Theme management';
$list_permission['page_admin']['permission']['menu_management'] = 'Menu management';
$list_permission['page_admin']['permission']['theme_options_management'] = 'Theme options management';
$list_permission['page_admin']['permission']['plugin_management'] = 'Plugin management';
$list_permission['page_admin']['permission']['my_profile_management'] = 'My profile management';
$list_permission['page_admin']['permission']['tool_management'] = 'Tool management';
$list_permission['page_admin']['permission']['settings_management'] = 'Settings management';


// $list_permission['page_admin']['children']['tool'] = ['title'=>'Tool','permission'=>[]];

// $filesInFolder = File::files(backend_resources('page/tool-genaral'));

// $notNeedPermission = ['post'=>1,'get'=>1,'check-notify'=>1,'check-plugin'=>1];

// foreach($filesInFolder as $path)
// {

//     $fileName = explode('.',pathinfo($path)['filename'])[0];

//     if( !isset($notNeedPermission[$fileName]) ){

//       $title = ucwords(str_replace('-',' ',$fileName));

//       $list_permission['page_admin']['children']['tool']['permission']['tool_'.$fileName] = $title;
//     }

// }
// SETTING
// $list_permission['setting']['children']['core'] = ['title'=>'Core','permission'=>['view_setting'=>'View Setting']];

// $setting = get_setting_object();

// foreach ($setting as $key => $s) {

//   $list_permission['setting']['children']['core']['permission']['change_setting_'.$key] = 'View And Edit Setting '.$s['title'];

// }

// PLUGIN
// $list_permission['plugin']['permission'] = ['plugin_action'=>'Activation - Deactivate the plugin'];

function add_permission_($permission, $key2, $value2 ){
  $key = array_shift($key2);

  if( !isset($permission[$key]) ) {
    $permission[$key] = [];
  }

  if( isset($value2['title_group']) && !isset($key2[0]) ){
    $permission[$key]['title'] = $value2['title_group'];
  }

  if( !isset($permission[$key]['title']) ) $permission[$key]['title'] = '(No Name)';
  
  if( count($key2) > 0 ){

    if( !isset($permission[$key]['children']) ){
      $permission[$key]['children'] = [];
    }

    $permission[$key]['children'] = add_permission_($permission[$key]['children'],$key2,$value2);
  }elseif( isset($value2['key']) && isset($value2['title']) ){

    if( !isset($permission[$key]['permission']) ) $permission[$key]['permission'] = [];

    $permission[$key]['permission'][$value2['key']] = $value2['title'];

  }    


  return $permission;

}


$plugins = plugins();


foreach ($plugins as $plugin) {

  if( file_exists($file = cms_path('resource','views/plugins/'.$plugin->key_word.'/inc/permission.php')) ){

    $permission_plugin = include $file;

    if( is_array($permission_plugin) ){
      
      foreach ($permission_plugin as $key2 => $value2) {
        $key2 = explode('.', $value2['group']);

        $list_permission = add_permission_($list_permission, $key2, $value2);

      }

    }

  }
}

$theme_name = theme_name();

if( file_exists( $file = cms_path('resource','views/themes/'.$theme_name.'/inc/permission.php')) ){
  
    $permission_theme = include $file;

    if( is_array($permission_theme) ){
      foreach ($permission_theme as $key2 => $value2) {
        
        $key2 = explode('.', $value2['group']);
        $list_permission = add_permission_($list_permission, $key2, $value2);

      }
    }
}


return ['permissions'=>$list_permission];