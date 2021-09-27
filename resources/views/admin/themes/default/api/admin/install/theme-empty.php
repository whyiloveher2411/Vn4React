<?php

$GLOBALS['vn4_table_prefix'] = config('app.TABLE_PREFIX');

include cms_path('root','/cms/module/check_database_mysql.php');

return ['success'=>true];