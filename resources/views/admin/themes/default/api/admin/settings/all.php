<?php

include __DIR__.'/_helper.php';

$result = getSettingAdmin();

$result['notification_count'] = get_posts('admin_notification',[ 'count'=>true,'paginate'=>'page','callback'=>function($q){
    $q->where('is_read',0);
}]);

return $result;