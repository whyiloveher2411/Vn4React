<?php
require_once cms_path('public','../lib/google-client/vendor/autoload.php');

$file_congig = __DIR__ . '/../../../client_secret_app.json';
$input = $r->all();

if( file_exists($file_congig) ){

    $client = new Google_Client(['access_type'=>'offline']);

    // from the client_secrets.json you downloaded from the Developers Console.

    $client->setAuthConfig($file_congig);
    // Handle authorization flow from the server.

    $client->addScope(Google_Service_Analytics::ANALYTICS_READONLY);
}
$client->authenticate($input['access_code']);

$access_token = $client->getAccessToken();

if( isset($access_token['refresh_token']) ){

    $access_token['access_code'] = $input['access_code'];

    $plugin->updateMeta('access_token_first',$access_token);

    $access_token = $access_token['access_token'];

    $accounts = json_decode(file_get_contents_curl('https://www.googleapis.com/analytics/v3/management/accounts?access_token='.$access_token),true);

    foreach($accounts['items'] as $key => $ac){

        $accounts['items'][$key]['webproperties'] = json_decode(file_get_contents_curl($ac['childLink']['href'].'?access_token='.$access_token),true);

    }

    file_put_contents(__DIR__.'/../accounts.json', json_encode($accounts));

    return [
        'account'=>$accounts,
        'plugin'=>$plugin,
    ];

}else{

    return [
        'error_code'=>405,
        'message'=>apiMessage('Get Access Token Error', 'error')
    ];

}