<?php

header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Connection: close");


function check_login_frontend(){

    $user = session('user_frontend');

    if( $user ) return $user;

	return false;
	
}

function get_nguoi_gioi_thieu($account = null){
 	$affiliate_token = Cookie::get('affiliate_token');

    $nguoi_gioi_thieu = false;

    if( $affiliate_token ){

        try {
            
            $key = "cfdtraining_api_link_gioi_thieu";

            $decoded = \Firebase\JWT\JWT::decode($affiliate_token, $key, array('HS256'));

            if( !$account ){
    			$account = check_login_frontend();
    		}
            
            $nguoi_gioi_thieu = get_post('cfd_student',$decoded);

            if( $nguoi_gioi_thieu && !$nguoi_gioi_thieu->related('cfd_course_register','cfd_student',['count'=>true, 'callback'=>function($q){ 
                $q->where('trang_thai','duoc-duyet');
            }]) ){
                return false;
            }

            if( $account && $nguoi_gioi_thieu ){


                if( $account->id == $nguoi_gioi_thieu->id ){
                    $nguoi_gioi_thieu = false;
                }

                if( $account->related('cfd_course_register','cfd_student',['count'=>true, 'callback'=>function($q){
                    $q->where('trang_thai','duoc-duyet');
                }])){
                    $nguoi_gioi_thieu = false;
                }
            }

        } catch (Exception $e) {
            $nguoi_gioi_thieu = false;
        }
    }

    return $nguoi_gioi_thieu;
}
