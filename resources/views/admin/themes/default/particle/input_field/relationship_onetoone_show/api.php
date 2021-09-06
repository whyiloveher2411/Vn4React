<?php

// dd($input);



$type = $param1;

$r = request();

dd(1);
dd($r->all());
$post = updateOrEdit($r, $type, $user);



dd($input);
unset( $input[$key] );