<?php

$result['sidebar'] = \CMS\Admin\Sidebar::get();

$result['message'] = apiMessage('Refresh website success.');

// $result['settings'] = include __DIR__.'/../settings/all.php';
// dd($result);

return $result;