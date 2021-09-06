<?php

Route::any('plugin/vn4-google-analytics/{name}',function($name) use ($plugin) {

	$r = request();

	return include __DIR__.'/api/'.$name.'.php';
});
