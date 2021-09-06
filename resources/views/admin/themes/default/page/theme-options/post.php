<?php
if( env('EXPERIENCE_MODE') ){
    return experience_mode();
}

$theme_option = $r->get('theme-option');

if( $theme_option ){
	foreach ($theme_option as $key => $value) {
		foreach ($value as $key2 => $value2) {
			save_theme_options($key,$key2,$value2);
			Cache::forget('theme-options.'.theme_name().'.'.$key);
		}
	}


	vn4_create_session_message( __('Success'), __('Update theme options success'), 'success', true );
}
return redirect()->back();
