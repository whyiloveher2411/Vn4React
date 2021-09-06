<?php

if( !function_exists('ecommerce_price') ){
	function ecommerce_price($price, $arg = []){

		if( is_numeric($price) ){
			return number_format($price);
		}

		return $price;
	}
}

if( is_admin() ){

	include __DIR__.'/inc/backend.php';

}else{

	include __DIR__.'/inc/frontend.php';

}