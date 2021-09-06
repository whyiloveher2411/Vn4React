<?php

$type = $param1;

$r = request();

$input = json_decode($r->getContent(),true);

use_module('post');

vn4_delete_post( $type , [$input[Vn4Model::$id]] );

return [
    'message'=>apiMessage('Delete Success')
];

