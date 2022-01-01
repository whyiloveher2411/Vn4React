<?php
include __DIR__.'/_helper.php';

if( config('app.EXPERIENCE_MODE') ){
    return experience_mode();
}


$group = $r->get('group');
$subGroup = $r->get('subGroup');

$data = getDataSetting( $group, $subGroup );

$settingKeys = [];


foreach( $data['config'] as  $groupField ){
    if( isset($groupField['fields']) && !empty($groupField['fields']) ){
        foreach($groupField['fields'] as $key => $field){
            $settingKeys[$key] = $field;
        }
    }
}

$input = $r->post('settings');

$keyList = [];

foreach ($settingKeys as $k => $field) {

    $keyList[] = $k;

    if( isset($field['saveCallback']) ){
      setting_save(
          $k, 
          $field['saveCallback'](  (isset($input[$k]) && $input[$k]) ? $input[$k] : '', $input  ),
          $group, 
          isset($field['is_json']) ? $field['is_json'] : false 
        );
    }else{
      setting_save(
          $k, 
          (isset($input[$k]) && $input[$k]) ? $input[$k] : '', 
          $group, 
          isset($field['is_json']) ? $field['is_json'] : false 
        );
    }
}

Cache::forget('setting');

$settings = setting($keyList);

return [
      'message'=>apiMessage('Save Change success.'),
      'row'=>$settings,
      'error'=>0
];