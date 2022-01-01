<?php
$input = $r->all();

if( isset($input['view']) && $input['view'] ){

    $listAnalyticsWebsite = [$input['view']];

    $listResult = [];

    if( isset($listAnalyticsWebsite[0]) ){

        foreach ($listAnalyticsWebsite as $key => $value) {
            $website = json_decode($value,true);
            $listResult[$website[0]] = $website;
        }

        $webid = reset($listResult);
        $access_code['webpropertie_id'] = $webid[0];
        $dataMeta['website'] = $webid;
    }

    // if( $country = $r->get('country') ){
        $dataMeta['country'] = $r->get('country');
    // }

    $dataMeta['listAnalyticsWebsite'] = $listResult;
    $dataMeta['complete_installation'] = true;

    return [
        'code'=>200,
        'success'=>true,
        'value'=>$dataMeta,
    ];
}else{
    return [
        'code'=>200,
        'message'=>apiMessage('Please choose the website you want reports','error')
    ];
}