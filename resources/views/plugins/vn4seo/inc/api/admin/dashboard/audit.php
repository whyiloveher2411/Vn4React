<?php

$strategys = ['mobile','desktop'];
$categorys = ['performance'=>'performance', 'seo'=>'seo', 'best_practices'=>'best-practices','accessibility'=>'accessibility'];
$locale = 'vi_VN';

$input = json_decode($r->getContent(),true);


$settings = setting('seo/analytics/google_search_console');

$url = $settings['anylticWebsite'];

$result = [];

foreach ($categorys as $catKey => $cat) {
	
	$result[$catKey] = [];

	foreach ($strategys as $strategy) {
		
		$result[$catKey][$strategy] = Cache::rememberForever('google-speed-'.$catKey.$strategy.$url, function() use ($url, $strategy, $catKey, $locale) {

				$query = http_build_query([
					'url'=>$url,
					'strategy'=>$strategy,
					'category'=>$catKey,
					'locale'=>$locale
				]);

				$result = false;

				while (!$result || isset($result['error'])) {
			 		$result = json_decode(file_get_contents_curl('https://www.googleapis.com/pagespeedonline/v5/runPagespeed?'.$query),true);
				}

				return $result;
	
		});

	}

}


if( isset($input['dashboard']) && $input['dashboard'] === true ){
	$result2 = [];

	foreach ($categorys as $catKey => $cat) {
		
		$result2[$catKey] = [];

		foreach ($strategys as $strategy) {
			$result2[$catKey][$strategy] = $result[$catKey][$strategy]['lighthouseResult']['categories'][$cat]['score'];

		}

	}

	return $result2;

}

return $result;