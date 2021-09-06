<?php

add_filter('settings_link',function($settings_link) use ($plugin) {

	$settings_link[] = [
		'title'=>'Debug',
		'link'=>route('admin.plugins.'.$plugin->key_word.'.index'),
		'popup'=>true,
		'icon'=>'<i class="fa fa-bug"></i>',
		'description'=>'Settings for debug plugin'
	];

	return $settings_link;

});
