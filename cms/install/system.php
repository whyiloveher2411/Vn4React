<?php

makesFolderPath();

define('VN4_MINIMUM_PHP_VERSION_ID', 70200);

$required = [
    'phpversion'=>[
        'title'=>'PHP version 7.2 or greater required',
        'result'=>PHP_VERSION_ID >= VN4_MINIMUM_PHP_VERSION_ID
    ],
    'sslLibrary'=>[
        'title'=>'OpenSSL PHP Extension is required',
        'result'=>extension_loaded('openssl')
    ],
    'pdoLibrary'=>[
        'title'=>'PDO PHP Extension is required',
        'result'=>defined('PDO::ATTR_DRIVER_NAME')
    ],
    'mbstringLibrary'=>[
        'title'=>'Mbstring PHP Extension is required',
        'result'=>extension_loaded('mbstring')
    ],
    'curlLibrary'=>[
        'title'=>'cURL PHP Extension is required',
        'result'=>function_exists('curl_init') && defined('CURLOPT_FOLLOWLOCATION')
    ]
];

return ['rows'=>$required];