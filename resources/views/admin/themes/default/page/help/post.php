<?php

if( env('EXPERIENCE_MODE') ){
	return experience_mode();
}

if( $r->has('save_shortcuts') ){

	$shortcuts =  $r->get('shortcuts')??[];
	
	setting_save('shortcuts', $shortcuts);

	vn4_create_session_message( __('Success'), __('Update shortcuts success'), 'success', true );
	return redirect()->back();
}
