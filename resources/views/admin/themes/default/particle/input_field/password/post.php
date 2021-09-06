<?php

if( isset($input[$key]) ){
	if( $input[$key] ){
		$input[$key] = Hash::make(trim($input[$key]));
	}
}


if( !isset($input[$key]) ){
	unset($input[$key]);
}
