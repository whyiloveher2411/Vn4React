<?php

add_filter('settings_link',function($settings_link) use ($plugin) {

	$settings_link[] = [
		'title'=>'Payment',
		'icon'=>'<i class="fa fa-credit-card" aria-hidden="true"></i>',
		'description'=>'Enable and manage your store\'s payment providers',
		'submenu'=>[
			['title'=>'Settings','link'=>route('admin.plugin.controller',['plugin'=>$plugin->key_word,'controller'=>'setting','method'=>'payments'])],
			['title'=>'Transactions','link'=>route('admin.show_data',['post_type'=>'payment_transaction'])],
		]
	];

	return $settings_link;

});
