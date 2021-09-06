<?php
if( !function_exists('tinh_coin_hien_tai_cua_hoc_vien') ){
	function tinh_coin_hien_tai_cua_hoc_vien($hocvien){
	   	$result = DB::table('cfd_student')->where('id',$hocvien->id)->update(['total_coin_current'=> DB::raw('(SELECT SUM(coin) AS "total" FROM cfd_coin_history WHERE trang_thai = "duoc-duyet" AND cfd_student = '.$hocvien->id.')')]);

		Cache::forget('cfd_student_'.$hocvien->id);
		Cache::forget('getPostBySlug_cfd_student##slug##'.$hocvien->slug);

	   return $result;
	}

	function get_coin_hien_tai_cua_hoc_vien($hocvien){
		return DB::select(DB::raw('(SELECT SUM(coin) AS "total" FROM cfd_coin_history WHERE trang_thai = "duoc-duyet" AND cfd_student = '.$hocvien->id.')'))[0]->total*1;
	}
}
