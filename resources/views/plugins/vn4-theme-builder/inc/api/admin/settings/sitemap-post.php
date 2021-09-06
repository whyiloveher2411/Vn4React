<?php

$input = $r->all();

$metaUpdate = [
    'post-type-sitemap'=>$input['post-type-sitemap'],
    'active_sitemap'=>$input['active_sitemap'],
];

$plugin->updateMeta($metaUpdate);

return [
    'code'=>200,
    'success'=>true,
    'plugin'=>$plugin,
    'message'=> apiMessage('Update Sitemap Success.')
];
