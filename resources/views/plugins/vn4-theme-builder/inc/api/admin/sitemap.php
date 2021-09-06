<?php

require_once __DIR__.'/../function-helper.php';


$access_token = searchConsoleGetAccessToken($plugin);

$query = http_build_query([
    "startDate"=> "2020-12-01",
    "endDate"=> "2021-02-02",
    'rowLimit'=>100,
    'searchType'=>'WEB',
]);


$result = json_decode(file_post_contents_curl('https://www.googleapis.com/webmasters/v3/sites/'.urlencode('sc-domain:vivosmartphone.vn') .'/searchAnalytics/query?access_token='.$access_token.'&'.$query),true);
dd($result);
if( isset($result['rows']) ){
    return $result;
}




$result = json_decode(file_get_contents_curl('https://www.googleapis.com/webmasters/v3/sites/'.urlencode('sc-domain:vivosmartphone.vn').'/sitemaps?access_token='.$access_token),true);


dd($result);