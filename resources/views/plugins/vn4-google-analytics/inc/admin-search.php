<?php

return [
	'analytics'=>['title'=>'Google Analytics','callback'=>function( $searchArray, $searchString ) use ($plugin){

		return [
			[
				'title_type'=>'Analytics',
				'title'=>'Settings',
				'link'=>'/settings/google-analytics/analytics',
			],
			[
				'title_type'=>'Analytics',
				'title'=>'Realtime',
				'link'=>'/plugin/vn4-google-analytics/realtime',
			],
			[
				'title_type'=>'Analytics',
				'title'=>'Reports',
				'link'=>'/plugin/vn4-google-analytics/reports',
			],
		];
		

	}]
];