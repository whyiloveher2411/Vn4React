<?php

if( env('EXPERIENCE_MODE') ){
	return experience_mode();
}

$valueUpdate = $r->get('env');

$valueUpdate['APP_DEBUG'] = isset($valueUpdate['APP_DEBUG']) ? 'true' : 'false';

$line = file('.env');

$count = count($line);

for ($i=0; $i < $count; $i++) { 

	$keyValue = explode('=', $line[$i]);

	if( isset($valueUpdate[$keyValue[0]]) ){
		$line[$i] = $keyValue[0].'='.$valueUpdate[$keyValue[0]]."\n";
	}
}
file_put_contents('.env', implode('',$line));

vn4_create_session_message( __('Success'), __('Update environment file success'), 'success', true );

return redirect()->back();
