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
					'customViewList'=>'CustomViewProductTitleAndThumbnail',
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
		        'price'=>[
		        	'title'=>'Price',
		        	'view'=>'number',
					'hidden'=>true,
					'customViewList'=>'CustomViewListProductPrice'
		        ],
		        'sale_price'=>[
		        	'title'=>'Sale Price',
		        	'view'=>'number',
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
		        'general'=>[ 'title'=>'General', 'fields'=>['title','slug','description','product_type'] ],
		        'image'=>[ 'title'=>'Image', 'fields'=>['thumbnail','gallery'] ],
		        'categories'=>[ 'title'=>'Categories', 'fields'=>['ecom_prod_cate', 'ecom_prod_tag', 'ecom_prod_spec_sets'] ],
		        'filters'=>['title'=>'Filters','fields'=>['detailed_filters']],
		        'other'=>['title'=>'Other','fields'=>['order']],
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
		    'row_actions'=>function($post, $actions){
				$actions['report'] = '<a class="" href="#">Report</a>';
				return $actions;
			},
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
				],
				'general_sale_price'=>[
					'title'=>'Price',
		            'view'=>'number',
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
					'fields_related'=>['thumbnail','price','sale_price'],
				],
				'connected_products_cross_selling'=>[
					'title'=>'cross-selling',
		            'view'=>'relationship_manytomany',
					'object'=>'ecom_prod',
					'fields_related'=>['thumbnail','price','sale_price'],
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
						'sale_price'=>['title'=>'Sale price'],
					]
				],


				// 'specifications_sets'=>[
				// 	'title'=>'Specifications Sets',
		        //     'view' =>'relationship_onetomany',
		        //     'show_data'=>false,
		        //     'object'=>'ecom_prod_spec_sets',
				// ],

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

				// 'question_and_answer'=>[
		        // 	'title'=>'Question and Answer',
		        // 	'view'=>'repeater',
		        // 	'sub_fields'=>[
		        // 		'question'=>['title'=>'Question'],
		        // 		'answer'=>['title'=>'Answer','view'=>'textarea'],
		        // 	],
		        // 	'show_data'=>false,
		        // ],
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

	$add_object[] = [
			'ecom_prod_variable',
	    	1,
			[
		    'table'=>'ecom_prod_variable',
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
		            'show_data'=>false,
		        ],
		        'images'=>[
		        	'title'=>'Images',
		        	'view'=>'image',
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
		        'ecom_prod' => [
		            'title'=>'Product',
		            'view' =>'relationship_onetomany',
		            'show_data'=>false,
		            'object'=>'ecom_prod',
		        ],
		        'attribute_value' => [
		            'title'=>'Product Attribute Value',
		            'view' =>'relationship_manytomany',
		            'show_data'=>false,
		            'object'=>'ecom_prod_attr_value',
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
					'customViewForm'=>'CustomViewRating',
					'customViewList'=>'CustomViewRating',
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
					'customViewList'=>'CustomViewListProduct',
					'customViewForm'=>'CustomFormChooseProduct',
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
					'view'=>'date_picker',
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
					]
				],
				'avatar'=>[
					'title'=>'Avatar',
					'view'=>'image',
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
				'ecom_customer' => [
		            'title'=>'Customer',
		            'view' =>'relationship_onetomany',
		            // 'show_data'=>false,
		            'object'=>'ecom_customer',
		        ],
				'total_money'=>[
					'title'=>'Total Money',
					'view'=>'number'
				],
				'ecom_order_detail' => [
		            'title'=>'Order Detail',
		            'view' =>'relationship_onetomany_show',
		            'show_data'=>false,
					'field'=>'ecom_order',
		            'object'=>'ecom_order_detail',
		        ],
			]
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
					'customViewList'=>'CustomViewListProduct',
					'customViewForm'=>'CustomFormChooseProduct',
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
