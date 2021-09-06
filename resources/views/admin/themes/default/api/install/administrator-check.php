<?php
$input = json_decode( $r->getContent(), true );

$GLOBALS['vn4_table_prefix'] = config('app.TABLE_PREFIX');

$table_user = vn4_tbpf().'user';

Schema::table($table_user, function($table) use ($table_user) {
    if( !Schema::hasColumn( $table_user, 'permission' ) ){
        $table->text('permission')->after('customize_time')->nullable();
        $table->string('remember_token',255)->after('permission')->nullable();
    }
});

DB::table($table_user)->delete();

DB::table(vn4_tbpf().'user')->insert([
    'email'=>$input['email_address'],
    'slug'=>str_slug($input['email_address']),
    'first_name'=>$input['first_name'],
    'last_name'=>$input['last_name'],
    'password'=>Hash::make($input['admin_password']),
    'type'=>'user',
    'status'=>'publish',
    'role'=>'Super Admin',
    'permission'=>'',
]);

DB::table(vn4_tbpf().'setting')->whereIn('key_word',['security_prefix_link_admin','security_link_login'])->delete();

$data = [
    [
        'key_word'=>'security_prefix_link_admin',
        'type'=>'setting',
        'content'=>$input['backend_url'],
    ],
    [
        'key_word'=>'security_link_login',
        'type'=>'setting',
        'content'=>$input['login_url'],
    ],
];

DB::table(vn4_tbpf().'setting')->insert($data);

cache()->flush();


// file_put_contents( __DIR__.'/../../site/'.$_SERVER['SERVER_NAME'].'/' .'/info.json', json_encode([
//     'delete'=>0,
//     'name'=>$_SERVER['SERVER_NAME'],
//     'domain'=>$_SERVER['SERVER_NAME'],
//     'admin'=>url('/'.$input['backend_url']),
//     'https'=>1
// ]));

// file_put_contents( __DIR__.'/../core.php', file_get_contents(__DIR__.'/../core_temp.txt'));

return ['success'=>true,'backend_url'=>url('/'.$input['backend_url'])];



