<?php
include __DIR__.'/__helper.php';

$file = $r->get('file');
$folder = $r->get('folder');

if( isset($file['filename']) && $file['filename'] && $folder){

    $message = false;

    $result = __createFolder( $folder, $file['filename'], $message);

    if( $result ){
        return [
            'message'=> apiMessage( 'Successfully created folder' ), 
            'success'=>true
        ];
    }

    return ['message'=>$message];
}


return [
    'message'=>apiMessage('Please enter folder name', 'error')
];