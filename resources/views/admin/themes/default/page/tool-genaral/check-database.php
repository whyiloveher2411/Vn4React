<?php

if( env('DB_CONNECTION') === 'mysql' ){

	use_module('check_database_mysql');

	vn4_create_session_message( __('Ready'), __('The database is ready to be used.'), 'success', true );

}else{
	vn4_create_session_message( __('Failed'), __('Check Database valid only on mysql database management system'), 'error', true );
}

$is_acction = true;

