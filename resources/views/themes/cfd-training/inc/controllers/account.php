<?php

function render_image_value($result, $thumbnail){

	$r = request();

	$r->merge([
		'data'=>$thumbnail
	]);

    if(  File::exists( $resources = cms_path('resource', 'views/admin/themes/default/particle/input_field/image/thumbnail.php') ) ){
        include $resources;
    }

    return json_encode($result);
}

return [
    'login'=>function($r){
		$email = strtolower( $r->get('email') );
        $user = get_posts('cfd_student',['count'=>1,'callback'=>function($q) use ($email) { return $q->where('email',$email); }]);

        if( !isset($user[0]) ){
			return response()->json(['message'=>__t('Email hoặc mật khẩu không đúng.')]);
        }
        
		if( !Hash::check( $r->get('password') , $user[0]->password) ){
			return response()->json(['message'=>__t('Email hoặc mật khẩu không đúng.')]);
        }
        
		session(['user_frontend' => $user[0]]);
		return response()->json(['success'=>true,'reload'=>true]);
	},
	'login-by-google'=>function($r){

		try {
			$content = json_decode(file_get_contents('https://www.googleapis.com/oauth2/v1/userinfo?access_token='.$r->get('access_token')),true);

			$email = $content['email'];
			
			$user = get_posts(get_admin_object('cfd_student')['table'], ['count'=>1,'callback'=>function($q) use ($email) {
				$q->where('email',$email);
			}]);

			if( isset($user[0]) ){
				session(['user_frontend' => $user[0]]);
				return response()->json(['success'=>true,'reload'=>true]);
			}else{
				return response()->json(['success'=>false,'message'=>'Không tìm thấy tài khoản, vui lòng đăng ký.']);
			}
		    

		} catch (Exception $e) {
			return response()->json(['message'=>'Error....']);
		}



		// try {
		// 	$content = json_decode(file_get_contents('https://www.googleapis.com/oauth2/v1/userinfo?access_token='.$r->get('access_token')),true);


		// 	$email = $content['email'];
			
		//  	$user = Vn4Model::firstOrAddnew(get_admin_object('cfd_student')['table'],['email'=>$email]);

		//     if(!$user->exists) {

		//        	$user->password = Hash::make(str_random(20));
		//        	$user->slug = time().str_slug($content['family_name']).'-'.str_slug($content['given_name']);
		// 	    $user->status = 'publish';
		// 	    $user->status_old = 'publish';
		// 	    $user->visibility = 'publish';
		// 	    $user->title = $content['name'];
		// 		$user->type = 'cfd_student';

		// 		$admin_object = get_admin_object($user->type);

		// 		$result = ['link'=> $content['picture'], 'type_link'=>'external'];
				
		// 		$avatar = render_image_value($result, $admin_object['fields']['avatar']['thumbnail'] );
		// 		$user->avatar = $avatar;

		// 		$user->save();
		//     }
		    
		// 	session(['user_frontend' => $user]);
		// 	return response()->json(['success'=>true,'reload'=>true]);

		// } catch (Exception $e) {
		// 	return response()->json(['message'=>'Error....']);
		// }

	},

	'register-by-google'=>function($r){
		try {
			$content = json_decode(file_get_contents('https://www.googleapis.com/oauth2/v1/userinfo?access_token='.$r->get('access_token')),true);

			$email = $content['email'];
			
		 	$user = Vn4Model::firstOrAddnew(get_admin_object('cfd_student')['table'],['email'=>$email]);

		    if(!$user->exists) {

		       	$user->password = Hash::make(str_random(20));
		       	$user->slug = time().str_slug($content['family_name']).'-'.str_slug($content['given_name']);
			    $user->status = 'publish';
			    $user->status_old = 'publish';
			    $user->visibility = 'publish';
			    $user->title = $content['name'];
				$user->type = 'cfd_student';
				$user->so_lan_duoc_doi_card_con_lai = 1;
				$user->student_type = 'thanh-vien';
				
				$admin_object = get_admin_object($user->type);

				$result = ['link'=> $content['picture'], 'type_link'=>'external'];
				
				$avatar = render_image_value($result, $admin_object['fields']['avatar']['thumbnail'] );
				$user->avatar = $avatar;

				$user->save();

				session(['user_frontend' => $user]);
				return response()->json(['success'=>true,'reload'=>true]);

		    }else{

				session(['user_frontend' => $user]);
				return response()->json(['success'=>true,'reload'=>true]);
		    	
				return response()->json(['message'=>'Tài khoản đã được đăng ký trước đây.']);
		    }

		} catch (Exception $e) {
			return response()->json(['message'=>'Error....']);
		}
	},
	'logout'=>function($r){
        $r->session()->forget('user_frontend');
        return redirect()->back();
	},
	'upload-avatar'=>function($r){

		$user = check_login_frontend();

		if( !$user ) return response()->json(['error'=>'Error']);

		$data = $r->get('data');

		list($type, $data) = explode(';', $data);

		list(, $data)      = explode(',', $data);
		$data = base64_decode($data);

		$file_name = 'users/CFDtraining-'.$user->id.'_'.time().'.jpg';

		file_put_contents( cms_path('public',$file_name), $data);

		$admin_object = get_admin_object($user->type);

		$result = ['link'=> $file_name, 'type_link'=>'local'];

		$avatar = render_image_value($result, $admin_object['fields']['avatar']['thumbnail'] );

		$user->avatar = $avatar;

		$user->save();

		return response()->json(['success'=>true, 'url'=> asset($file_name)]); 

	},
	'edit'=>function($r){

		$account = check_login_frontend();

		if( $account && $user = get_post('cfd_student', $account->id)){

			if( $input = $r->get('title') ){
				$user->title = $input;
			}

			if( $input = $r->get('phone') ){
				$user->phone = $input;
			}

			if( $input = $r->get('facebook') ){
				$user->facebook = $input;
			}

			if( $input = $r->get('skype') ){
				$user->skype = $input;
			}

			if( $input = $r->get('review') ){
				$user->review = $input;
			}

			$user->save();

			session(['user_frontend' => $user]);

			return redirect()->back();

		}

		return Redirect::back()->with('messages',['title'=>['Vui lòng đăng nhập']]);

	},

	'reset-password'=>function($r){

		$email = $r->get('email');
			
		$user = get_posts(get_admin_object('cfd_student')['table'], ['count'=>1,'callback'=>function($q) use ($email) {
			$q->where('email',$email);
		}]);

		if( !isset($user[0]) ){
			return response()->json(['success'=>false,'message'=>'Không tìm thấy tài khoản, vui lòng đăng ký.']);
		}

		$user = $user[0];


		$key = "cfdtraining_api_reset_password";

		$time = time();

		$payload = array(
			"name" => $user->title,
		    "email" => $user->email,
		    'time'=>$time,
		    'action'=>'reset_password'
		);

		$token = \Firebase\JWT\JWT::encode($payload, $key);

		$content = '<div class="container"><div class="emailform" style="background-color: #f4f7f6; max-width: 590px;margin: 20px auto;font-family: arial;line-height: 24px;"><div class="inner" style="padding:50px;"><div class="logo"><img src="'.theme_asset('img/logo2.png').'" alt="" style="width:100px;margin-bottom: 10px;"></div><div class="content"><h2>Reset mật khẩu.</h2><p>Xin chào <strong>'.$user->title.'</strong>,</p><p> Để reset mật khẩu, vui lòng nhấp vào đường dẫn bên dưới</p> <a href="'.route('page',['page'=>'reset-password','token'=>$token]).'" target="_blank" class="btn" style="background-color: #00afab; border-radius: 50px; padding:10px 20px;display: inline-flex;align-items: center;justify-content: center; color:#fff; font-weight: bold;text-decoration: none; text-transform: uppercase; font-size: 14px; margin-top: 20px;">Lấy lại mật khẩu</a><p>'.route('page',['page'=>'reset-password','token'=>$token]).'</p> <p> Chú ý; <br>Vì mục đích bảo mật, liên kết này sẽ hết hạn sau 24 giờ kể từ khi nó được gửi.<br>Nếu bạn không thể truy cập liên kết này, hãy sao chép và dán toàn bộ URL vào trình duyệt của bạn.<br></p></div></div><div class="bottom" style="font-size: 13px; background:#ddd;padding:30px 50px;color:#767676"><p style="margin:0 0 2px 0;">Đây là email được gửi từ hệ thống CFD.</p><p style="margin:0 0 2px 0;">Vui lòng không trả lời trực tiếp qua email này.</p><p style="margin:0;">Văn phòng CFD, số 11, Phan Kế Bính, Đa Kao, Quận 1, TP Hồ Chí Minh, Việt Nam.</p></div></div></div>';



		// $content = '<p>Dear '.$user->title.',<br><br>'
		// 	.'To reset your password, click this link.<br>'
		// 	.route('page',['page'=>'reset-password','token'=>$token]).'<br><br>'
		// 	.'Please note:<br>'
		// 	.'For security purposes, this link will expire 24 hours from the time it was sent.<br><br>'
		// 	.'If you cannot access this link, copy and paste the entire URL into your browser.<br><br>'
		// 	.'The CFD Team<br><br>'
		// 	.'Copyright 2020 CFDtraining. All rights reserved.</p>';


	 	Mail::send('themes.'.theme_name().'.emails.dynamic', ['content' =>$content], function($message) use ($user)
        {
            $message->from('no-reply@cfdtraining.vn', 'Cfdtraining.vn');
            $message->to($user->email, $user->title)->subject('[Cfdtraining.vn] Reset Password.');
        });

		return response()->json(['success'=>true,'message'=>'Vui lòng kiểm tra email để lấy lại mật khẩu.']);

	},

	'dat-lai-mat-khau'=>function($r){

		$input = $r->all();

		if( !$input['password'] ){
			return Redirect::back()->with('messages',['password'=>['Vui lòng nhập mật khẩu mới']])->withInput(Request::all());
		}
		
		if( $input['password'] != $input['confirm_pasword'] ){
			return Redirect::back()->with('messages',['confirm_pasword'=>['Xác nhận mật khẩu không đúng']])->withInput(Request::all());
		}

		$access_token = $r->get('access_token');

	    if( !$access_token ){
			return Redirect::back()->with('messages',['total'=>['Lỗi không xác định được user']])->withInput(Request::all());
	    }


	    $key = "cfdtraining_api_reset_password";
	    $decoded = (array) \Firebase\JWT\JWT::decode($access_token, $key, array('HS256'));

	    if( !$decoded ){ 
			return Redirect::back()->with('messages',['total'=>['Lỗi không xác định được user']])->withInput(Request::all());
	    }


	    $time = time();

	    if( ($time - $decoded['time']) > 86400 ){
			return Redirect::back()->with('messages',['total'=>['Lỗi hết thời gian thay đổi mật khẩu.']])->withInput(Request::all());
	    }


	    $user = get_posts(get_admin_object('cfd_student')['table'], ['count'=>1,'callback'=>function($q) use ($decoded) {
			$q->where('email',$decoded['email']);
		}]);

		$user = $user[0];	
		$user->password = Hash::make($input['password']);
        $user->save();	

		return Redirect::back()->with('success',true)->withInput(Request::all());

	},

	'doi-coin'=>function($r){
		$account = check_login_frontend();

		if( !$account ){
			return response()->json(['success'=>false,'message'=>'Vui lòng đăng nhập!.']);
		}

		include __DIR__.'/../function-helper.php';

		$total_coin = get_coin_hien_tai_cua_hoc_vien($account);

		$gifts = theme_options('gift_coin','gift');

		$gif = json_decode($r->get('gif'),true);

		if( isset($gif['index']) && isset($gifts[$gif['index']]) ){

			if( $total_coin < $gifts[$gif['index']]['coin']*1 ){
				return response()->json(['success'=>false,'message'=>'Bạn không đủ COIN để đổi phần quà này, vui lòng chọn phần quà khác.']);
			}else{
				$post = Vn4ModeL::newOrEdit('cfd_coin_history', [], [
		            'trang_thai'=>'cho-xet-duyet',
		            'title'=>'Đổi '.$gifts[$gif['index']]['label'],
		            'date'=>date('Y-m-d H:m:s'),
		            'coin'=> -$gifts[$gif['index']]['coin'],
		            'cfd_student'=>$account->id,
		            'cfd_course_register'=>0
		        ]);

		        if( $post ){
					return response()->json(['success'=>true,'message'=>'Đổi quà thành công, Vui lòng chờ xét duyệt.']);
		        }

				return response()->json(['success'=>true,'message'=>'Đổi quà thất bại.']);
			}

		}else{
			return response()->json(['success'=>false,'message'=>'Phần quà không hợp lệ, Vui lòng chọn phần quà khác.']);
		}

	}
	
];