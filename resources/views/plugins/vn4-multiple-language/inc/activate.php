<?php

$admin_object = get_admin_object();

$postAddLanguage = $plugin->getMeta('custom-post-types');

if( !is_array($postAddLanguage) ) $postAddLanguage = [];

foreach ($admin_object as $key => $objectConfig) {

	if( array_search($key, $postAddLanguage) !== false ){

		Schema::table($objectConfig['table'], function($table) use ($objectConfig)
		{
			if( Schema::hasColumn( $objectConfig['table'], 'language' ) ){
				$table->string('language',255)->after('type')->default(null)->nullable()->change();
			}else{
				$table->string('language',255)->after('type')->default(null)->nullable();
			}

		});

	}
}