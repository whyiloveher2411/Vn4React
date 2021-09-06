<?php

register_post_type(function($list_post_type) use ($plugin) {

	$add_object = [];

	$add_object[] = [
			'payment_transaction',
	    	1,
			[
		    'table'=>'payment_transaction',
		    'title'=> 'Transaction',
		    'fields'=>[
		        'title'=>[
		            'title'=>__('Title'),
		            'view'=>'text',
		            'length'=>60,
		            'unique'=>'pay_id_unique',
		        ],
		        'description'=>[
		        	'title'=>'Description',
		        	'view'=>'text',
		        ],
		        'method' => [
		            'title'=>__('Method'),
		            'view' =>'text',
		        ],
		        'currency'=>[
		        	'title'=>'Currency',
		        	'view'=>'text',
		        ],
		        'shipping'=>[
		        	'title'=>'Shipping',
		        	'view'=>'text',
		        ],
		        'tax'=>[
		        	'title'=>'Tax',
		        	'view'=>'text',
		        ],
		        'sub_total'=>[
		        	'title'=>'Sub Total',
		        	'view'=>'text',
		        ],
		        'total'=>[
		        	'title'=>'Total',
		        	'view'=>'text',
		        ],
		        'payment_status'=>[
		        	'title'=>'Payment Status',
		        	'view'=>'select',
		        	'list_option'=>[
		        		'initialization'=>'Initialization',
		        		'error'=>'Error',
		        		'created'=>'Created',
		        		'approved'=>'Approved',
		        		'disapproved'=>'Disapproved',
		        	],
		        	'list_color'=>[
		        		'initialization'=>'#ababab',
		        		'error'=>'#e85342',
		        		'created'=>'#11960f',
		        		'approved'=>'#448fea',
		        		'disapproved'=>'#ffc800',
		        	],
		        ],
		        'payment_object'=>[
		        	'title'=>'Payment Object',
		        	'view'=>'editor',
		        	'show_data'=>false,
		        ],
		        'result' => [
		            'title'=>'Result',
		            'view' =>'json',
		        	'show_data'=>false,
		        ],
		        'log'=>[
		        	'title'=>'Log',
		        	'view'=>'json',
		        	'show_data'=>false,
		        ]
		    ],
		    'row_actions'=>function($post, $row_actions) use ($plugin) {
		    	$row_actions['get-payment-detail'] = '<a href="'.route('admin.plugin.controller',['plugin'=>$plugin->key_word, 'controller'=>'payment','method'=>'get-info','transactionId'=>$post->id]).'" data-message="The process is running, please wait a moment">CURL Payment Detail</a>';

		    	return $row_actions;
		    }
		]
	];

	return $add_object;

});
