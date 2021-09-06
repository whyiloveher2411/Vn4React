<?php

return [
	'theme'=>['title'=>'Search From Theme','callback'=>function( $searchArray, $searchString ) use ($plugin){
			return [
				[
					'title_type'=>'Theme',
					'title'=>'Giới Thiệu',
					'link'=>'#',
				],
			];
		}
	]
];