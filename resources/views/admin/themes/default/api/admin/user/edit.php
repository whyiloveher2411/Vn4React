<?php


function validatePassword($password){
    if( strlen($password) >= 8 ){
        return true;
    }else{
        return false;
    }
}

$userEdit = get_post('user', getUser()->id);

$id = $r->get('id');

$user;

$input = [];

if( !($first_name = $r->get('first_name')) ){
    return [
        'error'=>1,
        'message'=>apiMessage('First name is required.','error')
    ];
}

$input['first_name'] = $first_name;

if( !($last_name = $r->get('last_name')) ){
    return [
        'error'=>1,
        'message'=>apiMessage('Last name is required.','error')
    ];
}

$input['last_name'] = $last_name;

$input['slug'] = registerSlug( $input['first_name'].'-'. $input['last_name'], 'user', false , false );

$action;

if( $id ){

    $user = get_post('user', $id);

    if( !$user ){
        return [
            'error'=>1,
            'message'=>apiMessage('User not found')
        ];
    }

    foreach( $input as $key => $value ){
        $user->{$key} = $value;
    }

    $action = 'EDIT';

}else{
    $user = Vn4Model::createPost('user', $input, false);
    $action = 'NEW';
}


$user->role = $r->get('role','');

$permission = $r->get('permission',[]);

if( is_array($permission) ){
    $permission = implode(', ', $permission );
}

$user->permission = $permission;

$avata = $r->get('profile_picture');

$user->profile_picture = is_array($avata)?json_encode($avata):$avata;

$password = $r->get('password');

$messageSuccess;

if( $action === 'NEW' ){
    
    if( !$password ){
        return [
            'error'=>1,
            'message'=>apiMessage('Password is required.','error')
        ];
    }

    if( !validatePassword($password) ){
        return [
            'error'=>1,
            'message'=>apiMessage('Password length must be greater than or equal to 8 characters','error')
        ];
    }

    $user->password = Hash::make($password);

    $messageSuccess = apiMessage('Account successfully created.');

}else{

    if( $password ){

        if( $userEdit->id === $user->id ){
            
            $old_password = $r->get('old_password');
            if ( !Hash::check(  $old_password , $user->password  ) ){
                return [
                    'error'=>1,
                    'message'=>apiMessage('Old password is not correct','error')
                ];
            }
        }

        if( !validatePassword($password) ){
            return [
                'error'=>1,
                'message'=>apiMessage('Password length must be greater than or equal to 8 characters','error')
            ];
        }

        $user->password = Hash::make($password);
    }

    $messageSuccess = apiMessage('Edit account successfully.');
}

$user->updateMeta($r->get('meta'));

$user->save();

unset($user->password);
unset($user->remember_token);

return [
    'error'=>0,
    'user'=>$user,
    'message'=>$messageSuccess
];

