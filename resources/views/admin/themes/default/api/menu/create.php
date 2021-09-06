<?php
$r = request();

$input = json_decode( $r->getContent(), true);

dd($input);