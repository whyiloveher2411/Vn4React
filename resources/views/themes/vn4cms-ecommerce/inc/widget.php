<?php
return [
	'slider'=>[
		'title'=>'Slider',
		'description'=>'A banner slider is a graphical display that can be used to push instant engagement with your website visitors',
		'thumbnail'=>'/themes/vn4cms-ecommerce/images/slider.JPG',
		'template'=>'widget.slider',
		'template_admin'=>'admin.widget.slider',
		'type'=>'prebuilt_layouts',
		'fields'=>[
			'sliders'=>[
				'title'=>'Sliders',
				'view'=>'repeater',
				'layout'=>'block',
				'sub_fields'=>[
					'title'=>['title'=>'Title','view'=>'text'],
					'image'=>['title'=>'Image','view'=>'image'],
					'link'=>['title'=>'Link','view'=>'link'],
				]
			]
		],
	],
	'categories'=>[
		'title'=>'Categories',
		'description'=>'Product category is a type of product or service.',
		'thumbnail'=>'/themes/vn4cms-ecommerce/images/categories.jpg',
		'template'=>'widget.categories',
		'template_admin'=>'admin.widget.categories',
		'type'=>'prebuilt_layouts',
		'fields'=>[
			'categories'=>[
				'title'=>'Categories',
				'view'=>'repeater',
				'layout'=>'block',
				'sub_fields'=>[
					'title'=>['title'=>'Title','view'=>'text'],
					'description'=>['title'=>'description','view'=>'text'],
					'image'=>['title'=>'Image','view'=>'image'],
					'link'=>['title'=>'Link','view'=>'link'],
				]
			],
			'label_more_button'=>['title'=>'Lable More Button','view'=>'text'],
			'link_more'=>['title'=>'Link More','view'=>'link'],
		],
	],
	'products'=>[
		'title'=>'Products',
		'description'=>'Widget Create By Theme Demo',
		'thumbnail'=>'/themes/vn4cms-ecommerce/images/products.jpg',
		'template'=>'widget.products',
		'template_admin'=>'admin.widget.products',
		'type'=>'prebuilt_layouts',
		'fields'=>[
			'condition'=>[
				'title'=>'Condition',
				'view'=>'text'
			],
			'label_more_button'=>['title'=>'Lable More Button','view'=>'text'],
			'link_more'=>['title'=>'Link More','view'=>'link'],
		],
	],
	'brands'=>[
		'title'=>'Brands',
		'description'=>'Widget Create By Theme Demo',
		'thumbnail'=>'/themes/vn4cms-ecommerce/images/brands.jpg',
		'template'=>'widget.brands',
		'template_admin'=>'admin.widget.brands',
		'type'=>'prebuilt_layouts',
		'fields'=>[
			'brands'=>[
				'title'=>'Brands',
				'view'=>'repeater',
				'layout'=>'block',
				'sub_fields'=>[
					'title'=>['title'=>'Title','view'=>'text'],
					'image'=>['title'=>'Image','view'=>'image'],
					'link'=>['title'=>'Link','view'=>'link'],
				]
			],
			'label_more_button'=>['title'=>'Lable More Button','view'=>'text'],
			'link_more'=>['title'=>'Link More','view'=>'link'],
		],
	],
	'blogs'=>[
		'title'=>'Blogs',
		'description'=>'Widget Create By Theme Demo',
		'thumbnail'=>'/themes/vn4cms-ecommerce/images/blogs.jpg',
		'template'=>'widget.blog',
		'template_admin'=>'admin.widget.blog',
		'type'=>'prebuilt_layouts',
		'fields'=>[
			'brands'=>[
				'title'=>'Brands',
				'view'=>'repeater',
				'layout'=>'block',
				'sub_fields'=>[
					'title'=>['title'=>'Title','view'=>'text'],
					'image'=>['title'=>'Image','view'=>'image'],
					'link'=>['title'=>'Link','view'=>'link'],
				]
			],
			'label_more_button'=>['title'=>'Lable More Button','view'=>'text'],
			'link_more'=>['title'=>'Link More','view'=>'link'],
		],
	],
	'about'=>[
		'title'=>'About',
		'description'=>'Widget Create By Theme Demo',
		'thumbnail'=>'/themes/vn4cms-ecommerce/images/about.jpg',
		'template'=>'widget.about',
		'template_admin'=>'admin.widget.about',
		'type'=>'prebuilt_layouts',
		'fields'=>[
			'brands'=>[
				'title'=>'Brands',
				'view'=>'repeater',
				'layout'=>'block',
				'sub_fields'=>[
					'title'=>['title'=>'Title','view'=>'text'],
					'image'=>['title'=>'Image','view'=>'image'],
					'link'=>['title'=>'Link','view'=>'link'],
				]
			],
			'label_more_button'=>['title'=>'Lable More Button','view'=>'text'],
			'link_more'=>['title'=>'Link More','view'=>'link'],
		],
	],
	'subscribe'=>[
		'title'=>'Subscribe',
		'description'=>'Widget Create By Theme Demo',
		'thumbnail'=>'/themes/vn4cms-ecommerce/images/subscribe.jpg',
		'template'=>'widget.subscribe',
		'template_admin'=>'admin.widget.subscribe',
		'type'=>'prebuilt_layouts',
		'fields'=>[
			'brands'=>[
				'title'=>'Brands',
				'view'=>'repeater',
				'layout'=>'block',
				'sub_fields'=>[
					'title'=>['title'=>'Title','view'=>'text'],
					'image'=>['title'=>'Image','view'=>'image'],
					'link'=>['title'=>'Link','view'=>'link'],
				]
			],
			'label_more_button'=>['title'=>'Lable More Button','view'=>'text'],
			'link_more'=>['title'=>'Link More','view'=>'link'],
		],
	],

	'row'=>[
		'title'=>'Row',
		'description'=>'Widget Create By Theme Demo',
		'thumbnail'=>'/themes/vn4cms-ecommerce/images/subscribe.jpg',
		'template'=>'widget.row',
		'template_admin'=>'admin.widget.row',
		'type'=>'layout',
		'fields'=>[
			'brands'=>[
				'title'=>'Brands',
				'view'=>'repeater',
				'layout'=>'block',
				'sub_fields'=>[
					'title'=>['title'=>'Title','view'=>'text'],
					'image'=>['title'=>'Image','view'=>'image'],
					'link'=>['title'=>'Link','view'=>'link'],
				]
			],
			'label_more_button'=>['title'=>'Lable More Button','view'=>'text'],
			'link_more'=>['title'=>'Link More','view'=>'link'],
		],
	]
];