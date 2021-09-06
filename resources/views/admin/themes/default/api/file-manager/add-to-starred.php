<?php
include __DIR__.'/__helper.php';

$file = $r->get('file');
$value = $r->get('value');

if( $file ){

    $result = __updateStarred($file, $value);

    if( $result ){
        return [
            'success'=>true
        ];
    }

}

if( $value ){
    return [
        'message'=>apiMessage('Add to starred failed','error'),
        'success'=>false
    ];
}else{
    return [
        'message'=>apiMessage('Remove From Starred failed','error'),
        'success'=>false
    ];
}