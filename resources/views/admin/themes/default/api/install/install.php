<?php

// header('Content-Type: application/json');

include __DIR__.'/_function.php';

$r = request();

$urlPath = explode('/',url()->full());
$urlPath = end($urlPath);

switch ($urlPath) {
    case 'system-check':
        die( json_encode( require __DIR__.'/system.php' ) );
        break;
    case 'database-check':
        die( json_encode(  include __DIR__.'/database.php' ) );
        break;
    case 'theme-check':
        die( json_encode(  include __DIR__.'/theme-check.php' ) );
        break;
    case 'administrator-check':
        die( json_encode(  include __DIR__.'/administrator-check.php' ) );
        break;
}