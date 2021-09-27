<?php

include __DIR__.'/__helper.php';

if( ( ($file = $r->get('file')) &&  $r->has('value') ) ){

    $value = $r->get('value');

    $result = __removeFile( $file, $value );
    
    if( $result ){ 
        return [
            'success'=>true
        ];
    }

}

return [
    'success'=>false
];