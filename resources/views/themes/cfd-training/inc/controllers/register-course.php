<?php

return [
	
	'post'=>function($r){

		if( $r->isMethod('POST') ){

			$input = $r->all();

    		$account = check_login_frontend();

    		$khoahoc = get_post('cfd_course',$r->get('cfd_course'));
    		
    		if( !$khoahoc ) return redirect()->route('page','khoa-hoc');

			$result = Vn4Model::create('cfd_register', [] , $r->all() );

			if( $result['error'] ){
				return Redirect::back()->with('messages',$result['error'])->withInput(Request::all());
			}
			
			if( !$account ){

    			$email = $result['post']->email;

			 	$user = Vn4Model::firstOrAddnew(get_admin_object('cfd_student')['table'],['email'=>$email]);

			    if( !$user->exists) {

			       	$user->password = Hash::make(str_random(20));
			       	$user->slug = time().str_slug($result['post']->title);
				    $user->status = 'publish';
				    $user->status_old = 'publish';
				    $user->visibility = 'publish';
				    $user->title = $result['post']->title;
					$user->type = 'cfd_student';
					$user->so_lan_duoc_doi_card_con_lai = 1;
					$user->student_type = 'thanh-vien';
					$user->phone = $result['post']->phone;
					$user->facebook = $result['post']->facebook;
					
					
					$admin_object = get_admin_object($user->type);

					$user->save();

					$account = $user;

			    }else{
					$account = $user;
			    }

		    }

    		if( $account->related('cfd_course_register','cfd_student',['count'=>true, 'callback'=>function($q) use ($khoahoc){ $q->where('cfd_course',$khoahoc->id); }]) ){
				return Redirect::back()->with('messages','Bạn đã đăng ký khóa học này, vui lòng chọn khóa khác.')->withInput(Request::all());
    		}

			$nguoi_gioi_thieu = get_nguoi_gioi_thieu($account);

			if( !$nguoi_gioi_thieu ){
			 	$nguoi_gioi_thieu = 0;
			 	$money = $khoahoc->money;
			}else{
				$nguoi_gioi_thieu = $nguoi_gioi_thieu->id;	
			 	$money = $khoahoc->money - $khoahoc->money_affiliate_1*1000;
			}


			$money2 = $money;


			$data = [
				'title'=>$result['post']->title.' đã đăng ký khóa học '.$khoahoc->title.' ['.$khoahoc->course_type.']',
				'money'=> $money,
				'payment_method'=>$r->get('payment_method'),
				'payment'=>'',
				'cfd_course'=>$r->get('cfd_course'),
				'trang_thai'=>'cho-xet-duyet',
				'nguoi_gioi_thieu'=>$nguoi_gioi_thieu,
				'cfd_student'=>$account->id,
				'opinion'=> $r->get('opinion'),
			];
			if( isset($input['use_coin']) && $input['use_coin'] == 'yes' ){
				include __DIR__.'/../function-helper.php';

				$coin_current = get_coin_hien_tai_cua_hoc_vien($account);

				if( $money >= $coin_current*1000 ){
					$data['coin_use'] = $coin_current;
					$money2 = $money - $coin_current*1000;
				}else{
					$data['coin_use'] = $money/1000;
					$money2 = 0;
				}

			}

			$register_post = Vn4Model::create( 'cfd_course_register', [], $data );

			$content2 = '<p>Đã có 1 thành viên đăng ký khóa học mới<br><br>'
			.'Họ tên: '.$result['post']->title.'<br>'
			.'Số điện thoại: '.$result['post']->phone.'<br>'
			.'Facebook: '.$result['post']->facebook.'<br>'
			.'Khóa học: '.$khoahoc->title.' ['.$khoahoc->course_type.']<br>'
			.'Kiểm tra chi tiết bằng link bên dười <br>'
			.'https://www.cfdtraining.vn/adm1n/create_data/cfd_course_register?post='.$register_post['post']->id.'&action_post=edit<br>';
				



		 	$content = '<div class="container">
		        <div class="emailform" style="background-color: #f4f7f6; max-width: 590px;margin: 20px auto;font-family: arial;line-height: 24px;">
		            <div class="inner" style="padding:50px;">
		                <div class="logo"><img src="'.theme_asset('img/logo2.png').'" alt="" style="width:100px;margin-bottom: 10px;"></div>
		                <div class="content">
		                    <h2>Đăng ký khóa học tại CFD.</h2>
		                    <p>Chào mừng tân binh <strong>'.$result['post']->title.'</strong>,</p>
		                    <p>
		                        Bạn đã đăng ký khóa học <a href="#" target="_blank" style="text-decoration: none;color:#00afab"><strong>'.($khoahoc?$khoahoc->title:'').'</strong></a> tại <strong>CFD</strong> thành công, chúng tôi sẽ chủ động liên hệ thông qua số điện thoại của bạn.
		                    </p>

		                    '.($khoahoc ? '<p>
		                       	Ngày khai giảng dự kiến: '.get_date($khoahoc->opening_time).'<br>Học phí: '.number_format($money2).' VNĐ
		                    </p>': '' ).'
		                    
		                    <a href="'.route('index').'"  target="_blank" class="btn" style="background-color: #00afab; border-radius: 50px;
		                    padding:10px 20px;display: inline-flex;align-items: center;justify-content: center; color:#fff;
		                    font-weight: bold;text-decoration: none;
		                    text-transform: uppercase; font-size: 14px; margin-top: 20px;">Trang chủ CFD</a>
		                </div>
		                
		            </div>
		            <div class="bottom" style="font-size: 13px; background:#ddd;padding:30px 50px;color:#767676">
		                <p style="margin:0 0 2px 0;">Đây là email được gửi từ hệ thống CFD.</p>
		                <p style="margin:0 0 2px 0;">Vui lòng không trả lời trực tiếp qua email này.</p>
		                <p style="margin:0;">Văn phòng CFD, số 11, Phan Kế Bính, Đa Kao, Quận 1, TP Hồ Chí Minh, Việt Nam.</p>
		            </div>
		        </div>
		    </div>';

	      

		 	Mail::send('themes.'.theme_name().'.emails.dynamic', ['content' =>$content], function($message) use ($result)
	        {
	            $message->from('no-reply@cfdtraining.vn', 'Cfdtraining.vn');
	            $message->subject('[Cfdtraining.vn] Welcome to CFD.');
	            $message->to($result['post']->email, $result['post']->title);
	        });

	       
		 	Mail::send('themes.'.theme_name().'.emails.dynamic', ['content' =>$content2], function($message)
	        {
	            $message->from('no-reply@cfdtraining.vn', 'Cfdtraining.vn');
	            $message->subject('[Cfdtraining.vn] New Register.');
	            $message->to('trannghia2018@gmail.com','Trần Nghĩa');
	            $message->bcc('dangthuyenquan@gmail.com', 'Đặng Thuyền Quân');
	        });

			return Redirect::back()->with('success',true)->withInput(Request::all());
			

		}

		return redirect()->back();

	}
];