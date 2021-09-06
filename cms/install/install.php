<?php

// header('Content-Type: application/json');

include __DIR__.'/_function.php';


if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}

header('Content-Type: application/json');

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