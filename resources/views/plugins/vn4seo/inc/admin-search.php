<?php

return [
	'seo'=>['title'=>'SEO','callback'=>function( $searchArray, $searchString ) use ($plugin){

		return [
			[
				'title_type'=>'Vn4SEO',
				'title'=>'Settings',
				'link'=>'/plugin/vn4seo/settings',
			],
			[
				'title_type'=>'Vn4SEO',
				'title'=>'Performance',
				'link'=>'/plugin/vn4seo/performance',
			],
			[
				'title_type'=>'Vn4SEO',
				'title'=>'Measure',
				'link'=>'/plugin/vn4seo/measure/performance',
			],
		];
		

	}]
];