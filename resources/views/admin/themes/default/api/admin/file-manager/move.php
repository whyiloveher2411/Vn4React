<?php

include __DIR__.'/__helper.php';

if( ($file = $r->get('file')) && ($folder = $r->get('folder')) ){

    $message = '';

    if( __moveFileOrFolder($file, $folder, $message, false) ){
        return [
            'success'=>true
        ];  
    }
    
    return [
        'message'=>$message,
        'success'=>false
    ]; 

}

return [
    'message'=>apiMessage('Move File failed','error'),
    'success'=>false
];