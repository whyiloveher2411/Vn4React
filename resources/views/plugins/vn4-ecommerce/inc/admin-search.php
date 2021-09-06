<?php

return [
	'ecom'=>['title'=>'E-commerce','callback'=>function( $searchArray, $searchString ) use ($plugin){

		return [
			[
				'title_type'=>'E-commerce',
				'title'=>'Order',
				'link'=>'/post-type/ecommerce_review/list',
			],
			[
				'title_type'=>'E-commerce',
				'title'=>'Product',
				'link'=>'/post-type/ecom_prod/list',
			],
		];
		

	}]
];