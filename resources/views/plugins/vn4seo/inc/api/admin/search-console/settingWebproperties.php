<?php
$input = $r->all();

if( isset($input['anylticWebsite']) && $input['anylticWebsite'] ){

    $dataMeta['anylticWebsite'] = $input['anylticWebsite'];
    $dataMeta['complete_installation'] = true;

    return [
        'code'=>200,
        'success'=>true,
        'value'=>$dataMeta,
    ];

}else{
    return [
        'code'=>200,
        'message'=> apiMessage('Please choose the website you want reports','error')
    ];
}