<?php

$result['sidebar'] = include __DIR__.'/../adminSidebar/get.php';

$result['message'] = apiMessage('Refresh website success.');

$result['settings'] = include __DIR__.'/../settings/all.php';

return $result;