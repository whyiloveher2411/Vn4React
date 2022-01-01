<?php

include __DIR__.'/__helper.php';

$result = [];

if( appearance_menu_delete( $r->all() ) ){
    $result['message'] = apiMessage('Successfully Deleted new menu.');
    $result['success'] = true;
}else{
    $result['message'] = apiMessage('Delete menut failed.','error');
    $result['success'] = false;
}

$result = array_merge( $result , appearance_get_data() );

return $result;
