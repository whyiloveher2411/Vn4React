<?php

$r = request();

$result = [];

// if( config('app.EXPERIENCE_MODE') ){
//     return experience_mode();
// }
$user = get_post('user',$r->get('id'));

$input = $r->all();

$update_data = $r->only(['number_phone','url_social_network','description','profile_picture','active_show_toolbar']);

if( !isset($update_data['active_show_toolbar']) || $update_data['active_show_toolbar'] === null ){
	$update_data['active_show_toolbar'] = 0;
}

$update_data['url_social_network'] = isset($update_data['url_social_network'])?json_encode($update_data['url_social_network']):'';

// $update_data = array_map('trim',$update_data);

if( $r->get('security_google_authenticator_secret') ){
	$update_data['security_google_authenticator_secret'] = $r->get('security_google_authenticator_secret');
}

$password = $r->get('password_'.$user->id);

if( $password ){
  
    if( strlen($password) >= 8 ){

        $user->password = Hash::make($password);

    }else{
        $result['message'] = apiMessage('Password length must be greater than or equal to 8 characters', 'error');
        return $result;
    }

}


// if( check_permission('user-new_view') ){

if( ($permission = $r->get('permission',false)) && is_array($permission) ){
	$user->permission = implode(', ', $permission);
}

// }

$user->role = $input['role'];

$user->first_name = $input['first_name'];
$user->last_name = $input['last_name'];
$user->profile_picture = is_array($input['profile_picture'])?json_encode($input['profile_picture']):$input['profile_picture'];
$user->save();

$user->updateMeta($update_data);

$result['user'] = $user;

$result['message'] = apiMessage('Update profile success.');

return $result;