<?php
include __DIR__.'/__helper.php';

$input = $r->all();

$currencies = validateCurrenciesInput( $r->get('currencies') );

$currenciesKeys = array_keys($currencies);

$type = $r->get('type', false );

if( !$type ){
    return [
        'message'=>apiMessage('Please update api key before import')
    ];
}

/*
* Check api key updated
*/
$apiKeys = setting('currency_converter_api',false);

if( !$apiKeys ){
    return [
        'message'=>apiMessage('Please update api key before import')
    ];
}

if( !isset($apiKeys[ $type ]) || !$apiKeys[ $type ] ){
    return [
        'message'=>apiMessage('Please update api key before import')
    ];
}

$apiKey = $apiKeys[ $type ];


if( isset($currenciesKeys[0]) ){

    $currencies[ $currenciesKeys[0] ]['rate'] = 1;

    $countCurrenciesKeys = count($currenciesKeys);

    if( $countCurrenciesKeys > 1 ){

        $qKeyCurrencies = [];

        for ($i=1; $i < $countCurrenciesKeys; $i++) { 
            $qKeyCurrencies[] = $currenciesKeys[0].'_'.$currenciesKeys[$i];
        }

        
        switch ($type) {
            case 'free.currconv.com':
                
                try {
                        //code...
                
                    $rates = json_decode( file_get_contents_curl('https://free.currconv.com/api/v7/convert?q='.join(',',$qKeyCurrencies).'&compact=ultra&apiKey='.$apiKey),true );
                    
                    if( isset($rates['error']) ){
                        return [
                            'message'=>apiMessage($rates['error'], 'error')
                        ];
                    }

                    for ($i=1; $i < $countCurrenciesKeys; $i++) { 
                        if( isset( $rates[$currenciesKeys[0].'_'.$currenciesKeys[$i]] ) ){
                            $currencies[ $currenciesKeys[$i] ]['rate'] = $rates[$currenciesKeys[0].'_'.$currenciesKeys[$i]];
                        }
                    }

                } catch (\Throwable $th) {
                    return [
                        'currencies'=>$currencies,
                        'message'=>apiMessage('Currency rate update error', 'error')
                    ];
                }
                
                break;

            case 'exchangerate-api.com':

                try {
                    //code...
                
                    $rates = json_decode( file_get_contents_curl('https://v6.exchangerate-api.com/v6/'.$apiKey.'/latest/'.$currenciesKeys[0] ),true );

                    if( !isset($rates['conversion_rates']) ){
                        if( isset($rates['extra-info']) ){
                            return [
                                'currencies'=>$currencies,
                                'message'=>apiMessage('Api Service Error: '.$rates['extra-info'], 'error')
                            ];
                        }
                        return [
                            'currencies'=>$currencies,
                            'message'=>apiMessage('Currency rate update error', 'error')
                        ];
                    }

                    for ($i=1; $i < $countCurrenciesKeys; $i++) { 
                        
                        if( isset( $rates['conversion_rates'][ $currenciesKeys[$i]]  ) ){
                            $currencies[ $currenciesKeys[$i] ]['rate'] = $rates['conversion_rates'][$currenciesKeys[$i]];
                        }
                    }

                } catch (\Throwable $th) {
                    return [
                        'currencies'=>$currencies,
                        'message'=>apiMessage('Currency rate update error', 'error')
                    ];
                }
                break;
        }

        
    }

    setting_save('ecommerce_currencies', $currencies);

    return [
        'currencies'=>$currencies,
        'message'=>apiMessage('Currency rate update successfully')
    ];
}
/*
* Not Setting currencies
*/
return [
    'message'=>apiMessage('Please set currencies before updating the rate','error')
];

