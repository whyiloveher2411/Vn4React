<?php

include __DIR__.'/_function.php';

$r = request();

$input = json_decode( $r->getContent(), true );

try{

    if( !file_exists( $file =   cms_path('storage','logs')) ){
        mkdir($file, 0777, true);
    }

    if( !file_exists( $file =  cms_path('storage','framework/views')) ){
        mkdir( $file, 0777, true);
    }

    if( !file_exists( $file = cms_path('storage','framework/cache')) ){
        mkdir( $file , 0777, true);
    }
    if( !file_exists( $file = cms_path('storage','framework/sessions') ) ){
        mkdir( $file, 0777, true);
    }
    if( !file_exists( $file = cms_path('storage','cms/database') ) ){
        mkdir( $file, 0777, true);
    }

    $dbh = new pdo( 'mysql:host='.$input['database_host'].':'.$input['database_port'].';dbname='.$input['database_name'],
                    $input['database_account'],$input['database_password'],
                    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));


    setEnvironmentValue([
        'APP_URL'=>url('/').'/',
        'DB_HOST'=>$input['database_host'],
        'DB_PORT'=>$input['database_port'],
        'DB_DATABASE'=>$input['database_name'],
        'DB_USERNAME'=>$input['database_account'],
        'DB_PASSWORD'=>$input['database_password'],
        'TABLE_PREFIX'=>$input['table_prefix'],
    ]);
    
    return [
        'message'=> apiMessage('Valid database'),
        'success'=>true
    ];
}
catch(PDOException $ex){
    return [
        'message'=> apiMessage('Unable to connect', 'error'),
        'success'=>false
    ];
}