<?php
include __DIR__.'/__helper.php';

$file = $r->get('file');

if( $file ){

    $result = __downloadFile($user, $file, $message, $linkDownload, $user);

    if( $result ){
        return [
            'message'=>$message,
            'link'=>$linkDownload,
            'success'=>true
        ];
    }

    return [
        'message'=>apiMessage($message,'error'),
        'success'=>false,
    ];
}

return [
    'message'=>apiMessage('Download failed','error'),
    'success'=>false
];