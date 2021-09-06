<?php

include __DIR__.'/__helper.php';

if( ($file = $r->get('file')) && $color = $r->get('color') ){
    if( isset($file['dirpath']) && isset($file['basename']) ){

        $result = __updateColor( $file, $color);

        if( $result ){ 
            return [
                'sucess'=>true
            ];
        }
    }
}

return [
    'sucess'=>false
];