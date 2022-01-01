<?php
register_post_type(function($list_post_type){
	$add_object = [];


	$add_object[] = [
		'cfd_teacher',
    	1,
		[
		    'table'=>'cfd_teacher',
		    'title'=>'Teacher',
		    'slug'=>'teacher',
		    'fields'=>[
		        'title'=>[
		            'title'=>'Name',
		            'view'=>'text',
		            'required'=>true,
		        ],
		        'slug' => [
		            'title'=>'Slug',
		            'view' =>'slug',
		            'key_slug'=> 'title',
		            'type' =>'text',
		        ],
		        'position' => [
		            'title'=>'Vị trí',
		            'show_data'=>false,
		            'view' =>'text',
				],
				'description' => [
		            'title'=>'Mô tả',
		            'show_data'=>false,
		            'view' =>'textarea',
				],
				'avatar'=>[
					'title'=>'Hình đại diện',
					'view'=>'image',
					'advance'=>'right',
					'thumbnail'=>[
						'thubnail-1'=>['title'=>'Thubnail 1','width'=>48,'height'=>48],
						'thubnail-2'=>['title'=>'Thubnail 2','width'=>585,'height'=>385]
					],
		            'show_data'=>false,
				],
				'website'=>[
					'title'=>'Website',
					'view'=>'text',
		            'show_data'=>false,
				],
		    ],
		]
	];

	$add_object[] = [
		'cfd_student',
    	1,
		[
		    'table'=>'cfd_student',
		    'title'=>'Student',
		    'slug'=>'hoc-vien',
		    'fields'=>[
		        'title'=>[
		            'title'=>'Name',
		            'view'=>'text',
		            'required'=>true,
		        ],
		        'slug' => [
		            'title'=>'Slug',
		            'view' =>'slug',
		            'key_slug'=> 'title',
		            'type' =>'text',
				],
				'description'=>[
					'title'=>'Description',
					'view'=>'textarea',
					'show_data'=>false,
				],
				'password'=>[
					'title'=>'Password',
					'view'=>'password',
		            'show_data'=>false,
				],
		        'phone' => [
		            'title'=>'Phone',
		            'show_data'=>false,
		            'view' =>'text',
				],
				'email' => [
		            'title'=>'Email',
		            'show_data'=>false,
		            'view' =>'text',
				],
				'facebook'=>[
					'title'=>'Facebook',
					'view'=>'text',
		            'show_data'=>false,
				],
				'skype'=>[
					'title'=>'Skype',
					'view'=>'text',
		            'show_data'=>false,
				],
				'review'=>[
					'title'=>'Review',
					'view'=>'textarea',
		            'show_data'=>false,
				],
				'current_job'=>[
					'title'=>'Current Job',
					'view'=>'text',
		            'show_data'=>false,
				],
				'avatar'=>[
					'title'=>'Hình đại diện',
					'view'=>'image',
					'advance'=>'right',
					'show_data'=>false,
					'thumbnail'=>[
						'thumbnail-1'=>['title'=>'Thumbnail 1','width'=>48, 'height'=>48],
						'thumbnail-2'=>['title'=>'Thumbnail 2','width'=>260, 'height'=>260]
					]
				],
				'student_type'=>[
					'title'=>'Loại học viên',
					'view'=>'select',
					'list_option'=> ['thanh-vien'=>['title'=>'Thành viên','color'=>'#797979'],'hoc-vien'=>['title'=>'Học viên','color'=>'#f4744b']],
				],
				// 'cfd_course'=>[
				// 	'title'=>'Course',
				// 	'view'=>'relationship_manytomany',
				// 	'object'=>'cfd_course',
		  //           'show_data'=>false,
				// ],
				'total_coin_current'=>[
					'title'=>'Total COIN current',
					'view'=>'number',
				],
				'so_lan_duoc_doi_card_con_lai'=>[
					'title'=>'Số lần được đổi card còn lại',
					'view'=>'number',
				],
				'cfd_coin_history'=>[
					'title'=>'COIN History',
					'view'=>'relationship_onetomany_show',
					'object'=>'cfd_coin_history',
					'field'=>'cfd_student',
		            'show_data'=>false,
				],
				'cfd_course_register'=>[
					'title'=>'Course',
					'view'=>'relationship_onetomany_show',
					'object'=>'cfd_course_register',
					'field'=>'cfd_student',
		            'show_data'=>false,
				],
				'cfd_project'=>[
					'title'=>'Project',
					'view'=>'relationship_onetomany_show',
					'object'=>'cfd_project',
					'field'=>'cfd_student',
		            'show_data'=>false,
				],
			],
			'tabs'=>[
				'general'=>['title'=>'General','fields'=>['title','slug','description','email','password','avatar','student_type']],
				'contact'=>['title'=>'Contact','fields'=>['phone','facebook','skype']],
				'information'=>['title'=>'More information','fields'=>['review','current_job']],
				// 'course'=>['title'=>'Course','fields'=>['cfd_course']],
				'course'=>['title'=>'Course','fields'=>['cfd_course_register']],
				'coin'=>['title'=>'COIN','fields'=>['total_coin_current','so_lan_duoc_doi_card_con_lai','cfd_coin_history']],
				'project'=>['title'=>'Project','fields'=>['cfd_project']],
			],
			'row_actions'=>function($item, $row_actions){
				$row_actions['dashborad'] = '<a href="'.route('admin.theme',['page'=>'student-dashborad','studentId'=>$item->id]).'">Dashborad</a>';
				return $row_actions;
			}
		]
	];

	$add_object[] = [
		'cfd_coin_history',
    	1,
		[
		    'table'=>'cfd_coin_history',
		    'title'=>'COIN History',
		    'slug'=>'coin-history',
		    'fields'=>[
		        'title'=>[
		            'title'=>'Title',
		            'view'=>'text',
		            'required'=>true,
		        ],
		        'date' => [
		            'title'=>'Date',
		            'view' =>'input',
		            'type' =>'datetime',
		        ],
		        'coin' => [
		            'title'=>'COIN',
					'view' =>'number',
				],
				'trang_thai'=>[
					'title'=>'Trang thái',
					'view' =>'select',
					'list_option'=> ['cho-xet-duyet'=>['title'=>'Chờ xét duyệt','color'=>'#797979'],'duoc-duyet'=>['title'=>'Được duyệt','color'=>'#f4744b'],'khong-duoc-duyet'=>['title'=>'Không Được duyệt','color'=>'#a90808']],
				],
				'cfd_student' => [
		            'title'=>'Student',
					'view' =>'relationship_onetomany',
					'object'=>'cfd_student',
				],
				'cfd_course_register'=>[
					'title'=>'Course Register',
					'view' =>'relationship_onetomany',
					'object'=>'cfd_course_register',
				],
		    ],
		]
	];

	$add_object[] = [
		'cfd_course',
    	1,
		[
		    'table'=>'cfd_course',
		    'title'=>'Course',
		    'slug'=>'khoa-hoc',
		    'fields'=>[
		        'title'=>[
		            'title'=>__('Title'),
		            'view'=>'text',
		            'required'=>true,
		        ],
		        'slug' => [
		            'title'=>'Slug',
		            'view' =>'slug',
		            'key_slug'=> 'title',
		            'type' =>'text',
		            'show_data'=>false,
		        ],
		        'short_description' => [
		            'title'=>'Mô tả ngắn',
		            'show_data'=>false,
		            'view' =>'textarea',
				],
				'long_description' => [
		            'title'=>'Mô tả dài',
		            'show_data'=>false,
		            'view' =>'textarea',
				],
				'khoa'=>[
					'title'=>'Khóa',
					'view'=>'number',
		            'show_data'=>false,
				],
				'money'=>[
					'title'=>'Money',
					'view'=>'number',
				],
				'money_affiliate_1'=>[
					'title'=>'Điểm khi được giới thiệu',
					'view'=>'number',
					'note'=>'1 điểm tương đương 1,000 VNĐ'
				],
				'money_affiliate_2'=>[
					'title'=>'Điểm người giới thiệu được nhận',
					'view'=>'number',
					'note'=>'1 điểm tương đương 1,000 VNĐ'
				],
				
				'course_status'=>[
					'title'=>'Trạng thái',
					'view'=>'select',
					'list_option'=> ['da-ket-thuc'=>['title'=>'Đã kết thúc','color'=>'#797979'],'dang-dien-ra'=>['title'=>'Đang diễn ra','color'=>'#f4744b'],'sap-khai-gian'=>['title'=>'Sắp khai giảng','color'=>'#ec5c6c']],
				],

				'number_student_default'=>[
					'title'=>'Student Default',
					'view'=>'number',
				],

				'course_type'=>[
					'title'=>'Type',
					'view'=>'select',
					'list_option'=>['offline'=>['title'=>'Offline','color'=>'#aeaeae'],'online'=>['title'=>'Online','color'=>'#1372ba']],
		            'show_data'=>false,
				],
				
				'opening_time'=>[
					'title'=>'Khai giảng',
					'view'=>'input',
					'type'=>'date',
		            'show_data'=>false,
				],
				'close_time'=>[
					'title'=>'Thời gian kết thúc',
					'view'=>'input',
					'type'=>'date',
		            'show_data'=>false,
				],
				'count_video'=>[
					'title'=>'Số video',
					'view'=>'number',
		            'show_data'=>false,
				],
				
				'content'=>[
					'title'=>'Nội dung',
					'view'=>'repeater',
					'layout'=>'block',
					'sub_fields'=>[
						'title'=>['title'=>'Tiêu đề'],
						'content'=>['title'=>'Nội dung buổi học','view'=>'textarea','rows'=>2],
						'video'=>[
							'title'=>'Video',
							'view'=>'group',
							'sub_fields'=>[
								'source'=>['title'=>'Source'],
								'status'=>[ 'title'=>'Status','view'=>'select','list_option'=>['private'=>['title'=>'Private','color'=>'red'],'public'=>['title'=>'Public','color'=>'green']]]
							]
						],
						'slide'=>[
							'title'=>'Slide',
							'view'=>'group',
							'sub_fields'=>[
								'source'=>['title'=>'Source'],
								'status'=>[ 'title'=>'Status','view'=>'select','list_option'=>['private'=>['title'=>'Private','color'=>'red'],'public'=>['title'=>'Public','color'=>'green']]]
							]
						],
						'exercise'=>[
							'title'=>'Bài tập',
							'view'=>'group',
							'sub_fields'=>[
								'exercise_evaluation'=>[ 'title'=>'Hình thức đánh giá bài tập','view'=>'select','list_option'=>['file'=>['title'=>'File','color'=>'red'],'teacher-reviews'=>['title'=>'Giáo viên đánh giá','color'=>'green']]],
								'content'=>['title'=>'Nội dung bài tập','view'=>'editor'],
							]
						]
					],
		            'show_data'=>false,
				],
				'benefits'=>[
					'title'=>'Quyền lợi',
					'view'=>'repeater',
					'sub_fields'=>[
						'content'=>['title'=>'Nội dung quyền lợi','view'=>'text']
					],
		            'show_data'=>false,
				],
				'required'=>[
					'title'=>'Yêu cầu cần có',
					'view'=>'repeater',
					'sub_fields'=>[
						'content'=>['title'=>'Nội dung yêu cầu','view'=>'text']
					],
		            'show_data'=>false,
				],
				'schedule'=>[
					'title'=>'Lịch học',
					'view'=>'text',
		            'show_data'=>false,
				],
				'template_color_banner'=>[
					'title'=>'Color Banner',
					'view'=>'color',
		            'show_data'=>false,
				],
				'template_color_btn'=>[
					'title'=>'Color Button',
					'view'=>'color',
		            'show_data'=>false,
				],

				'cfd_teacher'=>[
					'title'=>'Người dạy',
					'view'=>'relationship_manytomany',
					'object'=>'cfd_teacher',
					'advance'=>'right',
		            'show_data'=>false,
				],
				'mentor'=>[
					'title'=>'Mentor',
					'view'=>'relationship_manytomany',
					'object'=>'cfd_teacher',
					'advance'=>'right',
		            'show_data'=>false,
				],
				'thubnail'=>[
					'title'=>'Thumbnail',
					'view'=>'image',
					'thumbnail'=>[
						'thubnail-1'=>['title'=>'Thubnail 1','width'=>380,'height'=>270]
					],
					'advance'=>'right',
		            'show_data'=>false,
				],
				'cfd_course_register'=>[
					'title'=>'Register',
					'view'=>'relationship_manytomany_show',
					'object'=>'cfd_course_register',
					'field'=>'cfd_course',
		            'show_data'=>false,
				],
			],
			'tabs'=>[
				'general'=>['title'=>'General','fields'=>['title','slug','course_type','short_description','long_description','khoa']],
				'detail'=>['title'=>'Detail','fields'=>['opening_time','number_student_default','close_time','course_status','time','count_video','benefits','required','schedule','template_color']],
				'money'=>['title'=>'Money','fields'=>[ 'money','money_affiliate_1','money_affiliate_2'] ],
				'template'=>['title'=>'Template','fields'=>['template_color_banner', 'template_color_btn']],
				'content'=>['title'=>'Content','fields'=>['content']],
				'register'=>['title'=>'Register','fields'=>['cfd_course_register']],
			],
			'row_actions'=>function($item, $row_actions){
				
				$row_actions['dashborad'] = '<a href="'.route('admin.theme',['page'=>'course-dashborad','courseId'=>$item->id]).'">Dashborad</a>';
				return $row_actions;
			}
		]
	];



	$add_object[] = [
		'cfd_course_register',
    	1,
		[
		    'table'=>'cfd_course_register',
		    'title'=>'Register Course',
		    'slug'=>'course-register',
		    'fields'=>[
		        'title'=>[
		            'title'=>'Name',
		            'view'=>'text',
		            'required'=>true,
		        ],
		        'money'=>[
		        	'title'=>'Money',
		        	'view'=>'number',
		        ],
		        'coin_use'=>[
		        	'title'=>'Số COIN sử dụng',
		        	'view'=>'number',
		        ],
		        'payment_method'=>[
					'title'=>'Payment Method',
					'view'=>'text',
		            'validation'=>[
		            	'required'=>__('Hình thức thanh toán là trường bắt buộc'),
		            ],
		            'show_data'=>false,
				],
		        'payment'=>[
		        	'title'=>'Payment',
		        	'view'=>'repeater',
		        	'sub_fields'=>[
		        		'money' => [
				            'title'=>'Money',
							'view' =>'number',
							'show_data'=>function($post){
								return number_format($post->money).' VNĐ';
							}
						],
		        		'date'=>[
				            'title'=>'Date',
				            'view' =>'input',
				            'type' =>'date',
				        ]
		        	]
		        ],
		        'cfd_course'=>[
					'title'=>'Course',
					'view' =>'relationship_onetomany',
					'object'=>'cfd_course',
				],
				'trang_thai'=>[
					'title'=>'Trang thái',
					'view' =>'select',
					'list_option'=> ['cho-xet-duyet'=>['title'=>'Chờ xét duyệt','color'=>'#797979'],'duoc-duyet'=>['title'=>'Được duyệt','color'=>'#f4744b'],'khong-duoc-duyet'=>['title'=>'Không Được duyệt','color'=>'#a90808']],
				],
				'nguoi_gioi_thieu' => [
		            'title'=>'Người giới thiệu',
					'view' =>'relationship_onetomany',
					'object'=>'cfd_student',
					'advance'=>'right',
				],
		        'cfd_student' => [
		            'title'=>'Student',
					'view' =>'relationship_onetomany',
					'object'=>'cfd_student',
					'advance'=>'right',
				],
				'opinion'=>[
					'title'=>'Ý kiên',
					'view'=>'textarea',
					'show_data'=>false,
				],
		    ],
		]
	];
	
	$add_object[] = [
		'cfd_project',
    	1,
		[
		    'table'=>'cfd_project',
		    'title'=>'Project',
		    'slug'=>'du-an',
		    'fields'=>[
		        'title'=>[
		            'title'=>'Name',
		            'view'=>'text',
		            'required'=>true,
				],
				'slug' => [
		            'title'=>'Slug',
		            'view' =>'slug',
		            'key_slug'=> 'title',
		            'type' =>'text',
		            'show_data'=>false,
		        ],
		        'description' => [
		            'title'=>'description',
					'view' =>'textarea',
					'show_data'=>false,
		        ],
		        'url_website'=>[
		        	'title'=>'Website',
		            'view'=>'text',
		            'show_data'=>false,
		        ],
		        'show_on_public'=>[
		        	'title'=>'Show on page Public',
		        	'view'=>'true_false',
					'show_data'=>false,
		        ],
		        'thubnail'=>[
					'title'=>'Thumbnail',
					'view'=>'image',
					'thumbnail'=>[
						'thubnail-1'=>['title'=>'Thubnail 1','width'=>380,'height'=>270],
						'project-page'=>['title'=>'Project Page','width'=>540,'height'=>355],
					],
					'advance'=>'right',
		            'show_data'=>false,
				],
				'cfd_student' => [
		            'title'=>'Student',
					'view' =>'relationship_onetomany',
					'object'=>'cfd_student',
				],
				'cfd_course'=>[
					'title'=>'Course',
					'view' =>'relationship_onetomany',
					'object'=>'cfd_course',
				],
		    ],
		]
	];

	$add_object[] = [
		'cfd_case_study',
    	1,
		[
		    'table'=>'cfd_case_study',
		    'title'=>'Case Study',
		    'slug'=>'case-study',
		    'fields'=>[
		        'title'=>[
		            'title'=>'Name',
		            'view'=>'text',
		            'required'=>true,
				],
				'slug' => [
		            'title'=>'Slug',
		            'view' =>'slug',
		            'key_slug'=> 'title',
		            'type' =>'text',
		            'show_data'=>false,
		        ],
		        'description' => [
		            'title'=>'description',
					'view' =>'textarea',
					'show_data'=>false,
		        ],
		        'url_website'=>[
		        	'title'=>'Website',
		            'view'=>'text',
		            'show_data'=>false,
		        ],
				'author'=>['title'=>'Author','advance'=>'right'],
		        'thubnail'=>[
					'title'=>'Thumbnail',
					'view'=>'image',
					'thumbnail'=>[
						'thubnail-1'=>['title'=>'Thubnail 1','width'=>540,'height'=>355]
					],
					'advance'=>'right',
		            'show_data'=>false,
				],
		    ],
		]
	];


	// $add_object[] = [
	// 	'cfd_payment_history',
 //    	1,
	// 	[
	// 	    'table'=>'cfd_payment_history',
	// 	    'title'=>'Payment History',
	// 	    'slug'=>'payment-history',
	// 	    'fields'=>[
	// 	        'title'=>[
	// 	            'title'=>'Name',
	// 	            'view'=>'text',
	// 	            'required'=>true,
	// 	        ],
	// 	        'date' => [
	// 	            'title'=>'Date',
	// 	            'view' =>'input',
	// 	            'type' =>'date',
	// 	        ],
	// 	        'money' => [
	// 	            'title'=>'Money',
	// 				'view' =>'number',
	// 				'show_data'=>function($post){
	// 					return number_format($post->money).' VNĐ';
	// 				}
	// 			],
	// 			'cfd_student' => [
	// 	            'title'=>'Student',
	// 				'view' =>'relationship_onetomany',
	// 				'object'=>'cfd_student',
	// 			],
	// 			'cfd_course'=>[
	// 				'title'=>'Course',
	// 				'view' =>'relationship_onetomany',
	// 				'object'=>'cfd_course',
	// 			],
	// 	    ],
	// 	]
	// ];


	$add_object[] = [
		'cfd_contact',
    	1,
		[
		    'table'=>'cfd_contact',
		    'title'=>'Contact',
		    'slug'=>'cfd_contact',
		    'fields'=>[
		        'title'=>[
		            'title'=>'title',
		            'view'=>'text',
		            'required'=>true,
		            'validation'=>[
		            	'required'=>__('Tiêu đề là trường bắt buộc'),
		            	'max:255'=>__('Tiêu đề tối đa 255 ký tự'),
		            ]
		        ],
		        'name'=>[
		        	'title'=>'Name',
		        	'validation'=>[
		            	'required'=>__('Họ và tên là trường bắt buộc'),
		            ]
		        ],
		       	'phone'=>[
		       		'title'=>'Phone',
		       		'validation'=>[
		            	'required'=>__('Số điện thoại là trường bắt buộc'),
		            	// 'phone'=>__('Không đúng định dạng số điện thoại'),
		            ]
		       	],
		       	'email'=>[
		       		'title'=>'Email',
		       		'validation'=>[
		            	'required'=>__('Email là trường bắt buộc'),
		            	'email'=>__('Không đúng định dạng email'),
		            ]
		       	],
		       	'website'=>[
		       		'title'=>'Website',
		       		'validation'=>[
		            	'required'=>__('Website là trường bắt buộc'),
		            	'max:255'=>__('Website tối đa 255 ký tự'),
		            ]
		       	],
		       	'content'=>[
		       		'title'=>'Content',
		       		'textarea',
		       		'validation'=>[
		            	'required'=>__('Nội dung là trường bắt buộc'),
		            	'max:500'=>__('Nội dung tối đa 500 ký tự'),
		            	'min:8'=>__('Nội dung tối thiểu 8 ký tự'),
		            ]
		       	]
		    ],
		]
	];


	$add_object[] = [
		'cfd_register',
    	1,
		[
		    'table'=>'cfd_register',
		    'title'=>'Register',
		    'slug'=>'cfd_register',
		    'fields'=>[
		        'title'=>[
		            'title'=>'Name',
		            'view'=>'text',
		            'required'=>true,
		            'validation'=>[
		            	'required'=>__('Họ và tên là trường bắt buộc'),
		            	'max:255'=>__('Họ và tên tối đa 255 ký tự'),
		            ]
		        ],
		        'phone' => [
		            'title'=>'Phone',
		            'show_data'=>false,
		            'view' =>'text',
		            'validation'=>[
		            	'required'=>__('Số điện thoại là trường bắt buộc'),
		            ]
				],
				'email' => [
		            'title'=>'Email',
		            'show_data'=>false,
		            'view' =>'text',
		            'validation'=>[
		            	'required'=>__('Email là trường bắt buộc'),
		            	'email'=>__('Không đúng định dạng email'),
		            ]
				],
				'facebook'=>[
					'title'=>'Facebook',
					'view'=>'text',
		            'show_data'=>false,
		            'validation'=>[
		            	'required'=>__('URL Facebook là trường bắt buộc'),
		            	'max:255'=>__('URL Facebook tối đa 255 ký tự'),
		            ]
				],
				'payment_method'=>[
					'title'=>'Payment Method',
					'view'=>'text',
		            'validation'=>[
		            	'required'=>__('Hình thức thanh toán là trường bắt buộc'),
		            ]
				],
				'use_coin'=>[
					'title'=>'Sử dụng COIN',
					'view'=>'select',
					'list_option'=>[
						'no'=>['title'=>'No','color'=>'#797979'],
						'yes'=>['title'=>'Yes','color'=>'#f4744b'],
					],
				],
				'opinion'=>[
					'title'=>'Ý kiên',
					'view'=>'textarea',
				],
				'cfd_student'=>[
					'title'=>'Student',
					'view'=>'relationship_onetomany',
					'object'=>'cfd_student',
		            'show_data'=>false,
				],
				'cfd_course'=>[
					'title'=>'Course',
					'view'=>'relationship_onetomany',
		            'show_data'=>false,
				],
			],
		]
	];

	return $add_object;
});