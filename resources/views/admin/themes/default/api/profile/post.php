<?php

$r = request();

// if( config('app.EXPERIENCE_MODE') ){
//     return experience_mode();
// }
$user = get_post('user',$r->get('id'));

$input = $r->all();

$update_data = $r->only(['number_phone','url_social_network','description','profile_picture','active_show_toolbar']);

if( !isset($update_data['active_show_toolbar']) || $update_data['active_show_toolbar'] === null ){
	$update_data['active_show_toolbar'] = 0;
}


$message = apiMessage('Update profile success.');

$update_data['url_social_network'] = isset($update_data['url_social_network'])?json_encode($update_data['url_social_network']):'';

// $update_data = array_map('trim',$update_data);

if( $r->get('security_google_authenticator_secret') ){
	$update_data['security_google_authenticator_secret'] = $r->get('security_google_authenticator_secret');
}

$password = $r->get('password_'.$user->id);

if( $password ){
  
  	$old_password = $r->get('old_password');

	if ( Hash::check(  $old_password , $user->password  ) ){

		if( $old_password === $password ){
			$message = apiMessage('New password must be different from old','error');
		}else{
			
			if( strlen($password) >= 8 ){

				$user->password = Hash::make($password);
				$message = apiMessage('Change password successfully');
				$user->remember_token = time();
				
			}else{
				$message = apiMessage('Password length must be greater than or equal to 8 characters','error');
			}
		}

	}else{
		$message = apiMessage('Old password is not correct','error');
	}

}else{
	$message = apiMessage('Update profile successful');
}

if( checkAccessToken( 'user_edit' ) ){

	if( $r->get('role') ){
		$user->role = $r->get('role','');
	}else{

		$permission = $r->get('permission',[]);

		if( is_array($permission) ){
			$permission = implode(', ', $permission );
		}

		$user->permission = $permission;
		$user->role = $r->get('role','');
	}

}

$user->first_name = $input['first_name'];
$user->last_name = $input['last_name'];
$user->profile_picture = is_array($input['profile_picture'])?json_encode($input['profile_picture']):$input['profile_picture'];
$user->save();

$user->updateMeta($update_data);

return [
	'user'=>$user,
    'message'=>$message
];