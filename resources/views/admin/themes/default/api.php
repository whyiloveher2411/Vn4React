<?php
/*
$data = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';

// // //data you want to sign
$pubkeyid = openssl_pkey_get_public(file_get_contents('public_key.pem'));

$signature = file_get_contents('signature.dat');
// state whether signature is okay or not
$ok = openssl_verify($data, $signature, $pubkeyid,OPENSSL_ALGO_SHA256);

if ($ok == 1) {
    echo "good";
} elseif ($ok == 0) {
    echo "bad";
} else {
    echo "ugly, error checking signature";
}
// free the key from memory
openssl_free_key($pubkeyid);

*/


/*
$configs['config'] = 'C:\Users\WIN10\Downloads\Apache24\conf\openssl.cnf';


$config = array(
    "digest_alg" => 'sha512',
    "private_key_bits" => 2048,
    "private_key_type" => OPENSSL_KEYTYPE_RSA,
);



//create new private and public key

$new_key_pair = openssl_pkey_new($configs + $config);

openssl_pkey_export($new_key_pair, $private_key_pem,null,$configs);

$details = openssl_pkey_get_details($new_key_pair);
$public_key_pem = $details['key'];
//create signature
openssl_sign($data, $signature, $private_key_pem, OPENSSL_ALGO_SHA256);

//save for later
file_put_contents('private_key.pem', $private_key_pem);
file_put_contents('public_key.pem', $public_key_pem);
file_put_contents('signature.dat', $signature);
//verify signature
$r = openssl_verify($data, $signature, $public_key_pem, "sha256WithRSAEncryption");
var_dump($r);
*/

Route::any('{group}/{file}/{param1?}/{param2?}/{param3?}',['as'=>'api_group', 'uses'=>function($group, $file, $param1 = null, $param2 = null, $param3 = null){

    $r = request();
    $user = false;

    if( $group !== 'login' && !($group === 'settings' && $file === 'all' ) ){

        $access_token = getBearerToken();

    	if( !$access_token ) return [ 'require_login'=>true ];

        $key = config('app.key');

        $decoded = \Firebase\JWT\JWT::decode($access_token, $key, array('HS256'),true);

        $decoded->user = get_post('user', $decoded->id);
        if( $decoded->expires_time < time()
            || !$decoded->user  ){

            return [ 'require_login'=>true ];
        }
        
        $GLOBALS['access_token'] = $decoded;
        $user = $decoded->user;

    }


    if( file_exists( $file = __DIR__.'/api/'.$group.'/'.$file.'.php') ){
	    return include $file;
    }

    return response()->json( [
        'error_code'=>404,
        'message'=>apiMessage('Api Not Found', 'error')
    ], 404);

}]);
