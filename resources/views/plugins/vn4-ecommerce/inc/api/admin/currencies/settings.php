<?php
// https://justforex.com/education/currencies
include __DIR__.'/__helper.php';

$currenciesJson = getCurrenciesList();

$action = $r->get('action');

$result = [];

// SETTING
if( $action === 'SettingCurrencies' ){

    $input = $r->get('currencies');

    $currencies = validateCurrenciesInput( $input );

    setting_save('ecommerce_currencies', $currencies, null, true);

    $result['message'] = apiMessage('Currencies configuration change successful');
    
    $result['currencies'] = $currencies;

}else{
    $result['currencies'] = ecommerce_currencies();
}

$result['apiKeys'] = setting('currency_converter_api',[], true);

if( $action === 'LoadingCurrencies' ){
    $result['currenciesList'] = $currenciesJson;
}


return $result;


