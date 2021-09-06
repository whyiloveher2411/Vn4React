<?php
require_once cms_path('public','../lib/google-client/vendor/autoload.php');

$input = $r->all();

$file_congig = __DIR__ . '/../../../client_secret_app.json';

if( file_exists($file_congig) ){

    $client = new Google_Client(['access_type'=>'offline']);

    // from the client_secrets.json you downloaded from the Developers Console.

    $client->setAuthConfig($file_congig);
    // Handle authorization flow from the server.

    $client->addScope(Google_Service_Webmasters::WEBMASTERS_READONLY);
}
$client->authenticate($input['access_code']);

$access_token = $client->getAccessToken();

if( isset($access_token['refresh_token']) ){

    $meta = [];

    $access_token['access_code'] = $input['access_code'];

    $meta['access_token_first'] = $access_token;

    $access_token = $access_token['access_token'];

    $sites = json_decode(file_get_contents_curl('https://www.googleapis.com/webmasters/v3/sites?access_token='.$access_token),true);

    if( isset($sites['error']) ){
        return [
            'error'=>true,
            'message'=> apiMessage($sites['error']['message'], 'error')
        ];
    }

    if( isset($sites['siteEntry']) ){

        $sitesMeta = [];

        foreach ($sites['siteEntry'] as $key => $value) {
            if( $value['permissionLevel'] === 'siteFullUser' || $value['permissionLevel'] === 'siteOwner' ){
                $sitesMeta[] = $value['siteUrl'];
            }
        }

        $meta['sites'] = $sitesMeta;
        $meta['searchConsoleWebsites'] = [];
        
        $plugin->updateMeta($meta);

        return [
            'plugin'=>$plugin,
        ];

    }

    return [
        'error'=>true,
        'message'=> apiMessage('Could not find any sites on this account','error')
    ];

    

}else{

    return [
        'error_code'=>405,
        'message'=>apiMessage('Get Access Token Error', 'error')
    ];

}