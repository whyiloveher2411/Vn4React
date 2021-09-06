<?php

include __DIR__.'/__helper.php';

if(  ($file = $r->get('file')) && isset($file['dirpath']) && isset($file['basename']) ){
    
    $message = '';

    $is_dir = $file['is_dir'] ?? false;

    $result = __deleteFile( $file, $message );

    if( $result ){
        return [
            'message'=> apiMessage( $is_dir ? 'Delete folder successfully' : 'Delete file successfully' ), 
            'success'=>true
        ];
    }

    return [
        'message'=>$message
    ];
}

return [
    'sucess'=>false
];