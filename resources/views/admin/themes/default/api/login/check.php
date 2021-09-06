<?php

$r = request();

$input = json_decode($r->getContent(),true);

// Check login by email
$loginByEmail = setting('security_active_signin_with_google_account');
if( $loginByEmail && isset($input['loginByEmail']) ){

    try {
        $content = json_decode(file_get_contents('https://www.googleapis.com/oauth2/v1/userinfo?access_token='.$input['loginByEmail']),true);
        $email = $content['email'];

        $user = get_posts('user',['count'=>1,'callback'=>function($q) use ($email) {
            $q->where('email',$email)->where('status','publish');
        }]);

        if( isset($user[0]) ){

            return [
                'user'=>getResultLogin($user[0]),
                'sidebar'=>include __DIR__.'/../adminSidebar/get.php',
                'plugins'=>plugins()->keyBy('key_word'),
            ];

        }else{
            return [
                'message'=> apiMessage( 'Sign-in error: the account is not mapped with the existing account in the system.', 'error'  )
            ];
        }

    } catch (Exception $e) {
        return [
            'message'=> apiMessage( 'Error sign in with google.', 'error')
        ];
    }

}


//Check Recapcha
$recapCha = intval( setting('security_active_recapcha_google') );

if( $recapCha ){

    $url = 'https://www.google.com/recaptcha/api/siteverify';

    $data = array(
        'secret' => setting('security_recaptcha_secret'),
        'response' => $input['g-recaptcha-response']
    );

    $options = array(
        'http' => array (
            'header'=>'Content-Type: application/x-www-form-urlencoded\r\n'."Content-Length: ".strlen(http_build_query($data))."\r\n",
            'method' => 'POST',
            'content' => http_build_query($data)
        )
    );

    $context  = stream_context_create($options);

    $verify = file_get_contents($url, false, $context);
    $captcha_success=json_decode($verify);

    if ($captcha_success->success === false) {
        return [
            'message'=> apiMessage( 'Captcha website validation failed.', 'error')
        ];
    }

}

//Check User info
if( $user = Vn4Model::table('vn4_user')->where('email',trim($input['username']))->where('status','publish')->first() ){

    if (Hash::check( $input['password'] , $user->password)) {

        $googleAuthen = setting('security_active_google_authenticator');

        // Check 2-Step Verification
        if( $googleAuthen === '1' ){

            if( $input['showVerificationCode'] ){

                if( !$input['verification_code'] ){
                    return [
                        'message'=> apiMessage( 'Verification Code is required', 'error')
                    ];
                }

                require cms_path('root','lib/google-authenticator/Authenticator.php');

                $Authenticator = new \Authenticator();

                $checkResult = $Authenticator->verifyCode( setting('security_google_authenticator_secret'), $input['verification_code'], 2);

                if( !$checkResult ){
                    return [
                        'message'=> apiMessage( 'Authentication code incorrect.', 'error')
                    ];
                }else{

                    return [
                        'user'=>getResultLogin($user),
                        'sidebar'=>include __DIR__.'/../adminSidebar/get.php',
                        'plugins'=>plugins()->keyBy('key_word'),
                    ];

                }
            }else{
                return [
                    'requiredVerificationCode'=>true,
                ];
            }
            
        }else{
            return [
                'user'=>getResultLogin($user),
                'sidebar'=>include __DIR__.'/../adminSidebar/get.php',
                'plugins'=>plugins()->keyBy('key_word'),
            ];
        }
    }
}

return [
    'message'=> apiMessage('Username or password is incorrect','error')
];


function getResultLogin($user){

    unset($user->password);
    unset($user->refesh_token);

    $expires_in = setting('security_token_expiration_time') ? setting('security_token_expiration_time')*1 : 60*60 ;

    $createdTime = time();

    $key = config('app.key');

    $payload = array(
        'id'=> $user->id,
        'remember_token'=>$user->remember_token, //Check change password
        'expires_in'=>$expires_in,
        'expires_time'=>$createdTime + $expires_in,
        'permission'=>'__full'
    );

    $jwt = \Firebase\JWT\JWT::encode($payload, $key);

    $user->expires_in = $expires_in - (time() - $createdTime);
    $user->access_token = $jwt;

    return $user;
}