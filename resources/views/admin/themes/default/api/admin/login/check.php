<?php

$r = request();

$input =  $r->all();

$objectConfig = get_admin_object('user');

$remember_me = isset($input['remember_me'])? boolval($input['remember_me']) : false;
// Check login by email
$loginByEmail = setting('security_active_signin_with_google_account');

if( $loginByEmail && isset($input['loginByEmail']) ){

    try {
        $content = json_decode(file_get_contents('https://www.googleapis.com/oauth2/v1/userinfo?access_token='.$input['loginByEmail']),true);
        $email = $content['email'];

        $user = Vn4Model::table($objectConfig['table'])->where('email',$email)->where('status','publish')->first();

        // $user = get_posts('user',['count'=>1,'callback'=>function($q) use ($email) {
        //     $q->where('email',$email)->where('status','publish');
        // }]);

        if( $user ){

            return [
                'access_token'=>getUserToken($user, $remember_me),
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
$recapCha = intval( setting('security_active_recaptcha_google') );

if( $recapCha ){

    if( !isset($input['g-recaptcha-response']) ){
        return [
            'message'=> apiMessage( 'Captcha website validation failed.', 'error')
        ];
    }

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
if( $user = Vn4Model::table($objectConfig['table'])->where('email',trim($input['username']))->where('status','publish')->first() ){

    if (Hash::check( $input['password'] , $user->password)) {

        $googleAuthen = setting('security_active_google_authenticator');

        $result = [];

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
                }

            }else{
                //Need verification qr code
                return [
                    'requiredVerificationCode'=>true,
                ];
            }
            
        }

        $result['access_token'] = getUserToken($user, $remember_me);

        return $result;
    }
}

return [
    'message'=> apiMessage('Username or password is incorrect','error')
];


function getUserToken($user, $remember_me){
    $expires_in = setting('security_token_expiration_time') ? setting('security_token_expiration_time')*1 : 60*60 ;

    return createToken($user, [], $expires_in, null, null, $remember_me );
}