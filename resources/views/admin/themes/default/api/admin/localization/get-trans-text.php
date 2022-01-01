<?php

include __DIR__.'/../tool/_helper.php';

$data = getDataOld('src/utils/i18n/trans.xlsx');

$group = [];

return [
    'error'=>0,
    'trans'=>$data,
    'group'=>$group,
];
