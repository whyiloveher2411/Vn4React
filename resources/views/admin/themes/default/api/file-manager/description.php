<?php

include __DIR__.'/__helper.php';

if( ($file = $r->get('file')) && ($description = $r->get('description')) ){

    $message = '';

    if( __changeDescriptionFile($file, $description, $message ) ){

        return [
            'message'=>$message,
            'success'=>true
        ];  

    }

    return [
        'message'=>$message,
        'success'=>false
    ]; 

}

return [
    'message'=>apiMessage('Change Descirption failed','error'),
    'success'=>false
];