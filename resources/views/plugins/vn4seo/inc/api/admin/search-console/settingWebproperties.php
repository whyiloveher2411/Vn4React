<?php
require_once cms_path('public','../lib/google-client/vendor/autoload.php');

$input = $r->all();

if( isset($input['searchConsoleWebsites'][0]) ){
    $access_code = $plugin->getMeta('access_token_first');
    $dataMeta['searchConsoleWebsites'] = $input['searchConsoleWebsites'];
    $dataMeta['complete_installation'] = true;

    $plugin->updateMeta($dataMeta);

    return [
        'code'=>200,
        'success'=>true,
        'plugin'=>$plugin,
        'message'=> apiMessage('Setting Google Search Console Success.')
    ];
}else{
    return [
        'code'=>200,
        'message'=> apiMessage('Please choose the website you want reports','error')
    ];
}