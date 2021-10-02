<?php

$theme = $input['name'];

if( file_exists( $folder_upload_sample = app()->resourcePath('views/themes/'.$theme.'/data-sample/uploads') ) ){

    if (!file_exists( public_path('uploads') )) {
        mkdir( public_path('uploads') , 0777, true);
    }
    
    recurse_copy( $folder_upload_sample , public_path('uploads/') );
}

include __DIR__.'/../module/import_data_sample.php';

$import = importSqlFile( app()->resourcePath('views/themes/'.$theme.'/data-sample/database.sql') );

if( $import !== true ){
    die(json_encode(['success'=>false,'message'=> $import === false ? 'Import Data Error.' : $import]));
}

include __DIR__.'/../module/check_database_mysql.php';

$table_user = get_admin_object('user')['table'];

Schema::table($table_user, function($table) use ($table_user) {
    if( !Schema::hasColumn( $table_user, 'permission' ) ){
        $table->text('permission')->after('customize_time')->nullable();
        $table->string('remember_token',255)->after('permission')->nullable();
    }
});

DB::table($table_user)->delete();

DB::table(vn4_tbpf().'user')->insert([
    'email'=>$r->get('email'),
    'slug'=>str_slug($r->get('email')),
    'first_name'=>$r->get('first_name'),
    'last_name'=>$r->get('last_name'),
    'password'=>Hash::make($r->get('admin_password')),
    'type'=>'user',
    'status'=>'publish',
    'role'=>'Super Admin',
    'permission'=>'',
    'created_at'=>date('Y-m-d H:i:s')
]);

DB::table(vn4_tbpf().'setting')->whereIn('key_word',['security_prefix_link_admin','security_link_login'])->delete();

DB::table(vn4_tbpf().'setting')->insert([
    [
        'key_word'=>'security_prefix_link_admin',
        'type'=>'setting',
        'content'=>$r->get('backend_url'),
    ],
    [
        'key_word'=>'security_link_login',
        'type'=>'setting',
        'content'=>$r->get('login_url'),
    ],
    [
        'key_word'=>'general_client_theme',
        'type'=>'setting',
        'content'=>$theme
    ]
]);

cache()->flush();

// file_put_contents( __DIR__.'/../../site/'.$_SERVER['SERVER_NAME'].'/' .'/info.json', json_encode([
//     'delete'=>0,
//     'name'=>$_SERVER['SERVER_NAME'],
//     'domain'=>$_SERVER['SERVER_NAME'],
//     'admin'=>url('/'.$r->get('backend_url')),
//     'https'=>1
// ]));

return ['success'=>true];

// file_put_contents(__DIR__.'/../core.php', file_get_contents(__DIR__.'/../core_temp.txt'));

// die(json_encode(['success'=>true,'loginpage'=>url('/'.$r->get('backend_url'))]));