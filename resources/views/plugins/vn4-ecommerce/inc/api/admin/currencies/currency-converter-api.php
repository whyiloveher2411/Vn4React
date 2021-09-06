<?php

$key = $r->get('apiKey');

$type = $r->get('type');

if( !$key ){
    return [
        'message'=>apiMessage('Api key is required','error')
    ];
}

$settings = setting('currency_converter_api', [], true);

if( !is_array($settings) ){
    $settings = [];
}

switch ($type) {

    case 'free.currconv.com':

        try {
            $test = json_decode( file_get_contents_curl('https://free.currconv.com/api/v7/convert?q=USD_PHP&compact=ultra&apiKey='.$key),true );

            if( isset($test['error']) ){
                return [
                    'message'=>apiMessage( $test['error'],'error'),
                    'apiKeys'=>$settings
                ];
            }

            $settings['free.currconv.com'] = $key;

        } catch (\Throwable $th) {
            return [
                'message'=>apiMessage('Api key is not correct','error'),
                'apiKeys'=>$settings
            ];
        }

        break;

    case 'exchangerate-api.com':

        try {
            $test = json_decode( file_get_contents_curl('https://v6.exchangerate-api.com/v6/'.urlencode( $key ).'/latest/USD'),true );
            
            if( !isset($test['conversion_rates']) ){
                return [
                    'message'=>apiMessage('Api key is not correct','error'),
                    'apiKeys'=>$settings
                ];
            }

            $settings['exchangerate-api.com'] = $key;

        } catch (\Throwable $th) {

            return [
                'message'=>apiMessage('Api key is not correct','error'),
                'apiKeys'=>$settings
            ];
        }

        break;
}

setting_save('currency_converter_api', $settings );
   
return [
    'message'=>apiMessage('save change api key successfully'),
    'apiKeys'=>$settings
];
