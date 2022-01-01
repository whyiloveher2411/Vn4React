<?php

$key = $r->get('apiKey');

$type = $r->get('type');

if( !$key ){

    setting_save($type, '', 'e-commerce', false);

    return [
        'message'=>apiMessage('Remove api success'),
        'error'=>0,
    ];
    
}else{

    switch ($type) {

        case 'currency/currencyconverter/api_key':

            try {

                $test = json_decode( file_get_contents_curl('https://free.currconv.com/api/v7/convert?q=USD_PHP&compact=ultra&apiKey='.$key),true );

                if( isset($test['error']) ){
                    return [
                        'message'=>apiMessage( $test['error'],'error'),
                        'error'=>1,
                    ];
                }

            } catch (\Throwable $th) {
                return [
                    'message'=>apiMessage('Api key is not correct','error'),
                    'error'=>1,
                ];
            }

            break;

        case 'currency/exchangerate/api_key':

            try {
                $test = json_decode( file_get_contents_curl('https://v6.exchangerate-api.com/v6/'.urlencode( $key ).'/latest/USD'),true );

                if( !isset($test['conversion_rates']) ){
                    return [
                        'message'=>apiMessage('Api key is not correct','error'),
                        'error'=>1,
                    ];
                }

            } catch (\Throwable $th) {

                return [
                    'message'=>apiMessage('Api key is not correct','error'),
                    'error'=>1,
                ];
            }

            break;
    }

    setting_save($type, $key, 'e-commerce', false);
        
    return [
        'message'=>apiMessage('Save change api key successfully'),
        'error'=>0,
    ];

}

