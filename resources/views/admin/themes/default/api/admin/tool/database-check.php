<?php

$result = [];

if( config('database.default') === 'mysql' ){

	use_module('check_database_mysql');

    $result['message'] = apiMessage( 'The database is ready to be used.' );

}else{

    $result['message'] = apiMessage( 'Check Database valid only on mysql database management system', 'error' );
}


return $result;
