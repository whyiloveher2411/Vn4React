<?php
function multiple_threads_request($nodes){
    $mh = curl_multi_init();
    $curl_array = array();
    foreach($nodes as $i => $url)
    {
        $curl_array[$i] = curl_init($url);
        curl_setopt($curl_array[$i], CURLOPT_RETURNTRANSFER, true);
        curl_multi_add_handle($mh, $curl_array[$i]);
    }
    $running = NULL;
    do {
        usleep(10000);
        curl_multi_exec($mh,$running);
    } while($running > 0);
   
    $res = array();
    foreach($nodes as $i => $url)
    {
        $res[$i] = json_decode( curl_multi_getcontent($curl_array[$i]) , true);
    }
   
    foreach($nodes as $i => $url){
        curl_multi_remove_handle($mh, $curl_array[$i]);
    }
    curl_multi_close($mh);       
    return $res;
}

function get_url_google_analytics($url, $id,$metrics ,array $dimensions, $access_token, $dateStart, $dateEnd, $param  = [] ){

  $url = $url.'?userIp='.request()->ip().'&ids=ga:'.$id.'&start-date='.$dateStart.'&end-date='.$dateEnd;

  if( is_string($metrics) ){
    $url .= '&metrics='.$metrics;
  }else{
    $url .= '&metrics='.implode(',',$metrics);
  }

  if( isset($dimensions[0]) ) $url .= '&dimensions='.implode(',',$dimensions);

  foreach ($param as $key => $value) {
    $url .= '&'.$key.'='.$value;
  }
  $url .= '&access_token='.$access_token;

  return $url;
}