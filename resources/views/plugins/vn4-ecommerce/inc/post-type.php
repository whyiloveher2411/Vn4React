<?php

register_post_type(function($list_post_type) use ($plugin) {

	$add_object = [];

	$add_object[] = [
			'ecom_prod',
	    	1,
			[
		    'table'=>'ecom_prod',
		    'title'=> __p('Product',$plugin->key_word),
			'public_view'=>true,
			'slug'=>'product',
			'dialogContent'=>[
				'width'=>1200
			],
		    'fields'=>[
		        'title'=>[
		            'title'=>__('Title'),
		            'view'=>'text',
					'customViewList'=>'PostType/EcomProd/Title',
		        ],
		        'slug' => [
		            'title'=>__('Slug'),
		            'view' =>'slug',
		            'key_slug'=>'title',
		            'show_data'=>false,
		        ],
		        'description' => [
		            'title'=>__('Description'),
		            'view' =>'textarea',
		            'show_data'=>false,
		        ],
		        'product_type'=>[
		        	'title'=>'Product Type',
					'view'=>'text',
					'hidden'=>true,
		            'show_data'=>false,
		        ],
				'virtual_product'=>[
					'title'=>'Virtual product',
					'view'=>'true_false',
		            'show_data'=>false,
					'hidden'=>true,
				],
				'downloadable_product'=>[
					'title'=>'Downloadable product',
					'view'=>'true_false',
		            'show_data'=>false,
					'hidden'=>true,
				],
		        'price'=>[
		        	'title'=>'Price',
		        	'view'=>'number',
					'type'=>'decimal',
					'decimal'=>[20, 6],
					'hidden'=>true,
					'customViewList'=>'PostType/EcomProd/Views/Price'
		        ],
				'compare_price'=>[
					'title'=>'Compare at Price',
		        	'view'=>'number',
					'type'=>'decimal',
					'decimal'=>[20, 6],
					'hidden'=>true,
		        	'show_data'=>false,
				],
				'cost'=>[
					'title'=>'cost',
		            'view'=>'number',
					'type'=>'decimal',
					'decimal'=>[20, 6],
					'hidden'=>true,
		        	'show_data'=>false,
				],
				'profit'=>[
					'title'=>'Profit',
		            'view'=>'number',
					'type'=>'decimal',
					'decimal'=>[20, 6],
					'hidden'=>true,
		        	'show_data'=>false,
				],
				'profit_margin'=>[
					'title'=>'Profit Margin',
		            'view'=>'number',
					'type'=>'float',
					'float'=>[10, 2],
					'hidden'=>true,
		        	'show_data'=>false,
				],
	         	'ecom_prod_cate' => [
		            'title'=>__('Category'),
		            'view' =>'relationship_onetomany',
		            'show_data'=>false,
		            'object'=>'ecom_prod_cate',
					'hierarchical'=>'parent',
		        ],
		        'ecom_prod_tag' => [
		            'title'=>__('Tag'),
		            'view' =>'relationship_manytomany',
		            'show_data'=>false,
		            'type'=>'tags',
		            'object'=>'ecom_prod_tag',
		        ],
		        'thumbnail'=>[
		        	'title'=>'Thumbnail',
		        	'view'=>'image',
		            'show_data'=>false,
		        ],
		        'gallery'=>[
		        	'title'=>'Gallery',
		        	'view'=>'image',
		        	'multiple'=>true,
		            'show_data'=>false,
		        ],
		        'detailed_filters'=>[
		            'title'=>'Detailed Filters',
		        	'view'=>'relationship_manytomany',
		        	'object'=>'ecom_prod_filter_value',
		            'show_data'=>false,
		        ],
				'ecom_prod_detail'=>[
					'title'=>'Product Detail',
					'view'=>'relationship_onetoone_show',
					'field'=>'ecom_prod_detail',
					'object'=>'ecom_prod_detail',
					'hidden'=>true,
					'show_data'=>false,
				],
				'ecom_prod_spec_sets'=>[
					'title'=>'Specifications Sets',
					'view'=>'relationship_onetomany',
					'object'=>'ecom_prod_spec_sets',
					'show_data'=>false,
				]
		    ],
		    'tabs'=>[
				'general'=>[ 'title'=>'General', 'fields'=>['title','slug','description'] ],
		        'image'=>[ 'title'=>'Image', 'fields'=>['thumbnail','gallery'] ],
		        'categories'=>[ 'title'=>'Categories', 'fields'=>['ecom_prod_cate', 'ecom_prod_tag', 'ecom_prod_spec_sets'] ],
		        'filters'=>['title'=>'Filters','fields'=>['detailed_filters']],
		    ],
			// 'tabSummary'=>[
			// 	'summary'=>['title'=>'Summary'],
			// 	'insights'=>['title'=>'Insights', 'content'=>'Vn4EcommerceProductInsights' ],
			// 	'inventory'=>['title'=>'Inventory','content'=>'Vn4EcommerceProductInventory'],
			// 	'reviews'=>['title'=>'Reviews','content'=>'Vn4EcommerceProductReviews'],
			// 	'customers'=>['title'=>'Customers','content'=>'Vn4EcommerceProductInventory'],
			// 	// 'seo'=>['title'=>'SEO Performance','content'=>'Vn4EcommerceProductInventory'],
			// 	// 'ga-reports'=>['title'=>'Google Analytics reports','content'=>'Vn4EcommerceProductInventory'],
			// 	// 'ga-realtime'=>['title'=>'Google Analytics Realtime','content'=>'Vn4EcommerceProductInventory'],
			// ],
		]
	];

	$add_object[] = [
		'ecom_prod_detail',
		1,
		[
			'table'=>'ecom_prod_detail',
			'title'=>'Product Detail',
			'fields'=>[
				'title'=>[
		            'title'=>__('Title'),
		            'view'=>'text',
		        ],
				'detailed_overview'=>[
		        	'title'=>'Detailed Overview',
		        	'view'=>'editor',
		            'show_data'=>false,
		        ],
				'general_price'=>[
					'title'=>'Price',
		            'view'=>'number',
					'type'=>'decimal',
					'decimal'=>[20, 6],
				],
				'general_compare_price'=>[
					'title'=>'Compare at Price',
					'view'=>'number',
					'type'=>'decimal',
					'decimal'=>[20, 6],
				],
				'general_cost'=>[
					'title'=>'cost',
		            'view'=>'number',
					'type'=>'decimal',
					'decimal'=>[20, 6],
				],
				'general_special_price_from'=>[
					'title'=>'Special Price From Date',
		            'view'=>'date_picker',
				],
				'general_special_price_to'=>[
					'title'=>'Special Price To Date',
		            'view'=>'date_picker',
				],
				'general_date_of_sale'=>[
					'title'=>'Date of sale',
		            'view'=>'dateTime',
				],

				'downloadable_files'=>[
					'title'=>'Download Files',
		            'view'=>'repeater',
					'sub_fields'=>[
						'name'=>['title'=>'Name'],
						'file'=>['title'=>'File','view'=>'asset-file']
					]
				],
				'downloadable_limit'=>[
					'title'=>'Download Limit',
		            'view'=>'number',
				],
				'downloadable_expiry'=>[
					'title'=>'Download Limit',
		            'view'=>'number',
				],

				'warehouse_sku'=>[
					'title'=>'Warehouse sku',
		            'view'=>'text',
				],
				'warehouse_quantity'=>[
					'title'=>'Warehouse sku',
		            'view'=>'number',
				],
				'warehouse_pre_order_allowed'=>[
					'title'=>'Warehouse sku',
		            'view'=>'select',
					'list_option'=>[
						'no'=>['title'=>'Do not allow'],
						'notify'=>['title'=>'Allowed, but must notify the customer'],
						'yes'=>['title'=>'Allow'],
					]
				],
				'warehouse_out_of_stock_threshold'=>[
					'title'=>'Warehouse Ot of stock threshold',
		            'view'=>'number',
				],

				'shipments_weight'=>[
					'title'=>'shipments weight',
		            'view'=>'number',
				],
				'shipments_dimensions_length'=>[
					'title'=>'Shipments dimensions length',
		            'view'=>'number',
				],
				'shipments_dimensions_width'=>[
					'title'=>'Shipments dimensions width',
		            'view'=>'number',
				],
				'shipments_dimensions_height'=>[
					'title'=>'Shipments dimensions height',
		            'view'=>'number',
				],
				'connected_products_up_selling'=>[
					'title'=>'Up-selling',
		            'view'=>'relationship_manytomany',
					'object'=>'ecom_prod',
					'fields_related'=>['thumbnail','price','compare_price'],
				],
				'connected_products_cross_selling'=>[
					'title'=>'cross-selling',
		            'view'=>'relationship_manytomany',
					'object'=>'ecom_prod',
					'fields_related'=>['thumbnail','price','compare_price'],
				],

				'properties_attributes'=>[
					'title'=>'Attributes',
		            'view'=>'relationship_manytomany',
					'object'=>'ecom_prod_attr',
					'fields_related'=>['sku_code'],
				],
				'properties_attributes_values'=>[
					'title'=>'Attributes values',
		            'view'=>'relationship_manytomany',
					'object'=>'ecom_prod_attr_value',
					'fields_related'=>['ecom_prod_attr'],
				],
				'attributesValues'=>[
					'title'=>'Attributes values (Group Key)',
					'view'=>'json'
				],
				
				'advanced_purchase_note'=>[
					'title'=>'Purchase note',
		            'view'=>'textarea',
				],
				'advanced_enable_reviews'=>[
					'title'=>'Enable reviews',
		            'view'=>'true_false',
				],

				'variations'=>[
					'title'=>'Variations',
		            'view'=>'repeater',
					'sub_fields'=>[
						'title'=>['title'=>'Title'],
						'price'=>['title'=>'Price'],
						'compare_price'=>['title'=>'Compare at Price'],
					]
				],
				'specifications_values'=>[
					'title'=>'Specifications Values',
		            'view' =>'json',
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
			],
		]
	];

	$add_object[] = [
			'ecom_prod_spec_sets',
			1,
			[
			'table'=>'ecom_prod_spec_sets',
			'title'=> 'Specifications Sets',
			'fields'=>[
				'title'=>[
					'title'=>'Title',
					'view'=>'text',
				],
				'specifications'=>[
		        	'title'=>'Specifications',
		        	'view'=>'repeater',
					'layout'=>'block',
					'layoutProps'=>[
						'style'=>[
							'marginTop'=> 0,
							'tableLayout'=> 'fixed'
						]
					],
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
			],
		]
	];

	$add_object[] =  [
		'ecom_prod_attr',
    	1,
    	[
		    'table'=>'ecom_prod_attr',
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
				'searchable'=>[
		        	'title'=>'Searchable',
		        	'view'=>'true_false',
		        ],
				'comparable'=>[
		        	'title'=>'Comparable',
		        	'view'=>'true_false',
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
		            'object'=>'ecom_prod_attr_value',
		            'field'=>'ecom_prod_attr',
		            'note'=>'Attribute terms can be assigned to products and variations.',
		        ],
		    ],
		]
	];
	
	$add_object[] =  [
		'ecom_prod_attr_value',
    	1,
    	[
		    'table'=>'ecom_prod_attr_value',
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
		        'ecom_prod_attr' => [
		            'title'=>__('Product Attribute'),
		            'view' =>'relationship_onetomany',
		            'object'=>'ecom_prod_attr',
		        ],
		    ],
		]
	];


	$add_object[] =  [
		'ecom_prod_filter',
    	1,
    	[
		    'table'=>'ecom_prod_filter',
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
		            'object'=>'ecom_prod_filter_value',
		            'field'=>'ecom_prod_filter',
		        ],
		    ],
		]
	];

	$add_object[] =  [
		'ecom_prod_filter_value',
    	1,
    	[
		    'table'=>'ecom_prod_filter_value',
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
		        'ecom_prod_filter' => [
		            'title'=>__('Filter Group'),
		            'view' =>'relationship_onetomany',
		            'show_data'=>false,
		            'object'=>'ecom_prod_filter',
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
		'ecom_prod_cate',
    	1,
    	[
		    'table'=>'ecom_prod_cate',
		    'title'=>__('Category'),
			'slug'=>'product-category',
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
				'description' => [
		            'title'=>__('Description'),
		            'show_data'=>false,
		            'view' =>'textarea',
		            'note'=>'Mô tả bình thường không được sử dụng trong giao diện, tuy nhiên có vài giao diện hiện thị mô tả này.',
		        ],
		        'parent' => [
		            'title'=>__('Parent'),
		            'view' =>'relationship_onetomany',
		            'show_data'=>false,
		            'object'=>'ecom_prod_cate',
					'hierarchical'=>'parent',
		            'note'=>'Chuyên mục khác với thẻ, bạn có thể sử dụng nhiều cấp chuyên mục. Ví dụ: Trong chuyên mục nhạc, bạn có chuyên mục con là nhạc Pop, nhạc Jazz. Việc này hoàn toàn là tùy theo ý bạn.',
		        ],
		       
		        // 'filters'=>[
		        // 	'title'=>'Filters',
		        // 	'view'=>'text',
		        	// 'view'=>[
		        	// 	'form'=>function($data) use ($plugin) {
		        	// 		return view_plugin($plugin, 'views.Category.filters',['data'=>$data]);
		        	// 	},
		        	// 	'post'=>function($data){
		        	// 		$data['filter_value'] = Request::get('filter_value_',[]);
		        	// 		return $data;
		        	// 	}
		        	// ],
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
		        //     'show_data'=>false,
		        // ],
		        // 'filter_value'=>[
		        // 	'title'=>'Filter Value',
		        // 	'view'=>'hidden',
		        // 	'data_type'=>'repeater',
		        // ]
		    ],
	    ]
	];

	$add_object[] =  [
		'ecom_prod_tag',
    	1,
    	[
		    'table'=>'ecom_prod_tag',
		    'title'=> __('Tag'),
		    'way_show'=>'title',
			'slug'=>'product-tag',
			'dialogContent'=>[
				'width'=>1300
			],
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
		        	'object'=>'ecom_prod',
		        	'field'=>'ecom_prod_tag',
		            'show_data'=>false,
		        ],
		    ],
		]
	];


	$add_object[] = [
		'ecom_prod_review',
		1,
		[
			'table'=>'ecom_prod_review',
			'title'=> __('Review'),
			'slug'=>'review',
			'dialogContent'=>[
				'width'=>1100
			],
			'fields'=>[
				'title'=>[
					'title'=>'Summary of Review',
					'view'=>'text',
					'required'=>true,
				],
				'rating'=>[
					'title'=>'Rating',
					'view'=>'number',
					'customViewForm'=>'PostType/EcomProdReview/RatingCustom',
					'customViewList'=>'PostType/EcomProdReview/RatingCustom',
				],
				'review_status'=>[
					'title'=>'Status',
					'view'=>'select',
					'list_option'=>[
						'approved'=>['title'=>'Approved','color'=>'#43a047'],
						'pending'=>['title'=>'Pending','color'=>'#3f51b5'],
						'not-approved'=>['title'=>'Not Approved','color'=>'rgb(255 41 41)']
					],
				],
				'detail'=>[
					'title'=>'Detail',
					'view'=>'textarea',
					'show_data'=>false,
				],
				'ecom_customer'=>[
					'title'=>'Customer',
					'view'=>'relationship_onetomany',
					'object'=>'ecom_customer',
					'show_data'=>false,
				],
				'ecom_prod' => [
					'title'=>__('Product'),
					'view' =>'relationship_onetomany',
					'show_data'=>true,
					'object'=>'ecom_prod',
					'customViewForm'=>'PostType/EcomProd/Forms/OneChooseProduct',
					'customViewList'=>'PostType/EcomProd/Views/Main',
					'requestMoreData'=>true,
				],
			]
		]
	];

	$add_object[] = [
		'ecom_customer',
		1,
		[
			'table'=>'ecom_customer',
			'slug'=>'customer',
			'title'=> __('Customer'),
			'fields'=>[
				'title'=>[
					'title'=>'Email',
					'view'=>'text',
					'required'=>true,
					'customViewList'=>'PostType/EcomCustomer/View/Email',
				],
				'slug' => [
					'title'=>__('Slug'),
					'view' =>'slug',
					'key_slug'=>'title',
					'type' => 'text',
					'show_data'=>false,
				],
				'first_name'=>[
					'title'=>'First Name',
					'view'=>'text',
					'required'=>true,
					'show_data'=>false,
				],
				'last_name'=>[
					'title'=>'Last Name',
					'view'=>'text',
					'required'=>true,
					'show_data'=>false,
				],
				'birthday'=>[
					'title'=>'Birthday',
					'view'=>'date_picker',
				],
				'gender'=>[
					'title'=>'Gender',
					'view'=>'select',
					'defaultValue'=>'male',
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
					'note'=>'Leave it blank if you don\'t want to change it'
				],
				'address_list'=>[
					'title'=>'Address List',
					'view'=>'repeater',
					'sub_fields'=>[
						'country'=>['title'=>'Country'],
						'city'=>['title'=>'City'],
						'province'=>['title'=>'Province'],
						'street_address'=>['title'=>'Street Address'],
					],
					'show_data'=>false,
				],
				'avatar'=>[
					'title'=>'Avatar',
					'view'=>'image',
					'show_data'=>false,
				]
			],
			'tabs'=>[
				'general'=>[ 'title'=>'General', 'fields'=>['title','slug','first_name','last_name', 'avatar'] ],
				'secret'=>[ 'title'=>'secret', 'fields'=>['birthday','gender','address_list'] ],
				'security'=>[ 'title'=>'Security', 'fields'=>['password'] ],
			],
		]
	];

	$add_object[] = [
		'ecom_coupon',
		1,
		[
			'table'=>'ecom_coupon',
			'slug'=>'coupon',
			'title'=> __('Coupon'),
			'dialogContent'=>[
				'width'=>1000
			],
			'fields'=>[
				'title'=>[
					'title'=>'Code',
					'view'=>'text',
					'required'=>true,
					'unique'=>'coupon_code',
					'customViewForm'=>'PostType/EcomCoupon/Code',
				],
				'description'=>[
					'title'=>'Description',
					'view'=>'textarea',
					'show_data'=>false,
				],
				'discount_type'=>[
					'title'=>'Discount type',
					'view'=>'select',
					'list_option'=>[
						'%'=>['title'=>'Percentage discount','color'=>'#5a5a5a'],
						'$'=>['title'=>'Fixed discount','color'=>'#ff3333'],
					],
				],
				'coupon_amount'=>[
					'title'=>'Coupon amount',
					'view'=>'number',
				],
				'start_date'=>[
					'title'=>'Start date',
					'view'=>'dateTime'
				],
				'expiry_date'=>[
					'title'=>'Coupon expiry date',
					'view'=>'dateTime'
				],
				'minimum_spend'=>[
					'title'=>'Minimum spend',
					'view'=>'number',
					'note'=>'This field allows you to set the minimum spend (subtotal) allowed to use the coupon.',
					'show_data'=>false,
				],
				'maximum_spend'=>[
					'title'=>'Maximum spend',
					'view'=>'number',
					'note'=>'This field allows you to set the maximum spend (subtotal) allowed when using the coupon.',
					'show_data'=>false,
				],
				'individual_use'=>[
					'title'=>'Individual use only',
					'view'=>'true_false',
					'note'=>'Check this box if the coupon cannot be used in conjunction with other coupons.',
					'show_data'=>false,
				],
				'exclude_sale_items'=>[
					'title'=>'Exclude sale items',
					'view'=>'true_false',
					'note'=>'Check this box if the coupon should not apply to items on sale. Per-item coupons will only work if the item is not on sale. Per-cart coupons will only work if there are items in the cart that are not on sale.',
					'show_data'=>false,
				],
				'products'=>[
					'title'=>'Products',
					'view'=>'relationship_manytomany',
					'object'=>'ecom_prod',
					'fields_related'=>['price','compare_price','thumbnail'],
					'show_data'=>false,
				],
				'exclude_products'=>[
					'title'=>'Exclude products',
					'view'=>'relationship_manytomany',
					'object'=>'ecom_prod',
					'fields_related'=>['price','compare_price','thumbnail'],
					'show_data'=>false,
				],
				'product_categories'=>[
					'title'=>'Product categories',
					'view'=>'relationship_manytomany',
					'object'=>'ecom_prod_cate',
					'hierarchical'=>'parent',
					'show_data'=>false,
				],
				'exclude_categories'=>[
					'title'=>'Exclude categories',
					'view'=>'relationship_manytomany',
					'object'=>'ecom_prod_cate',
					'hierarchical'=>'parent',
					'show_data'=>false,
				],
				'allowed_emails'=>[
					'title'=>'Allowed emails',
					'view'=>'textarea',
					'show_data'=>false,
				],
				'usage_limit'=>[
					'title'=>'Usage limit per coupon',
					'view'=>'number',
					'show_data'=>false,
				],
				'limit_usage_to_x_items'=>[
					'title'=>'Limit usage to X items',
					'view'=>'number',
					'show_data'=>false,
				],
				'usage_limit_per_user'=>[
					'title'=>'Usage limit per user',
					'view'=>'number',
					'show_data'=>false,
				]
				// 'ecom_order_detail' => [
		        //     'title'=>'Order Detail',
		        //     'view' =>'relationship_onetomany_show',
		        //     'show_data'=>false,
				// 	'field'=>'ecom_order',
		        //     'object'=>'ecom_order_detail',
		        // ],
			],
			'tabs'=>[
				'General'=>[ 'title'=>'General', 'fields'=>['discount_type','coupon_amount','start_date', 'expiry_date'] ],
				'Usage_restriction'=>[ 'title'=>'Usage restriction', 'fields'=>['minimum_spend','maximum_spend','individual_use','exclude_sale_items','products','exclude_products','product_categories','exclude_categories','allowed_emails'] ],
				'Usage-limits'=>[ 'title'=>'Usage limits', 'fields'=>['usage_limit','limit_usage_to_x_items', 'usage_limit_per_user'] ],
			],
		]
	];

	// $add_object[] = [
	// 	'ecom_shipping',
	// 	1,
	// 	[
	// 		'table'=>'ecom_ship_class',
	// 		'table'=>'ecom_ship_class',
	// 		'slug'=>'shipping-class',
	// 		'title'=> __('Shipping class'),
	// 		'fields'=>[
	// 			'title'=>[
	// 				'title'=>'Title',
	// 				'view'=>'text',
	// 				'required'=>true,
	// 			],
	// 			'description'=>[
	// 				'title'=>'Description',
	// 				'view'=>'textarea',
	// 				'show_data'=>false,
	// 			],
	// 			'shipping_fee'=>[
	// 				'title'=>'Shipping fee',
	// 				'view'=>'number',
	// 				'type'=>'decimal',
	// 				'decimal'=>[20, 6],
	// 			],
	// 		]
	// 	]
	// ];

	$add_object[] = [
		'ecom_order',
		1,
		[
			'table'=>'ecom_order',
			'slug'=>'order',
			'title'=> __('Order'),
			'dialogContent'=>[
				'width'=>1000
			],
			'fields'=>[
				'title'=>[
					'title'=>'Code',
					'view'=>'text',
					'required'=>true,
		        	'unique'=>'ecom_order_code',
					'customViewForm'=>'PostType/EcomOrder/Form/Code',
					'formatCode'=>'OD-xxxxxx-xxxx-xxxx-xxxxxx',
				],
				// 'slug' => [
				// 	'title'=>__('Slug'),
				// 	'view' =>'slug',
				// 	'key_slug'=>'title',
				// 	'type' => 'text',
				// 	'show_data'=>false,
				// ],
				'ecom_customer' => [
		            'title'=>'Customer',
		            'view' =>'relationship_onetomany',
		            'object'=>'ecom_customer',
					'fields_related'=>['first_name','last_name','avatar'],
					'customViewList'=>'PostType/EcomCustomer/View/Main',
					'customViewForm'=>'PostType/EcomCustomer/Form/Main',
		        ],
				'date_created'=>[
					'title'=>'Date created',
					'view'=>'dateTime',
					'defaultValue'=>'CURRENT_TIMESTAMP'
				],
				'order_status'=>[
					'title'=>'Status',
					'view'=>'select',
					'defaultValue'=>'pending',
					'list_option'=>[
						'pending'=>['title'=>'Pending payment','color'=>'#404040'],
						'processing'=>['title'=>'Processing','color'=>'#3f51b5'],
						'on-hold'=>['title'=>'On hold','color'=>'#ffaa00'],
						'completed'=>['title'=>'Completed','color'=>'#43a047'],
						'cancelled'=>['title'=>'Cancelled','color'=>'#a00'],
						'refunded'=>['title'=>'Refunded','color'=>'#7903da'],
						'failed'=>['title'=>'Failed','color'=>'#ff5900'],
					]
				],
				'billing_address'=>[
					'title'=>'Billing Address',
					'view'=>'group',
					'sub_fields'=>[
						'name_prefix'=>['title'=>'Name Prefix'],
						'first_name'=>['title'=>'First Name'],
						'middle_name'=>['title'=>'Middle Name/Initial'],
						'last_name'=>['title'=>'Last Name'],
						'company'=>['title'=>'Company'],
						'street_address'=>['title'=>'Street Address'],
						'country'=>['title'=>'country'],
						'state_province'=>['title'=>'State/Province'],
						'city'=>['title'=>'City'],
						'postal_code'=>['title'=>'Zip/Postal Code'],
						'phone_number'=>['title'=>'Phone Number'],
						'fax'=>['title'=>'Fax'],
						'vat_number'=>['title'=>'VAT Number'],
					],
					'show_data'=>false,
				],
				'shipping_address'=>[
					'title'=>'Shipping Address',
					'view'=>'group',
					'sub_fields'=>[
						'name_prefix'=>['title'=>'Name Prefix'],
						'first_name'=>['title'=>'First Name'],
						'middle_name'=>['title'=>'Middle Name/Initial'],
						'last_name'=>['title'=>'Last Name'],
						'company'=>['title'=>'Company'],
						'street_address'=>['title'=>'Street Address'],
						'country'=>['title'=>'country'],
						'state_province'=>['title'=>'State/Province'],
						'city'=>['title'=>'City'],
						'postal_code'=>['title'=>'Zip/Postal Code'],
						'phone_number'=>['title'=>'Phone Number'],
						'fax'=>['title'=>'Fax'],
						'vat_number'=>['title'=>'VAT Number'],
					],
					'show_data'=>false,
				],
				'discount'=>[
					'title'=>'Discount',
					'layout'=>'table',
					'view'=>'group',
					'hidden'=>true,
					'sub_fields'=>[
						'type'=>[
							'title'=>'Type',
							'view'=>'select',
							'list_option'=>[
								'%' => ['title'=>'%'],
								'$' => ['title'=>'$'],
							]
						],
						'value'=>['title'=>'Value','type'=>'number']
					],
					'show_data'=>false,
				],
				'total_money'=>[
					'title'=>'Total Money',
					'view'=>'number',
					'type'=>'decimal',
					'decimal'=>[20, 6],
					'customViewForm'=>'PostType/EcomOrder/Form/TotalMoney',
					'customViewList'=>'PostType/EcomOrder/View/TotalMoney',
				],
				'ecom_prod'=>[
					'title'=>'Products',
		            'view' =>'relationship_manytomany',
		            'show_data'=>false,
		            'object'=>'ecom_prod',
					'hidden'=>true,
					// 'fields_related'=>['compare_price','price','thumbnail'],
				],
				'products'=>[
					'title'=>'Products',
		            'view' =>'json',
		            'show_data'=>false,
					'customViewForm'=>'PostType/EcomOrder/ChooseProduct',
				],
				'ecom_coupon'=>[
					'title'=>'Coupons',
		            'view' =>'relationship_manytomany',
		            'object'=>'ecom_coupon',
					'show_data'=>false,
					'hidden'=>true,
				],
				'coupons'=>[
					'title'=>'Coupons',
		            'view' =>'json',
		            'show_data'=>false,
					'customViewForm'=>'PostType/EcomOrder/ChooseCoupon',
				],
				'history'=>[
					'title'=>'History',
					'view'=>'repeater',
					'sub_fields'=>[
						'description'=>['title'=>'Description','view'=>'textarea'],
						'time'=>['title'=>'Time','view'=>'dateTime'],
						'note_type'=>[
							'title'=>'Note type',
							'view'=>'select',
							'defaultValue'=>'private',
							'list_option'=>[
								'private'=>['title'=>'Private note','color'=>'#7903da'],
								'customer'=>['title'=>'Note to customer','color'=>'#3f51b5'],
							]
						]
					],
					'customViewForm'=>'PostType/EcomOrder/History',
					'show_data'=>false,
				]
				// 'ecom_order_detail' => [
		        //     'title'=>'Order Detail',
		        //     'view' =>'relationship_onetomany_show',
		        //     'show_data'=>false,
				// 	'field'=>'ecom_order',
		        //     'object'=>'ecom_order_detail',
		        // ],
			],
			'tabs'=>[
				'Information'=>[ 'title'=>'Information', 'fields'=>['title','date_created', 'ecom_customer'] ],
				'address'=>[ 
					'title'=>'Address', 
					'fields'=>['billing_address','shipping_address'],
					'hook'=>'PostType/EcomOrder/Address'
				],
				'detail'=>[ 'title'=>'Detail', 'fields'=>['products','coupons','total_money'] ],
				'invoices'=>[ 'title'=>'Invoices', 'fields'=>[] ],
				'shipping'=>[ 'title'=>'Shipping', 'fields'=>[] ],
				'history'=>[ 'title'=>'History', 'fields'=>['history'] ],
			],
		]
	];

	$add_object[] = [
		'ecom_order_detail',
		1,
		[
			'table'=>'ecom_order_detail',
			'slug'=>'order-detail',
			'title'=> 'Order Detail',
			'fields'=>[
				'title'=>[
					'title'=>'Title',
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
				'ecom_order' => [
		            'title'=>'Order',
		            'view' =>'relationship_onetomany',
		            'object'=>'ecom_order',
		        ],
				'ecom_prod' => [
		            'title'=>'Product',
		            'view' =>'relationship_onetomany',
		            'object'=>'ecom_prod',
					'customViewForm'=>'PostType/EcomProd/Forms/OneChooseProduct',
					'customViewList'=>'PostType/EcomProd/Views/Main',
					'requestMoreData'=>true,
		        ],
				'quantity'=>[
					'title'=>'Quantity',
					'view'=>'number',
					'required'=>true,
				],
			]
		]
	];

	$add_object[] = [
		'ecom_tax',
		1,
		[
			'table'=>'ecom_tax',
			'slug'=>'ecom-tax',
			'title'=> 'Tax',
			'fields'=>[
				'title'=>[
					'title'=>'Title',
					'view'=>'text',
					'required'=>true,
				],
			]
		]
	];

	return $add_object;

});
