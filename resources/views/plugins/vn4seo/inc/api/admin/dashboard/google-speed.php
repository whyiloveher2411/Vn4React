<?php

$input = json_decode($r->getContent(),true);

if( $input['strategy'] !== 'mobile' && $input['strategy'] !== 'desktop' ) $input['strategy'] = 'mobile';


$settings = json_decode( setting('seo/analytics/google_search_console','[]'), true ) ?? [];

$url = $settings['anylticWebsite'];

return Cache::rememberForever('google-speed-'.$input['category'].$input['strategy'].$url, function() use ($input) {
	
	$query = http_build_query($input);

	$result = false;

	while (!$result || isset($result['error'])) {
 		$result = json_decode(file_get_contents_curl('https://www.googleapis.com/pagespeedonline/v5/runPagespeed?'.$query),true);
	}

	return $result;
	
});
