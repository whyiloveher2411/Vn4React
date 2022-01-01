<?php

$r = request();

$input = json_decode($r->getContent(),true);

if( isset($input['renderDate']) ){
	return [
		'date'=>date($input['renderDate'])
	];
}

include __DIR__.'/_helper.php';

$group = $r->get('group');
$subGroup = $r->get('subGroup');

$data = getDataSetting( $group, $subGroup );

$settingKeys = [];

foreach( $data['config'] as $indexGroup => $groupField ){
	if( isset($groupField['fields']) && !empty($groupField['fields']) ){
		foreach($groupField['fields'] as $key => $field){
			$settingKeys[] = $key;
	
			if( isset($field['saveCallback']) ){
				unset( $data['config'][$indexGroup][$key]['saveCallback'] );
			}
		}
	}
}

$settings = setting($settingKeys);

$data['row'] = $settings;

return $data;