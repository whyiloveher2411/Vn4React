<?php

Route::any('plugin/vn4-ecommerce/{name}',function($name) use ($plugin) {

	$r = request();

	if( file_exists( $file = __DIR__.'/api/'.$name.'.php' ) ){
		return include $file;
	}

	return [
        'error_code'=>404,
        'message'=>apiMessage('Api Not Found', 'error')
    ];
});
