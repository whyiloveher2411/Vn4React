<?php

function apiMessage($message, $type = 'success', $optionsOther = []){

    return  array_merge([
        'content'=>$message,
        'options'=>[
                'variant'=>$type,
                'anchorOrigin'=>[
                    'vertical'=>'bottom',
                    'horizontal'=>'left'
                ]
            ]
        ],
        $optionsOther
    );

}


function checkAccessToken($name){

    if( !$GLOBALS['access_token']->user ){
        return false;
    }

    if( $GLOBALS['access_token']->expires_time < time() ){
        return false;
    }

    $user = $GLOBALS['access_token']->user;


    if( $user->role === 'Super Admin') return true;

    $permission = $user->permission;

    $permission = explode(', ',  $permission );

    if( is_string($name) ){
        return array_search($name,$permission) !== false;
    }

    if( is_array($name) ){

        foreach ($name as $p) {
            if( array_search($p, $permission) === false ){
                return false;
            }
        }

        return true;

    }

    return false;

}

function getAuthorizationHeader(){
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        }
        else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            //print_r($requestHeaders);
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return $headers;
    }
/**
 * get access token from header
 * */
function getBearerToken() {
    $headers = getAuthorizationHeader();
    // HEADER: Get the access token from the header
    if (!empty($headers)) {
        if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
            return $matches[1];
        }
    }else{
        $token = request()->get('access_token');
        if( $token ) return $token;
    }
    return null;
}

function createToken($user, $data, $time, $key = null ){

    $createdTime = time();

    $key =  $key ? $key : config('app.key');

    $payload = array_merge( $data, [
        'id'=> $user->id,
        'remember_token'=>$user->remember_token,
        'expires_in'=>$time,
        'expires_time'=>$createdTime + $time,
        'permission'=>'__full'
    ]);

    $jwt = \Firebase\JWT\JWT::encode($payload, $key);

    return $jwt;
}

function decodeToken($access_token, $key = null){

    $key = $key ? $key : config('app.key');

    $decoded = \Firebase\JWT\JWT::decode($access_token, $key, array('HS256'),true);

    $decoded->user = get_post('user', $decoded->id);

    if( $decoded->expires_time < time()
        || !$decoded->user  ){
        return false;
    }
    
    return $decoded;

}

function apiNotFound(){
    return response()->json( [
        'error_code'=>404,
        'message'=>apiMessage('Api Not Found', 'error')
    ], 404);
}