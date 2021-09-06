<?php
return [
	'main.js'=>function($r){

		$route = $r->get('route');

		$user_guides = [];

		if( $route === 'admin.index' ){


			$user_guides['admin.index'] = [
					[
						'element'=>'.side-menu:nth(0)',
						'title' => 'Main Navigation',
				      	'content' => 'menu details each of the administrative functions you can perform. At the bottom of that section is a Collapse menu button that shrinks the menu into a set of icons, or to expands to list them by major function. Within each major function, such as Posts, the sub-menu expands when clicked',
				      	'placement'=>'right',
					],
					[
						'element'=>'.side-menu:nth(1)',
						'title' => 'Setting Navigation',
				      	'content' => 'Quản lý các thông tin cài đặt, thông số của website',
				      	'placement'=>'top',
					],
					[
						'element'=>'#vn4-nav-top-login',
				      	'title' => 'Toolbar',
				      	'content' => 'has links to various administration functions, and is displayed at the top of each Administration Screen. Many Toolbar items expand (flyout) when hovered over to display more information.',
				      	'placement'=>'bottom',
					],
					[
						'element'=>'.helper-link',
						'title'=>'Hỗ trợ',
						'content' => 'Bạn có thể tìm thấy các phương thức hỗ trợ ngay tại đây bằng cách click vào biểu tượng hỏi chấm.',
				      	'placement'=>'left',
					],
					[
						'element'=>'#newfeed',
				      	'title' => 'New Feed',
				      	'content' => 'Các thông báo từ plugin, theme hoặc từ CMS sẽ được thể hiện ở đây. Nó có thể là thông báo phiên bản, những cập nhật mới hoặc đơn giản là một câu chào ngày mới.',
				      	'placement'=>'bottom',
					],
					[
						'element'=>'#content',
				      	'title' => 'Work area',
				      	'content' => 'In the work area, the specific information relating to a particular navigation choice, such as adding a new post, is presented and collected.',
				      	'placement'=>'top',
					],
				];

		}elseif( $route === 'admin.show_data' ){

			$user_guides['admin.show_data'] = [
				[
					'element'=>'#datatable',
					'title' => 'Danh sách bài viết',
			      	'content' => '<p>Danh sách bài viết hiện có với các trạng thái được in đậm kế bên. </p><p> Rê chuột vào từng dòng để hiện các action có thể sử dụng với bài viết hiện tại</p><p> Nhấp chọn input checkbok để chọn từng dòng</p>',
			      	'placement'=>'top',
				],
				[
					'element'=>'.data_thead_page',
					'title' => 'Sắp xếp',
			      	'content' => '<p> Nhấp vào tiêu đề cột để sắp xếp thay phiên giảm dần hay tăng dần.</p><p> Nhấp chọn input checkbok để chọn tất cả</p>',
			      	'placement'=>'auto',
				],
				[
					'element'=>'.btn-create-data',
					'title' => 'Tạo bài viết mới',
			      	'content' => 'Thêm một bài viết mới',
			      	'placement'=>'bottom',
				],
				[
					'element'=>'.list_status',
					'title' => 'Bộ lộc',
			      	'content' => 'Các bộ lộc có sẳn giúp bạn tìm kiếm bài viết nhanh hơn',
			      	'placement'=>'auto',
				],
				[
					'element'=>'.quan_table_length label',
					'title' => 'Số lượng bài viết',
			      	'content' => 'Thay đổi số lượng bài viết hiển thị',
			      	'placement'=>'auto',
				],
				[
					'element'=>'.action-multi-post:nth(0)',
					'title' => 'Tác động',
			      	'content' => 'Chọn hành động tác động đến các bài viết được chọn, nó có thể là xóa tạm, phục hồi hoặc xóa vĩnh viễn bài viết',
			      	'placement'=>'auto',
				],
				[
					'element'=>'.advance-feature',
					'title' => 'Chức năng nâng cao',
			      	'content' => 'Các chức năng nâng cao như lộc kết quả theo ngày, nhóm bài viết theo danh mục, thay đổi hiển thị các cột, thay đổi giao diện hiển thị, xuất data (CSV, Excel, Json), làm mới data',
			      	'placement'=>'auto',
				],
				[
					'element'=>'.quan_table_filter input',
					'title' => 'Tìm kiếm',
			      	'content' => 'Tìm kiếm bài viết theo từ khóa.',
			      	'placement'=>'auto',
				],
				[
					'element'=>'.dataTables_info:nth(1)',
					'title' => 'Đang hiển thị',
			      	'content' => 'Thứ tự bài viết hiển thị trong trang',
			      	'placement'=>'auto',
				],
				[
					'element'=>'.dataTables_paginate:nth(1)',
					'title' => 'Trang hiển thị',
			      	'content' => 'Trang đang hiển thị',
			      	'placement'=>'auto',
				],


				
			];
		}


		header('cache-control: max-age=31536000');
		header('Content-Type: application/javascript');

		if( isset($user_guides[$r->get('route')]) ){
		?>
			$('.helper-link ul').prepend('<li><a href="javascript:void(0)" onclick="startIntro(event);"><label>User Guide</label></a></li>');

			window.startIntro = function(event){
				event.stopPropagation();


				var tour = new Tour({
				  steps: <?php  echo json_encode($user_guides[$r->get('route')]); ?>,
				  backdrop: true,
				  storage:false,
				  animation: false,
				  smartPlacement: true,
				   template: "<div class='popover tour'><div class='arrow'></div><h3 class='popover-title'></h3><div class='popover-content'></div><div class='popover-navigation'><button class='vn4-btn' data-role='prev'>« Prev</button> </span><button class='vn4-btn vn4-btn-blue' data-role='next'>Next »</button><button class='pull-right vn4-btn vn4-btn-blue' data-role='end'>End tour</button></div></div>",
				});

				tour.init();

				tour.start();
			}

		<?php
		}
		die();
	}
];