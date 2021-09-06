<?php
if( env('EXPERIENCE_MODE') ){
    return experience_mode();
}

$input = $r->all();

if($r->has('edit_user')){
    $user = Vn4Model::findCustomPost('user',$r->get('post',0));

    if( trim($input['password']) !== ''  && !isset(trim($input['password'])[5]) ){
        vn4_create_session_message( trans('master.word_fail'), 'Passwords must be greater than 5 characters.', 'fail' , true);

        return redirect()->back();
    }

    if( trim($input['password']) !== '' ){
        $user->password = Hash::make(trim($input['password']));
    }

}else{
    $user = Vn4Model::firstOrAddnew(get_admin_object('user')['table'],['email'=>$r->get('email')]);

    if($user->exists){

        vn4_create_session_message( trans('Fail'), trans('User email already exists, please select another email.'), 'fail' , true);

        return redirect()->back();

    }

    if( !isset(trim($input['password'])[5]) ){
        vn4_create_session_message( trans('Fail'), 'Passwords must be greater than 5 characters.', 'fail' , true);

        return redirect()->back();
    }

    $user->password = Hash::make(trim($input['password']));
    $user->status = 'publish';
    $user->status_old = 'publish';
    $user->visibility = 'publish';

}

$user->slug = registerSlug ( $input [ 'slug' ], 'user', $user->id );

$user->first_name = $input['first_name'];
$user->last_name = $input['last_name'];
$user->type = 'user';
$user->setTable(get_admin_object('user')['table']);

if( $r->get('security_google_authenticator_secret') ){
    $user->updateMeta('security_google_authenticator_secret',$r->get('security_google_authenticator_secret'));
}

$user->role = $r->get('role');

$user->permission = implode(', ', $r->get('permission',[]));

$user->save();

if($r->has('edit_user')){
    vn4_create_session_message( trans('Success'), 'Edit user to success.', 'success' , true);
}else{
    vn4_create_session_message( trans('Success'), 'Create successful user.', 'success' , true);
}

return redirect()->route('admin.page',['page'=>'user-new','post'=>$user->id]);