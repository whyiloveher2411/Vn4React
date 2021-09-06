<?php

return [
	'change-status-menu'=>function($r){

		$user = Auth::user();

        $name = $r->get('name','collapse');

        if( $name === 'collapse' ){
            $result = $user->getMeta('collapse',false);
            $user->updateMeta('collapse',!$result);
        }

        return response()->json(['result'=>!$result]);
	},
	'set-user-mode-view'=>function( $r ){

		$mode = $r->get('mode');

        if( file_exists( cms_path('public','admin/css/mode/'.$mode.'.css') ) ){
            Auth::user()->updateMeta('admin_mode',[$mode, $r->get('name')]);
            return response()->json(['reload'=>true]);
        }

        return response()->json(['message'=>'Not Found Mode.']);
		
	},


    'login-by-google'=>function($r){
        try {
            $content = json_decode(file_get_contents('https://www.googleapis.com/oauth2/v1/userinfo?access_token='.$r->get('access_token')),true);

            $email = $content['email'];

            $user = get_posts('user',['count'=>1,'callback'=>function($q){
                $q->where('status','publish');
            }]);

            
            
            return response()->json(['success'=>true,'reload'=>true]);

        } catch (Exception $e) {
            return response()->json(['message'=>'Error....']);
        }
    }

];