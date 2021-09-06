<?php

register_post_type(function($list_post_type) use ($plugin) {

	$add_object = [];

	$add_object[] = [
			'ecommerce_product',
	    	1,
			[
		    'table'=>'ecommerce_product',
		    'title'=> __p('Product',$plugin->key_word),
		    'show'=>function($post){
				return '<img style="max-height: 70px;" src="'.get_media($post['thumbnail']??'',asset('admin/images/img_not_found.jpg')).'">
						<div style="text-align:left;">'.($post['title']??'').'<br><del style="text-decoration: line-through;color:red;">'.(ecommerce_price($post['price']??0)).'</del> - <span style="color:green">'.(ecommerce_price($post['sale_price']??0)).'</span></div>';
			},
		    'fields'=>[
		        'title'=>[
		            'title'=>__('Title'),
		            'view'=>'text',
		        ],
		        'slug' => [
		            'title'=>__('Slug'),
		            'view' =>'slug',
		            'key_slug'=>'title',
		        ],
		        'description' => [
		            'title'=>__('Description'),
		            'view' =>'textarea',
		            'show_data'=>false,
		        ],
		        'product_type'=>[
		        	'title'=>'Product Type',
		        	'view'=>'hidden',
		        	'data_type'=>'custom',
		        	'type'=>'text',
		        	'length'=>20,
		        ],
		        'price'=>[
		        	'title'=>'Price',
		        	'view'=>'hidden',
		        	'data_type'=>'custom',
		        	'type'=>'text',
		        	'length'=>20,
		        	'show_data'=>function($post){

						$meta = $post->getMeta('product-info');

						if( isset($meta['price_min']) && isset($meta['sale_price_min']) ){

							if( $meta['price_min'] === $meta['price_max'] ) $price = ecommerce_price($meta['price_min']);
							else $price = ecommerce_price($meta['price_min']).' - '.ecommerce_price($meta['price_max']);

							if( $meta['sale_price_min'] === $meta['sale_price_max'] ) $sale_price = ecommerce_price($meta['sale_price_min']);
							else $sale_price = ecommerce_price($meta['sale_price_min']).' - '.ecommerce_price($meta['sale_price_max']);

							if( $price !== $sale_price ){
								return '<del style="text-decoration: line-through;color:red;">'.$price.'</del><p style="color:green">'.$sale_price.'</p>';
							}else{
								return '<p style="color:green">'.$price.'</p>';
							}

						}
					},
		        ],
		        'sale_price'=>[
		        	'title'=>'Sale Price',
		        	'view'=>'hidden',
		        	'data_type'=>'custom',
		        	'type'=>'text',
		        	'length'=>20,
		        	'show_data'=>false,
		        ],
		        'question_and_answer'=>[
		        	'title'=>'Question and Answer',
		        	'view'=>'repeater',
		        	'sub_fields'=>[
		        		'question'=>['title'=>'Question'],
		        		'answer'=>['title'=>'Answer','view'=>'textarea'],
		        	],
		        	'show_data'=>false,
		        ],
	         	'ecommerce_category' => [
		            'title'=>__('Category'),
		            'view' =>'relationship_onetomany',
		            'show_data'=>false,
		            'object'=>'ecommerce_category',
		        	'advance'=>'right',
		        ],
		        'ecommerce_tag' => [
		            'title'=>__('Tag'),
		            'view' =>'relationship_manytomany',
		            'show_data'=>false,
		            'type'=>'tags',
		            'object'=>'ecommerce_tag',
		        	'advance'=>'right',
		        ],
		        'thumbnail'=>[
		        	'title'=>'Thumbnail',
		        	'view'=>'image',
		        	'advance'=>'right',
		            'show_data'=>false,
		        ],
		        'gallery'=>[
		        	'title'=>'Gallery',
		        	'view'=>'image',
		        	'advance'=>'right',
		        	'multiple'=>true,
		            'show_data'=>false,
		        ],
		        'reviews'=>[
		        	'title'=>'Reviews',
		        	'view'=>'relationship_onetomany_show',
		        	'object'=>'ecommerce_review',
		        	'field'=>'ecommerce_product',
		            'show_data'=>false,
		        ],
		        'detailed_overview'=>[
		        	'title'=>'Detailed Overview',
		        	'view'=>'editor',
		            'show_data'=>false,
		        ],
		        'detailed_specifications'=>[
		        	'title'=>'Detailed specifications',
		        	'view'=>'json',
		        	'type'=>'mediumText',
		            'show_data'=>false,
		        ],
		        'detailed_filters'=>[
		            'title'=>'Detailed Filters',
		        	'view'=>'relationship_manytomany',
		        	'object'=>'ecommerce_filter_value',
		        	'type'=>'many_record',
		            'show_data'=>false,
		        ],
		    ],
		    'tabs'=>[
		        'genarel'=>[ 'title'=>'<i class="fa fa-globe" aria-hidden="true"></i>Genarel', 'fields'=>['title','slug','description'] ],
		        'image'=>[ 'title'=>'<i class="fa fa-file-image-o" aria-hidden="true"></i>Image', 'fields'=>['thumbnail','gallery'] ],
		        'detail'=>['title'=>'<i class="fa fa-info" aria-hidden="true"></i>Detail','fields'=>['detailed_overview']],
		        'categories'=>[ 'title'=>'<i class="fa fa-list" aria-hidden="true"></i>Categories', 'fields'=>['ecommerce_category','ecommerce_tag'] ],
		        'specifications'=>['title'=>'<i class="fa fa-cogs" aria-hidden="true"></i>Specifications','fields'=>['detailed_specifications']],
		        'filters'=>['title'=>'<i class="fa fa-filter" aria-hidden="true"></i>Filters','fields'=>['detailed_filters']],
		        'reviews'=>['title'=>'<i class="fa fa-star-half-o" aria-hidden="true"></i>Reviews','fields'=>['reviews']],
		        'qa'=>[ 'title'=>'<i class="fa fa-question" aria-hidden="true"></i>Q&A', 'fields'=>['question_and_answer'] ],
		    ],
		    'row_actions'=>function($post, $actions){
				$actions['report'] = '<a class="" href="#">Report</a>';
				return $actions;
			},
		]
	];

	$add_object[] = [
			'ecommerce_product_variable',
	    	1,
			[
		    'table'=>'ecommerce_product_variable',
		    'title'=> __p('Product Variable',$plugin->key_word),
		    'fields'=>[
		        'title'=>[
		            'title'=>'Title (SKU)',
		            'view'=>'text',
		        ],
		        'description' => [
		            'title'=>__('Description'),
		            'view' =>'textarea',
		            'show_data'=>false,
		        ],
		        'price' => [
		            'title'=>'Price',
		            'view' =>'text',
		        ],
		        'sale_price'=>[
		        	'title'=>'Sale Price',
					'view'=>'text',
		        ],
		        'thumbnail'=>[
		        	'title'=>'Thumbnail',
		        	'view'=>'image',
		        	'advance'=>'right',
		            'show_data'=>false,
		        ],
		        'images'=>[
		        	'title'=>'Images',
		        	'view'=>'image',
		        	'advance'=>'right',
		        	'multiple'=>true,
		            'show_data'=>false,
		        ],
		       	'weight'=>[
		       		'title'=>'Weight',
		       		'view'=>'text',
		       	],
		       	'length'=>[
		       		'title'=>'Length',
		       		'view'=>'text',
		       	],
		       	'width'=>[
		       		'title'=>'Width',
		       		'view'=>'text',
		       	],
		       	'height'=>[
		       		'title'=>'Height',
		       		'view'=>'text',
		       	],
		       	'check_list' => [
					'title'=>'Check List',
					'view'=>'checkbox',
					'layout'=>'horizontal',
					'list_option'=>[
						'enabled'=>'Enabled',
						'downloadable'=>'Downloadable',
						'virtual'=>'Virtual',
						'manage_stock'=>'Manage Stock',
					]
				],
				'stock_status' => [
					'title'=>'Stock Status',
					'view'=>'select',
					'list_option'=>[
						'instock'=>'In Stock',
						'outofstock'=>'Outof Stock',
						'onbackorder'=>'On Back Order',
					]
				],
				'stock'=>[
					'title'=>'Số lượng trong kho',
					'view'=>'number'
				],
				'shipping' => [
					'title'=>'shipping',
					'view'=>'select',
					'list_option'=>[
						'-1'=>'Tương tự bản gốc',
					]
				],
				'download_file' => [
					'title'=>'Các tập tin có thể tải xuống',
					'view'=>'repeater',
					'sub_fields'=>[
						'name'=>['title'=>'Name'],
						'file'=>['title'=>'File','view'=>'asset-file'],
					]
				],
				'download_limit' => [
					'title'=>'Giới hạn số lần tải xuống',
					'view'=>'text',
				],
				'download_expiry' => [
					'title'=>'Giới hạn ngày tải xuống',
					'view'=>'text',
				],
		        'ecommerce_product' => [
		            'title'=>'Product',
		            'view' =>'relationship_onetomany',
		            'show_data'=>false,
		            'type'=>'many_record',
		            'object'=>'ecommerce_product',
		        	'advance'=>'right',
		        ],
		        'attribute_value' => [
		            'title'=>'Product Attribute Value',
		            'view' =>'relationship_manytomany',
		            'type'=>'many_record',
		            'show_data'=>false,
		            'object'=>'ecommerce_product_attribute_value',
		        	'advance'=>'right',
		        ],
		    ],
		    'layout_custom'=> [
				[ [ 'col-md-6',[ 
					['col-md-12','check_list'],
					['col-md-12','title'],
					['col-md-6','price'],
					['col-md-6','sale_price'], 
					['col-md-12','stock_status'],
					['col-md-12','stock'],
					['col-md-12','weight'],
					['col-md-4','length'],
					['col-md-4','width'],
					['col-md-4','height'],
					['col-md-12','shipping'],
				]],[ 'col-md-6', [  ['col-md-12','thumbnail'] , ['col-md-12','images'] ] ] ],
				[ ['col-md-12','description'] ],
				[ ['col-md-12','download_file'] ],
				[ ['col-md-6','download_limit'], ['col-md-6','download_expiry'] ]
			]
		]
	];

	$add_object[] =  [
		'ecommerce_product_attribute',
    	1,
    	[
		    'table'=>'ecommerce_product_attribute',
		    'title'=> __('Attribute'),
		    'way_show'=>'title',
		    'template'=>'plugins.vn4-ecommerce.views.frontend.attributes',
		    'fields'=>[
		        'title'=>[
		            'title'=>__('Title'),
		            'view'=>'text',
		            'required'=>true,
		            'note'=>'Tên riêng sẽ hiển thị trên trang mạng của bạn.',
		        ],
		        'slug' => [
		            'title'=>'Slug',
		            'view' =>'slug',
		            'key_slug'=> 'title',
		            'type' =>'text',
		        ],
		        'sku_code'=>[
		        	'title'=>'SKU Code',
		        	'view'=>'text',
		        	'unique'=>'sku_code_unique',
		        ],
		        'description' => [
		            'title'=>__('Description'),
		            'show_data'=>false,
		            'view' =>'textarea',
		            'note'=>'Mô tả bình thường không được sử dụng trong giao diện, tuy nhiên có vài giao diện hiện thị mô tả này.',
		        ],
		        'values' => [
		            'title'=>__('Values'),
		            'view' =>'relationship_onetomany_show',
		            'show_data'=>false,
		            'object'=>'ecommerce_product_attribute_value',
		            'field'=>'ecommerce_product_attribute',
		        ],
		    ],
		]
	];

	$add_object[] =  [
		'ecommerce_filter',
    	1,
    	[
		    'table'=>'ecommerce_filter',
		    'title'=> __('Filter'),
		    'way_show'=>'title',
		    'fields'=>[
		        'title'=>[
		            'title'=>__('Title'),
		            'view'=>'text',
		            'required'=>true,
		            'note'=>'Tên riêng sẽ hiển thị trên trang mạng của bạn.',
		        ],
		        'slug' => [
		            'title'=>'Slug',
		            'view' =>'slug',
		            'key_slug'=> 'title',
		            'type' =>'text',
		        ],
		        'description' => [
		            'title'=>__('Description'),
		            'show_data'=>false,
		            'view' =>'textarea',
		            'note'=>'Mô tả bình thường không được sử dụng trong giao diện, tuy nhiên có vài giao diện hiện thị mô tả này.',
		        ],
		        'values' => [
		            'title'=>__('Values'),
		            'view' =>'relationship_onetomany_show',
		            'show_data'=>false,
		            'object'=>'ecommerce_filter_value',
		            'field'=>'ecommerce_filter',
		        ],
		    ],
		]
	];

	$add_object[] =  [
		'ecommerce_filter_value',
    	1,
    	[
		    'table'=>'ecommerce_filter_value',
		    'title'=> __('Filters Value'),
		    'way_show'=>'title',
		    'fields'=>[
		        'title'=>[
		            'title'=>__('Title'),
		            'view'=>'text',
		            'required'=>true,
		            'note'=>'Tên riêng sẽ hiển thị trên trang mạng của bạn.',
		        ],
		        'slug' => [
		            'title'=>'Slug',
		            'view' =>'slug',
		            'key_slug'=> 'title',
		            'type' =>'text',
		            'note'=>'Chuỗi cho đường dẫn tĩnh là phiên bản của tên hợp chuẩn với Đường dẫn (URL). Chuỗi này bao gồm chữ cái thường, số và dấu gạch ngang (-).'
		        ],
		        'description' => [
		            'title'=>__('Description'),
		            'show_data'=>false,
		            'view' =>'textarea',
		            'note'=>'Mô tả bình thường không được sử dụng trong giao diện, tuy nhiên có vài giao diện hiện thị mô tả này.',
		        ],
		        'ecommerce_filter' => [
		            'title'=>__('Filter Group'),
		            'view' =>'relationship_onetomany',
		            'show_data'=>false,
		            'object'=>'ecommerce_filter',
		        ],
		    ],
		]
	];

	
	$add_object[] =  [
		'ecommerce_product_attribute_value',
    	1,
    	[
		    'table'=>'ecommerce_product_attribute_value',
		    'title'=> __('Attribute Value'),
		    'way_show'=>'title',
		    'fields'=>[
		        'title'=>[
		            'title'=>__('Title'),
		            'view'=>'text',
		            'required'=>true,
		            'note'=>'Tên riêng sẽ hiển thị trên trang mạng của bạn.',
		        ],
		        'slug' => [
		            'title'=>'Slug',
		            'view' =>'slug',
		            'key_slug'=> 'title',
		            'type' =>'text',
		            'note'=>'Chuỗi cho đường dẫn tĩnh là phiên bản của tên hợp chuẩn với Đường dẫn (URL). Chuỗi này bao gồm chữ cái thường, số và dấu gạch ngang (-).'
		        ],
		        'description' => [
		            'title'=>__('Description'),
		            'show_data'=>false,
		            'view' =>'textarea',
		            'note'=>'Mô tả bình thường không được sử dụng trong giao diện, tuy nhiên có vài giao diện hiện thị mô tả này.',
		        ],
		        'ecommerce_product_attribute' => [
		            'title'=>__('Product Attribute'),
		            'view' =>'relationship_onetomany',
		            'show_data'=>false,
		            'object'=>'ecommerce_product_attribute',
		        ],
		    ],
		]
	];

	// $add_object[] =  [
	// 	'ecommerce_product_attribute_sets',
 //    	1,
 //    	[
	// 	    'table'=>'ecommerce_product_attribute_sets',
	// 	    'title'=> __('Attribute Sets'),
	// 	    'way_show'=>'title',
	// 	    'fields'=>[
	// 	        'title'=>[
	// 	            'title'=>__('Title'),
	// 	            'view'=>'text',
	// 	            'required'=>true,
	// 	        ],
	// 	        'slug' => [
	// 	            'title'=>'Slug',
	// 	            'view' =>'slug',
	// 	            'key_slug'=> 'title',
	// 	            'type' =>'text',
	// 	        ],
	// 			'description' => [
	// 	            'title'=>__('Description'),
	// 	            'view' =>'textarea',
	// 	            'show_data'=>false,
	// 	        ],
	// 	        'groups_attribute'=>[
	// 	        	'title'=>'Group Attribute',
	// 	        	'view'=>'repeater',
	// 	        	'sub_fields'=>[
	// 	        		'title'=>['title'=>'Title'],
	// 	        		// 'attributes'=>[
	// 	        		// 	'title'=>'Attributes',
	// 	        		// 	'view'=>'repeater',
	// 	        		// 	'sub_fields'=>[
	// 	        		// 		'title'=>['title'=>'Title'],
	// 	        		// 		'placeholder'=>['title'=>'Placeholder'],
	// 	        		// 	]
	// 	        		// ],

	// 	        		'attributes'=>[
	// 	        			'title'=>'Attributes',
	// 	        			'view'=>'flexible',
	// 	        			'templates'=>[
	// 	        				'text'=>[
	// 	        					'title'=>'Text',
	// 	        					'items'=>[ 'title'=>['title'=>'Title'], 'placeholder'=>['title'=>'Placeholder']]
	// 	        				],
	// 	        				'select'=>[
	// 	        					'title'=>'Select',
	// 	        					'items'=>[ 
	// 	        						'title'=>[
	// 	        							'title'=>'Title',
	// 	        							'view'=>'textarea',
	// 	        						],
	// 	        					]
	// 	        				]
	// 	        			]
	// 	        		],
	// 	        	],
	// 	            'show_data'=>false,
	// 	        ],
	// 	    ],
	// 	]
	// ];

	$add_object[] = [
		'ecommerce_category',
    	1,
    	[
		    'table'=>'ecommerce_category',
		    'title'=>__('Category'),
		    'fields'=>[
		        'title'=>[
		            'title'=>__('Title'),
		            'view'=>'text',
		            'required'=>true,
		            'note'=>'Tên riêng sẽ hiển thị trên trang mạng của bạn.',
		        ],
		        'slug' => [
		            'title'=>'Slug',
		            'view' =>'slug',
		            'key_slug'=> 'title',
		            'type' =>'text',
		            'note'=>'Chuỗi cho đường dẫn tĩnh là phiên bản của tên hợp chuẩn với Đường dẫn (URL). Chuỗi này bao gồm chữ cái thường, số và dấu gạch ngang (-).',
		        ],
		        'parent' => [
		            'title'=>__('Parent'),
		            'view' =>'relationship_onetomany',
		            'show_data'=>false,
		            'object'=>'ecommerce_category',
		            'note'=>'Chuyên mục khác với thẻ, bạn có thể sử dụng nhiều cấp chuyên mục. Ví dụ: Trong chuyên mục nhạc, bạn có chuyên mục con là nhạc Pop, nhạc Jazz. Việc này hoàn toàn là tùy theo ý bạn.',

		        ],
		        'description' => [
		            'title'=>__('Description'),
		            'show_data'=>false,
		            'view' =>'textarea',
		            'note'=>'Mô tả bình thường không được sử dụng trong giao diện, tuy nhiên có vài giao diện hiện thị mô tả này.',
		        ],
		        'use_attribute_parent'=>[
		        	'title'=>'Use Attribute Sets Parent',
		        	'view'=>'true_false',
		        ],
		        'groups_attribute'=>[
		        	'title'=>'Group Attribute',
		        	'view'=>'repeater',
		        	'sub_fields'=>[
		        		'title'=>['title'=>'Title'],
		        		'attributes'=>[
		        			'title'=>'Attributes',
		        			'view'=>'repeater',
		        			'sub_fields'=>[
		        				'title'=>['title'=>'Title'],
		        				'placeholder'=>['title'=>'Placeholder'],
		        			]
		        		],
		        	],
		            'show_data'=>false,
		        ],
		        'filters'=>[
		        	'title'=>'Filters',
		        	'view'=>[
		        		'form'=>function($data) use ($plugin) {
		        			return view_plugin($plugin, 'views.Category.filters',['data'=>$data]);
		        		},
		        		'post'=>function($data){
		        			$data['filter_value'] = Request::get('filter_value_',[]);
		        			return $data;
		        		}
		        	],
		        	// 'templates'=>[
		        	// 	'relationship'=>[
		        	// 		'title'=>'Relationship',
		        	// 		'items'=>[
		        	// 			'post-type'=>['title'=>'Post Type','view'=>'select','list_option'=>['ecommerce_category'=>'Category','ecommerce_brand'=>'Brand']]
		        	// 		]
		        	// 	],
		        	// 	'attribute'=>[
		        	// 		'title'=>'Attribute',
		        	// 		'items'=>[
		        	// 			'title'=>['title'=>'Title'],
		        	// 			'values'=>[
		        	// 				'title'=>'Values',
		        	// 				'view'=>'repeater',
		        	// 				'sub_fields'=>[
						     //    		'values'=>[
						     //    			'title'=>'Values',
						     //    			'view'=>'repeater',
						     //    			'width_column'=>'70%',
						     //    			'sub_fields'=>[
						     //    				'title'=>['title'=>'Title'],
						     //    			]
						     //    		],
						     //    	],
		        	// 			]
		        	// 		]
		        	// 	]
		        	// ],

		        	// 'sub_fields'=>[
		        	// 	'title'=>['title'=>'Title'],
		        	// 	'values'=>[
		        	// 		'title'=>'Values',
		        	// 		'view'=>'repeater',
		        	// 		'width_column'=>'70%',
		        	// 		'sub_fields'=>[
		        	// 			'title'=>['title'=>'Title'],
		        	// 		]
		        	// 	],
		        	// ],
		            'show_data'=>false,
		        ],
		        'filter_value'=>[
		        	'title'=>'Filter Value',
		        	'view'=>'hidden',
		        	'data_type'=>'repeater',
		        ]
		    ],
	    ]
	];

	$add_object[] =  [
		'ecommerce_tag',
    	1,
    	[
		    'table'=>'ecommerce_tag',
		    'title'=> __('Tag'),
		    'way_show'=>'title',
		    'fields'=>[
		        'title'=>[
		            'title'=>__('Title'),
		            'view'=>'text',
		            'required'=>true,
		            'note'=>'Tên riêng sẽ hiển thị trên trang mạng của bạn.',
		        ],
		        'slug' => [
		            'title'=>'Slug',
		            'view' =>'slug',
		            'key_slug'=> 'title',
		            'type' =>'text',
		            'note'=>'Chuỗi cho đường dẫn tĩnh là phiên bản của tên hợp chuẩn với Đường dẫn (URL). Chuỗi này bao gồm chữ cái thường, số và dấu gạch ngang (-).'
		        ],
		        'description' => [
		            'title'=>__('Description'),
		            'show_data'=>false,
		            'view' =>'textarea',
		            'note'=>'Mô tả bình thường không được sử dụng trong giao diện, tuy nhiên có vài giao diện hiện thị mô tả này.',
		        ],
		        'products'=>[
		        	'title'=>'Products',
		        	'view'=>'relationship_manytomany_show',
		        	'object'=>'ecommerce_product',
		        	'field'=>'ecommerce_tag',
		            'show_data'=>false,
		        ],
		    ],
		]
	];


	$add_object[] = [
		'ecommerce_review',
		1,
		[
			'table'=>'ecommerce_review',
			'title'=> __('Review'),
			'slug'=>'review',
			'fields'=>[
				'title'=>[
					'title'=>'Summary of Review',
					'view'=>'text',
					'required'=>true,
				],
				'rating'=>[
					'title'=>'Rating',
					'view'=>'number',
				],
				'review_status'=>[
					'title'=>'Status',
					'view'=>'select',
					'list_option'=>[
						'approved'=>['title'=>'Approved','color'=>'#11960f'],
						'pending'=>['title'=>'Pending','color'=>'#448fea'],
						'not-approved'=>['title'=>'Not Approved','color'=>'#ababab']
					],
				],
				'detail'=>[
					'title'=>'Detail',
					'view'=>'textarea',
				],
				'ecommerce_customer'=>[
					'title'=>'Customer',
					'view'=>'relationship_onetomany',
					'object'=>'ecommerce_customer',
					'type'=>'many_record',
					'fields_related'=>['title'],
					'advance'=>'right',
				],
				'ecommerce_product' => [
					'title'=>__('Product'),
					'view' =>'relationship_onetomany',
					'show_data'=>true,
					'object'=>'ecommerce_product',
					'type'=>'many_record',
					'fields_related'=>['title'],
					'advance'=>'right',
				],
			]
		]
	];

	$add_object[] = [
		'ecommerce_customer',
		1,
		[
			'table'=>'ecommerce_customer',
			'slug'=>'customer',
			'title'=> __('Customer'),
			'fields'=>[
				'title'=>[
					'title'=>'Email',
					'view'=>'text',
					'required'=>true,
				],
				'first_name'=>[
					'title'=>'First Name',
					'view'=>'text',
					'required'=>true,
				],
				'last_name'=>[
					'title'=>'Last Name',
					'view'=>'text',
					'required'=>true,
				],
				'slug' => [
					'title'=>__('Slug'),
					'view' =>'slug',
					'key_slug'=>'title',
					'type' => 'text',
					'show_data'=>false,
				],
				'birthday'=>[
					'title'=>'Birthday',
					'view'=>'input',
					'type'=>'date',
				],
				'gender'=>[
					'title'=>'Gender',
					'view'=>'select',
					'list_option'=>[
						'male'=>['title'=>'Male','color'=>'#e85342'],
						'female'=>['title'=>'Female','color'=>'#448fea'],
						'not-specified'=>['title'=>'Not Specified','color'=>'#ababab']
					],
				],
				'password'=>[
					'title'=>'Password',
					'view'=>'password',
					'show_data'=>false,
				],
			]
		]
	];

	return $add_object;

});
