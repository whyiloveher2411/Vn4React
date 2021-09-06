<?php
$input = $r->all();

try{

    $dbh = new pdo( 'mysql:host='.$input['database_host'].':'.$input['database_port'].';dbname='.$input['database_name'],
                    $input['database_account'],$input['database_password'],
                    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));


    // setEnvironmentValue([
    //     'APP_URL'=>url('/').'/',
    //     'DB_HOST'=>$input['database_host'],
    //     'DB_PORT'=>$input['database_port'],
    //     'DB_DATABASE'=>$input['database_name'],
    //     'DB_USERNAME'=>$input['database_account'],
    //     'DB_PASSWORD'=>$input['database_password'],
    //     'TABLE_PREFIX'=>$input['table_prefix'],
    // ]);
    
    return [
        'message'=>[
            'content'=>'Valid database',
            'options'=>[
                    'variant'=>'success',
                    'anchorOrigin'=>[
                        'vertical'=>'bottom',
                        'horizontal'=>'right'
                    ]
                ]
            ],
        'success'=>true
    ];
}
catch(PDOException $ex){
    return [
        'message'=>[
            'content'=>'Unable to connect',
            'options'=>[
                    'variant'=>'error',
                    'anchorOrigin'=>[
                        'vertical'=>'bottom',
                        'horizontal'=>'right'
                    ]
                ]
            ],
        'success'=>false
    ];
}