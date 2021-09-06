<?php 

  $r = request();

  if( $r->has('login_as') ){

    $user = Crypt::decrypt($r->get('login_as'));

    $user = App\User::find($user);

    if( !$user ) return redirect()->route('admin.index');

    if( $user->status === 'publish' ){
        Auth::loginUsingId($user->id);
        return redirect()->route('admin.index')->withCookie(cookie('unique_login_time', $user->getMeta('unique_login_time')));
    }

    return redirect()->back();

  }
