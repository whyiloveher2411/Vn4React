<?php

add_filter('settings_link',function($settings_link) use ($plugin) {

	$settings_link[] = [
		'title'=>'Custom Fields',
		'link'=>route('admin.show_data','ace_custom_fields'),
		'icon'=>'<i class="fa fa-cogs"></i>',
		'description'=>'List, edit custom fields for post types'
	];

	return $settings_link;

});
