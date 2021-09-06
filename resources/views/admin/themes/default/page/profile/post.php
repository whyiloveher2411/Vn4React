<?php 

if( env('EXPERIENCE_MODE') ){
    return experience_mode();
}

$user = Auth::user();

$input = $r->all();
$update_data = $r->only(['number_phone','url_social_network','description','active_show_toolbar']);

if( !isset($update_data['active_show_toolbar']) || $update_data['active_show_toolbar'] === null ){
	$update_data['active_show_toolbar'] = 0;
}

$update_data['url_social_network'] = isset($update_data['url_social_network'])?json_encode($update_data['url_social_network']):'';

$update_data = array_map('trim',$update_data);

if( $r->get('security_google_authenticator_secret') ){
	$update_data['security_google_authenticator_secret'] = $r->get('security_google_authenticator_secret');
}

if( $r->get('admin-mode') === 'light-mode' ){
	$update_data['admin_mode'] = ['light-mode','Light Mode'];
}else{
	$update_data['admin_mode'] = ['dark-mode','Dark Mode'];
}

$password = $r->get('password_'.$user->id);

if( $password ){
  
  	$old_password = $r->get('old_password');

	if ( Hash::check(  $old_password , $user->password  ) ){
		
		if( strlen($password) >= 8 ){

			$user->password = Hash::make($password);
			vn4_create_session_message(__('Success'),__('Change password successfully'),'success',true);

		}else{
			vn4_create_session_message(__('Warning'),__('Password length must be greater than or equal to 8 characters'),'warning',true);
		}

	}else{
		vn4_create_session_message(__('Error'),__('Old password is not correct'),'error',true);
	}

}else{
	vn4_create_session_message(__('Success'),__('Update profile successful'),'success',true);
}


if( check_permission('user-new_view') ){

	$user->permission = implode(', ', $r->get('permission',[]));

}



$user->first_name = $input['first_name'];
$user->last_name = $input['last_name'];
$user->profile_picture = $input['profile_picture'];
$user->save();

$user->updateMeta($update_data);


return redirect()->back();

