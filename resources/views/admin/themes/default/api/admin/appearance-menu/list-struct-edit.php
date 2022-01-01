<?php

include __DIR__.'/__helper.php';

if( $id = $r->get('id') ){

    $result = appearance_get_data($id, true);
    return $result;

}

return [
    'message'=>apiMessage('Menu not found')
];

