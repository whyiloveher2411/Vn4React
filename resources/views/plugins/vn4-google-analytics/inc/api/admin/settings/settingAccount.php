<?php
require_once cms_path('public','../lib/google-client/vendor/autoload.php');

$input = $r->all();

$file = $input['file_config_account'];

$config = [];

if( !is_array($file) ){
    $file = json_decode($file,true);
}

if( isset($file['link']) ){

    if( $file['type_link'] === 'local' ){
        $filePath = cms_path('public',urldecode($file['link']));
    }else{
        $filePath = $file['link'];
    }

    if( $filePath ){
        copy($filePath,__DIR__.'/../../../client_secret_app.json');
    }

    $config['complete_installation'] = false;
    $config['file_app_json'] = $filePath;
    $config['file_config_account'] = $file;

    $file_congig = __DIR__ . '/../../../client_secret_app.json';

    if( file_exists($file_congig) ){

        $client = new Google_Client(['access_type'=>'offline']);

        // from the client_secrets.json you downloaded from the Developers Console.

        $client->setAuthConfig($file_congig);
        // Handle authorization flow from the server.

        $client->addScope(Google_Service_Analytics::ANALYTICS_READONLY);
    }
    $auth_url = $client->createAuthUrl();
    return [
        'success'=>true,
        'authUrl'=>filter_var($auth_url, FILTER_SANITIZE_URL),
        'value'=>$config,
    ];

}


return [
    'code'=>200,
    'message'=>apiMessage('Please choose file config', 'error')
];