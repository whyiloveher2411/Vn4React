<?php

if( ! Schema::hasTable('ace_custom_fields') ){
    unset($GLOBALS['function_helper_get_admin_object']);
    use_module('check_database_mysql');
}
