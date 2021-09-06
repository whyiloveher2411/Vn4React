<?php

return [
	'set'=>function($r){

		 $key = "cfdtraining_api_link_gioi_thieu";

	    if( $affiliate_token = Request::get('affiliate_token') ){

	        try {

	            $decoded = \Firebase\JWT\JWT::decode($affiliate_token, $key, array('HS256'));
	            if( !$decoded ){
	                return vn4_redirect(route('page','khoa-hoc'));
	            }

	            $nguoi_gioi_thieu = get_post('cfd_student',$decoded);

	            if( !$nguoi_gioi_thieu ){
	                return vn4_redirect(route('page','khoa-hoc'));
	            }

	        	return redirect()->route('page','khoa-hoc')->withCookie(cookie('affiliate_token', $affiliate_token, 43200));

	        } catch (Exception $e) {

	             return vn4_redirect(route('page','khoa-hoc'));
	             

	        }


	    }

	    return redirect()->route('page','khoa-hoc');
	    
	}
];