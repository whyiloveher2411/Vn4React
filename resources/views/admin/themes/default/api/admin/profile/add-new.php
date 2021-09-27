<?php

$r = request();

$result = [];

// if( config('app.EXPERIENCE_MODE') ){
//     return experience_mode();
// }
$input = $r->all();

if( !isset($input['first_name']) ){
    return [
        'message'=>apiMessage('First name is required.','error')
    ];
}

if( !isset($input['last_name']) ){
    return [
        'message'=>apiMessage('Last name is required.','error')
    ];
}

$input['slug'] = registerSlug( $input['first_name'].'-'. $input['last_name'], 'user', false , false );

if( !isset($input['email']) ){
    
    return [
        'message'=>apiMessage('Email is required.','error')
    ];

}elseif( 

    get_posts('user',['count'=>true,'callback'=>function($q) use ($input) { $q->where('email', $input['email']); } ]) > 0

 ){
    return [
        'message'=>apiMessage('Email is exists.','error')
    ];
}

if( !isset($input['_password']) ){
    return [
        'message'=>apiMessage('Password is required.','error')
    ];
}

$input['password'] = Hash::make($input['_password']);

$userEdit = Vn4Model::createPost('user', $input, false);

$update_data = array_merge(
    [
        'number_phone'=>'',
        'url_social_network'=>'',
        'description'=>'',
        'profile_picture'=>'',
        'active_show_toolbar'=>'',
    ],
    $r->only(['number_phone','url_social_network','description','profile_picture','active_show_toolbar'])
);

if( !isset($update_data['active_show_toolbar']) || $update_data['active_show_toolbar'] === null ){
	$update_data['active_show_toolbar'] = 0;
}

$update_data['url_social_network'] = isset($update_data['url_social_network'])?json_encode($update_data['url_social_network']):'';

// $update_data = array_map('trim',$update_data);

if( $r->get('security_google_authenticator_secret') ){
	$update_data['security_google_authenticator_secret'] = $r->get('security_google_authenticator_secret');
}

$password = $r->get('password_'.$userEdit->id);

if( $password ){
  
    if( strlen($password) >= 8 ){

        $userEdit->password = Hash::make($password);

    }else{

        $result['message'] = apiMessage('Password length must be greater than or equal to 8 characters', 'error');

        return $result;
    }

}


// if( check_permission('user-new_view') ){

if( ($permission = $r->get('permission',false)) && is_array($permission) ){
	$userEdit->permission = implode(', ', $permission);
}

// }

$userEdit->role = $input['role'];

$userEdit->first_name = $input['first_name']??'';
$userEdit->last_name = $input['last_name']??'';

if( isset($input['profile_picture']) ){

    if( is_array($input['profile_picture']) ){
        $userEdit->profile_picture = json_encode($input['profile_picture']);
    }else{
        $userEdit->profile_picture = $input['profile_picture'];
    }

}else{
    $userEdit->profile_picture = '';
}

$userEdit->save();

$userEdit->updateMeta($update_data);

$result['user'] = $userEdit;

$result['message'] = apiMessage('Update profile success.');

return $result;