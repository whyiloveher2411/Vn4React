<?php

return [
	'get'=>function($r){
		$students = get_posts('cfd_student',1000);

		foreach ($students as $student) {

			// $student->so_lan_duoc_doi_card_con_lai = 1;
			// $student->save();
			// $cfd_course = $student->relationship('cfd_course');

			// $temp = $student->related('cfd_course_register');

			// if( isset($temp[0]) ){
			// 	DB::table('cfd_course_register')->whereIn('id',$temp->pluck('id'))->delete();
			// }

			// if( isset($cfd_course[0]) ){
				
			// 	foreach ($cfd_course as $course) {
					

			// 		$payments = $course->related('cfd_payment_history','cfd_course',['callback'=>function($q) use ($student) {
			// 			$q->where('cfd_student',$student->id);
			// 		}]);

			// 		$payments_str = [];

			// 		foreach ($payments as $payment) {
			// 			$payments_str[] = [
			// 				'delete'=>0,
			// 				'date'=>$payment->date,
			// 				'money'=>$payment->money,
			// 			];
			// 		}

			// 		$register_post = Vn4Model::create( 'cfd_course_register', [], [
	  //   				'title'=>$student->title.' đã đăng ký khóa học '.$course->title.' ['.$course->course_type.']',
	  //   				'money'=> $course->money,
	  //   				'payment_method'=>'Chuyển khoản',
	  //   				'payment'=>json_encode($payments_str),
	  //   				'cfd_course'=>$course->id,
	  //   				'trang_thai'=>'duoc-duyet',
	  //   				'nguoi_gioi_thieu'=>0,
	  //   				'cfd_student'=>$student->id,
	  //   				'opinion'=> '',
	  //   			]);

			// 	}

			// }
		}

		dd(1);
	}
];