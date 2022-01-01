<?php

return [
	'plugindemo'=>['title'=>'Search From Plugin Demo','callback'=>function( $searchArray, $searchString ) use ($plugin){
			return [
				[
					'title_type'=>'Plugin demo',
					'title'=>'Search From Plugin Demo',
					'link'=>'#',
				],
			];
		}
	]
];