<?php 
// Icon: fa-pie-chart

$r = request();
$inpnut = json_decode($r->getContent(),true);

$plugin = plugin('vn4seo');

require_once __DIR__.'/../../../function-helper.php';

// require_once cms_path('public','../lib/google-client/vendor/autoload.php');

// $file_congig = __DIR__ . '/../client_secret_app.json';

// if( file_exists($file_congig) ){

//     $client = new Google_Client(['access_type'=>'offline']);
//     // from the client_secrets.json you downloaded from the Developers Console.

//     $client->setAuthConfig($file_congig);
//     // Handle authorization flow from the server.

//     $client->addScope(Google_Service_Webmasters::WEBMASTERS_READONLY);
// }

// $client->setAccessToken($plugin->getMeta('access_token_first'));


//     $q = new \Google_Service_Webmasters_SearchAnalyticsQueryRequest();

//     $q->setStartDate('2020-12-01');
//     $q->setEndDate('2020-12-31');
//     $q->setDimensions(['page']);
//     $q->setSearchType('web');

//     try {
//        $service = new Google_Service_Webmasters($client);

//        $u = $service->searchanalytics->query($plugin->getMeta('searchConsoleWebsite'), $q);

//        dd($u);
       
//      } catch(\Exception $e ) {
//         echo $e->getMessage();
//      }  

if( $inpnut['step'] === 'getDataOverview' ){

	$query = http_build_query([
		'startDate'=> $inpnut['date'][1],
		'endDate'=> $inpnut['date'][0],
		'rowLimit'=>1000,
		'searchType'=>'WEB',
		'dimensions'=>'date'
	]);

	$access_token = searchConsoleGetAccessToken($plugin);

	$result = json_decode(file_post_contents_curl('https://www.googleapis.com/webmasters/v3/sites/'.urlencode($inpnut['website']).'/searchAnalytics/query?access_token='.$access_token.'&'.$query),true);

	if( isset($result['rows']) ){
		return $result;
	}

	return [
		'error'=>true,
		'rows'=>[],
		'message'=>apiMessage('No data available.', 'warning')
	];
	
	
}

if( $inpnut['step'] === 'getDataDetail' ){

	$query = http_build_query([
		'startDate'=> $inpnut['date'][1],
		'endDate'=> $inpnut['date'][0],
		'rowLimit'=>1000,
		'searchType'=>'WEB',
		'dimensions'=>$inpnut['dimensions']
	]);

	$access_token = searchConsoleGetAccessToken($plugin);

	$result = json_decode(file_post_contents_curl('https://www.googleapis.com/webmasters/v3/sites/'.urlencode($inpnut['website']).'/searchAnalytics/query?access_token='.$access_token.'&'.$query),true);

	if( isset($result['rows']) ){
		return $result;
	}

	return [
		'error'=>true,
		'rows'=>[],
		'message'=> apiMessage('No data available.', 'warning')
	];

}