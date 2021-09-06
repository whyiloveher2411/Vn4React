<?php
function ecommerce_price($price, $arg = []){

	$decimal_separator = '.';
	$thousands_separator = ',';
	$number_of_decimal = 2;

	if( is_numeric($price) ){

		$naturalParts = floor($price);
		$decimalPart = $price - $naturalParts;

		if( $decimalPart > 0 ){
			$roundDecimal = intval( round($decimalPart, $number_of_decimal ) * str_pad('1', $number_of_decimal + 1, '0' ) ).'';
			return '$'.number_format( $price,0, $decimal_separator ,$thousands_separator ).$decimal_separator.$roundDecimal;
		}else{
			return '$'.number_format( $price,0, $decimal_separator , $thousands_separator );
		}

	}

	return '$'.$price;
}

function ecommerce_currencies( ){
	return setting( 'ecommerce_currencies', [
		'USD'=>[
            'currencie_code' => 'USD',
            'symbol' => '$',
            'number_of_decimals' => 2,
            'rate' => '1.0000',
        ]
	], true);
}


if( is_admin() ){

	include __DIR__.'/inc/backend.php';

}else{

	include __DIR__.'/inc/frontend.php';

}