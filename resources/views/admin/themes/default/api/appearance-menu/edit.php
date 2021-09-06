<?php

include __DIR__.'/__helper.php';

$result = [];
$action = $r->get('action');

if( $action === 'edit' ){
    if( appearance_menu_edit($r->all()) ){
        $result['message'] = apiMessage('Edit menut successfully.');
        $result['success'] = true;
    }else{
        $result['message'] = apiMessage('Edit menut failed.','error');
        $result['success'] = false;
    }
}else{
    if( appearance_menu_new_menu($r->all()) ){
        $result['message'] = apiMessage('Successfully added new menu.');
        $result['success'] = true;
    }else{
        $result['message'] = apiMessage('Add menu failed.','error');
        $result['success'] = true;
    }
}

$result = appearance_get_data($result);

return $result;
