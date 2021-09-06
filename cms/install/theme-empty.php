<?php

$GLOBALS['vn4_table_prefix'] = config('app.TABLE_PREFIX');

function vn4_tbpf(){
    return $GLOBALS['vn4_table_prefix'] ;
}

include __DIR__.'/../module/check_database_mysql.php';

return ['success'=>true];