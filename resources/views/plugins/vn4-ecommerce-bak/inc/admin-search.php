<?php

return [
	'ecom'=>['title'=>'E-commerce','callback'=>function( $searchArray, $searchString ) use ($plugin){

		return [
			[
				'title_type'=>'E-commerce',
				'title'=>'Order',
				'link'=>'#',
			],
			[
				'title_type'=>'E-commerce',
				'title'=>'Catalog',
				'link'=>'#',
			],
			[
				'title_type'=>'E-commerce',
				'title'=>'Reports',
				'link'=>'#',
			],
		];
		

	}]
];