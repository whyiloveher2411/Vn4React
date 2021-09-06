<?php

if( env('EXPERIENCE_MODE') ){
    return experience_mode();
}

$websites = $r->get('websites');

function setEnvironmentValue($envFile, array $values)
{
    $str = file_get_contents($envFile);

    if (count($values) > 0) {
        foreach ($values as $envKey => $envValue) {

            $str .= "\n"; 
            $keyPosition = strpos($str, "{$envKey}=");
            $endOfLinePosition = strpos($str, "\n", $keyPosition);
            $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);

            // If key does not exist, add it
            if (!$keyPosition || !$endOfLinePosition || !$oldLine) {
                $str .= "{$envKey}={$envValue}\n";
            } else {
                $str = str_replace($oldLine, "{$envKey}={$envValue}", $str);
            }

        }
    }

    $str = substr($str, 0, -1);
    if (!file_put_contents($envFile, $str)) return false;
    return true;
}


foreach ($websites as $w => $value) {

    if( isset($value['admin']) && ($parse_url = parse_url($value['admin'])) && isset($parse_url['host']) ){

        $value['domain'] = $parse_url['host'];
        
    	File::isDirectory(cms_path('root','site/'.$value['domain'])) or File::makeDirectory(cms_path('root','site/'.$value['domain']), 0777, true, true);

    	file_put_contents(cms_path('root','site/'.$value['domain'].'/info.json'), json_encode($value));

    	$url = isset($value['https']) && $value['https'] ? 'https://'.$value['domain'] : 'http://'.$value['domain'] ;

    	setEnvironmentValue(cms_path('root','site/'.$value['domain'].'/.env'), ['APP_URL'=>$url]);

    }
}

vn4_create_session_message( __('Success'), __('Update website success'), 'success', true );
return redirect()->back();
