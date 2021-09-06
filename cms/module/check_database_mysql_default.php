<?php


//Post Type
if( function_exists('get_admin_object') ){
	$admin_object = get_admin_object();
}else{
	$admin_object = include __DIR__.'/../core/data-object-default.php';
}

$listColumnDefault = [
'type'=>function($table){
	return $table->string('type',60)->default('');
},
'meta'=>function($table){
	return $table->mediumText('meta')->after('type')->nullable();
},
'author'=>function($table){
	return $table->integer('author')->unsigned()->nullable()->after('meta');
},
'template'=>function($table){
	return $table->string('template',100)->default('')->after('author');;
},
'order'=>function($table){
	return $table->integer('order')->unsigned()->after('template')->nullable();
},
'status'=>function($table){
	return $table->string('status',20)->after('order')->default('publish');
},
'status_old'=>function($table){
	return $table->string('status_old',20)->default('publish')->after('status');
},
'password'=>function($table){
	return $table->string('password', 60)->after('status_old')->default('');
},
'post_date_gmt'=>function($table){
	return $table->integer('post_date_gmt')->unsigned()->nullable()->after('password')->nullable();
},
'visibility'=>function($table){
	return $table->string('visibility', 50)->default('publish')->after('post_date_gmt');
},
'is_homepage'=>function($table){
	return $table->string('is_homepage', 100)->default(0)->after('visibility');
},
'ip'=>function($table){
	return $table->string('ip',20)->default('')->after('is_homepage');
},

];

$arg_type_mysql_input = [
	'custom'=>function(&$table, $name, $after,$data){
		if( $data['type'] === 'text' ){
			return $table->string($name,$data['length'])->after($after)->nullable()->default(false)->comment('property: '.$data['title']);
		}
	},
	'asset-file'=>function(&$table, $name, $after,$data){
		return  $table->string($name,255)->after($after)->nullable()->default(false)->comment('property: '.$data['title']);
	},
	'checkbox'=>function(&$table, $name, $after,$data){
		return $table->string($name,255)->after($after)->nullable()->default(false)->comment('property: '.$data['title']);
	},
	'color'=>function(&$table, $name, $after,$data){
		return	$table->string($name,20)->after($after)->nullable()->default(false)->comment('property: '.$data['title']);
	},
	'editor'=>function(&$table, $name, $after, $data){

		if( isset($data['simple']) &&  $data['simple']){
			return $table->string($name,500)->after($after)->nullable()->default(false)->comment('property: '.$data['title']);
		}else{
			return $table->text($name)->after($after)->nullable()->default(false)->comment('property: '.$data['title']);
		}

	},
	'json'=>function(&$table, $name, $after, $data){

		if( isset($data['simple']) &&  $data['simple']){
			return $table->string($name,500)->after($after)->nullable()->default(false)->comment('property: '.$data['title']);
		}else{
			return $table->text($name)->after($after)->nullable()->default(false)->comment('property: '.$data['title']);
		}

	},
	'email'=>function(&$table, $name, $after, $data){
		return $table->string($name,60)->after($after)->nullable()->default(false)->comment('property: '.$data['title']);
	},
	'flexible'=>function(&$table, $name, $after, $data){
		return $table->mediumText($name)->after($after)->nullable()->default(false)->comment('property: '.$data['title']);
	},
	'group'=>function(&$table, $name, $after, $data){
		return $table->text($name)->after($after)->nullable()->default(false)->comment('property: '.$data['title']);
	},
	'group-type'=>function(&$table, $name, $after, $data){
		return $table->string($name,60)->after($after)->nullable()->default(false)->comment('property: '.$data['title']);
	},
	'image'=>function(&$table, $name, $after, $data){
		return $table->text($name)->after($after)->nullable()->default(false)->comment('property: '.$data['title']);
	},
	'input'=>function(&$table, $name, $after, $data){
		return $table->string($name,255)->after($after)->nullable()->default(false)->comment('property: '.$data['title']);
	},
	'link'=>function(&$table, $name, $after, $data){
		return $table->string($name,255)->after($after)->nullable()->default(false)->comment('property: '.$data['title']);
	},
	'menu'=>function(&$table, $name, $after, $data){
		return $table->integer($name)->after($after)->nullable()->comment('property: '.$data['title']);
	},
	'number'=>function(&$table, $name, $after, $data){
		return $table->integer($name)->after($after)->nullable()->comment('property: '.$data['title']);
	},
	'password'=>function(&$table, $name, $after, $data){
		return $table->string($name,60)->after($after)->nullable()->default(false)->comment('property: '.$data['title']);
	},
	'radio'=>function(&$table, $name, $after, $data){
		return $table->string($name,60)->after($after)->nullable()->default(false)->comment('property: '.$data['title']);
	},
	'relationship_onetomany'=>function(&$table, $name, $after, $data){
		return $table->string($name,60)->after($after)->nullable()->default(false)->comment('property: '.$data['title']);
	},
	'relationship_onetoone'=>function(&$table, $name, $after, $data){
		return $table->string($name,60)->after($after)->nullable()->default(false)->comment('property: '.$data['title']);
	},
	'relationship_manytomany'=>function(&$table, $name, $after, $data){
		return $table->text($name)->after($after)->nullable()->default(false)->comment('property: '.$data['title']);
	},
	'repeater'=>function(&$table, $name, $after,$data){
		return $table->mediumText($name)->after($after)->nullable()->default(false)->comment('property: '.$data['title']);
	},
	'select'=>function(&$table, $name, $after,$data){
		return $table->string($name,60)->after($after)->nullable()->default(false)->comment('property: '.$data['title']);
	},
	'slug'=>function(&$table, $name, $after, $data,$arg_type_mysql_input = [], $change = false ){
		if( $change ){

			if( !empty($keyExists = DB::select(
			    DB::raw(
			        'SHOW KEYS
			        FROM '.$table->getTable().'
			        WHERE Key_name=\''.$table->getTable().'_slug_unique'.'\''
			    )
			))){
				$table->dropUnique($table->getTable().'_slug_unique');
			}

		}

	 	return $table->string($name,191)->unique()->after($after)->nullable()->default(false)->comment('property: '.$data['title']);
	},
	'text'=>function(&$table, $name, $after,$data,$arg_type_mysql_input = [], $change = false){

		$length = $data['length']??255;


		if( $change && isset($data['unique']) ){

			if( !empty($keyExists = DB::select(
			    DB::raw(
			        'SHOW KEYS
			        FROM '.$table->getTable().'
			        WHERE Key_name=\''.$data['unique'].'\''
			    )
			))){
				$table->dropUnique($data['unique']);
			}

		}

		if( isset($data['unique']) && $data['unique'] ){
			return $table->string($name,$length)->unique($data['unique'])->after($after)->nullable()->comment('property: '.$data['title']);
		}else{
			return $table->string($name,$length)->after($after)->nullable()->comment('property: '.$data['title']);
		}


	},
	'hidden'=>function( $table, $name, $after, $data, $arg_type_mysql_input ) {
		return $arg_type_mysql_input[$data['data_type']]($table,$name,$after,$data);
	},
	'textarea'=>function(&$table, $name, $after, $data){
		return $table->string($name,500)->after($after)->nullable()->default(false)->comment('property: '.$data['title']);
	},
	'true_false'=>function(&$table, $name, $after,$data){
		return $table->string($name,50)->after($after)->nullable()->default(false)->comment('property: '.$data['title']);
	},
	'unique'=>function(&$table, $name, $after, $data){
		return $table->string($name,$data['length'])->after($after)->nullable()->default(false)->comment('property: '.$data['title']);
	}
];

$list_table_relationships_nn = [];


$list_db_success = [];
$list_db_comment = [];

foreach ($admin_object as $object_key => $object) {

	if( ! Schema::hasTable($object['table']) ){
		
		Schema::create($object['table'], function($table)
		{
			$table->increments('id')->unsignedInteger();
		});

	}

	$after = 'id';

	$list_db_success[$object['table']]['id'] = 1;

	foreach ($object['fields'] as $column_name => $column_value) {

		$list_db_success[$object['table']][$column_name] = 1;

		if( !isset($column_value['view']) ) $column_value['view'] = 'text';

		if( $column_name != 'template' ) {

			// try {
				Schema::table($object['table'], function($table) use ($column_name, $after,$column_value,$arg_type_mysql_input,$object)
				{
					if( !isset($column_value['view']) ) $column_value['view'] = 'text';

					if( isset($column_value['database']) ){
						
						if( Schema::hasColumn( $object['table'], $column_name ) ){
							$table = $column_value['database']($table,$column_name,$after,$column_value, $arg_type_mysql_input,true)->change();
						}else{
							$table = $column_value['database']($table,$column_name,$after,$column_value, $arg_type_mysql_input,false);
						}

					}else{

						if( !is_string($column_value['view'])) $column_value['view'] = 'editor';

						if( isset($arg_type_mysql_input[$column_value['view']]) ){
							if( Schema::hasColumn( $object['table'], $column_name ) ){
								$table = $arg_type_mysql_input[$column_value['view']]($table,$column_name,$after,$column_value, $arg_type_mysql_input,true)->change();
							}else{
								$table = $arg_type_mysql_input[$column_value['view']]($table,$column_name,$after,$column_value, $arg_type_mysql_input,false);
							}
						}

					}


				});
			// } catch (Exception $e) {
			// 	dd($column_value);
			// }
			
			
			$after = $column_name;
			// DB::raw('ALTER TABLE '.$object['table'].' ADD FULLTEXT INDEX full_text_'.$column_name.' ('.$column_name.')');
			// EXPLAIN SELECT * FROM vn4_post2 WHERE MATCH (description) AGAINST ('vuong' IN BOOLEAN MODE)
		}

		
		
	}

	foreach ($listColumnDefault as $keyColumnDefault => $valueColumnDefault) {

		$list_db_success[$object['table']][$keyColumnDefault] = 1;

		Schema::table($object['table'], function($table) use ($object, $valueColumnDefault,$keyColumnDefault)
		{

			if(  Schema::hasColumn( $object['table'], $keyColumnDefault ) ){
				$table = $valueColumnDefault($table)->change();
			}else{
				$table = $valueColumnDefault($table);
			}
		});

	}

	$list_db_success[$object['table']]['created_at'] = 1;
	$list_db_success[$object['table']]['updated_at'] = 1;

	if( !Schema::hasColumn( $object['table'], 'created_at' ) && !Schema::hasColumn( $object['table'], 'updated_at' ) ) {

			Schema::table($object['table'], function($table)
			{
				$table->timestamps();
			});
	}

	$array = DB::select('SHOW FULL COLUMNS FROM '.$object['table']);

	$list_db_comment[$object['table']] = array_column($array, 'Comment', 'Field');

	if( isset($object['engine']) ){
		DB::statement('ALTER TABLE ' . $object['table'] . ' ENGINE = '.$object['engine']);
	}else{
		DB::statement('ALTER TABLE ' . $object['table'] . ' ENGINE = MyISAM');
	}

}



foreach ($admin_object as $object_key => $object) {

	Schema::table($object['table'], function($table) use ($object){

		if( Schema::hasColumn( $object['table'], 'created_time' ) ){
			$table->float('created_time',15,4)->before('created_at')->nullable()->change();
		}else{
			$table->float('created_time',15,4)->before('created_at')->nullable();
		}

		if( Schema::hasColumn(  $object['table'], 'updated_time' ) ){
			$table->float('updated_time',15,4)->before('created_at')->nullable()->change();
		}else{
			$table->float('updated_time',15,4)->before('created_at')->nullable();
		}

	});


	foreach ($object['fields'] as $column_name => $column_value) {
		
		$list_db_success[$object['table']][$column_name] = 1;

		if( isset($column_value['view']) && $column_value['view'] === 'relationship_manytomany'){

			Schema::table($admin_object[$column_value['object']]['table'], function($table) use ($object, $object_key, $admin_object,$column_name, $column_value)
			{

				if( Schema::hasColumn( $admin_object[$column_value['object']]['table'], 'count_'.$object_key.'_'.$column_name ) ){
					$table->integer('count_'.$object_key.'_'.$column_name)->after('type')->nullable()->comment('property: Count '.$object['title'])->change();
				}else{
					$table->integer('count_'.$object_key.'_'.$column_name)->after('type')->nullable()->comment('property: Count '.$object['title']);
				}

			});

			$list_db_success[$admin_object[$column_value['object']]['table']]['count_'.$object_key.'_'.$column_name] = 1;

			$list_table_relationships_nn[] = vn4_tbpf().$object_key.'_'.$column_value['object'];

		}elseif( isset($column_value['view']) && $column_value['view'] === 'relationship_onetomany' ) {

			Schema::table($object['table'], function($table) use ($object, $object_key, $admin_object,$column_name, $column_value)
			{

				if( Schema::hasColumn( $object['table'] , $column_name.'_detail' ) ){
					$table->text($column_name.'_detail')->after($column_name)->nullable()->default(false)->comment('property: '.$column_value['title'].' Detail')->change();
				}else{
					$table->text($column_name.'_detail')->after($column_name)->nullable()->default(false)->comment('property: '.$column_value['title'].' Detail');
				}

			});

			$list_db_success[$object['table']][$column_name.'_detail'] = 1;
		}

	}


}
//xóa những cột không cần thiết
foreach ($list_db_comment as $table_name => $columns) {
	foreach ($columns as $name => $comment) {
		if( strpos($comment,  'property') !== false && !isset($list_db_success[$table_name][$name]) ){

			Schema::table($table_name, function ($table) use ($name) {
			    $table->dropColumn($name);
			});
		}
	}
}


//tạo các bảng quan hệ nhiều nhiều
foreach ($list_table_relationships_nn as $tbname) {
	$key = str_replace('_', '', $tbname).'_unique';

	if( ! Schema::hasTable($tbname) ){
		
		Schema::create($tbname, function($table)
		{
			$table->increments('id')->unsignedInteger();
			$table->integer('post_id')->unsigned();
			$table->integer('tag_id')->unsigned();
			$table->string('field',60)->nullable();
			$table->string('type',100)->nullable();
			$table->timestamps();
		});
	}

	$keyExists = DB::select(DB::raw('SHOW KEYS FROM '.$tbname.' WHERE Key_name=\''.$tbname.'_unique'.'\''));

	if( $keyExists ){
		Schema::table($tbname, function ($table) use ($tbname) {
			$table->dropUnique($tbname.'_unique');
		});
	}

	$keyExists = DB::select(DB::raw('SHOW KEYS FROM '.$tbname.' WHERE Key_name=\''.$key.'\''));
	
	if( !$keyExists ){
		Schema::table($tbname,  function($table) use ($tbname, $key) {
			$table->unique(['post_id', 'tag_id'],$key);
		});
	}


	DB::statement('ALTER TABLE ' . $tbname . ' ENGINE = MyISAM');
}

$argTableDefault = [
	vn4_tbpf().'widget'=>[
		'sidebar_id'=>'text',
		'theme'=>'text',
		'content'=>'editor',
		'html'=>'editor',
	],
	
	vn4_tbpf().'theme_option'=>[
		'key'=>[
			'view'=>'text',
			'length'=>60,
		],
		'content'=>'editor',
	],
	vn4_tbpf().'slug'=>[
		'type'=>'text',
		'post_id'=>'number',
		'slug'=>'text',
		'number_update'=>'number',
	],
	vn4_tbpf().'setting'=>[
		'title'=>'text',
		'type'=>'text',
		'key_word'=>'text',
		'author'=>'number',
		'status'=>'text',
		'meta'=>'editor',
		'content'=>'editor',
		'group'=>'text'
	],
	vn4_tbpf().'menu'=>[
		'title'=>'text',
		'type'=>'text',
		'status'=>'text',
		'theme'=>'text',
		'content'=>'editor',
		'key_word'=>'text',
		'json'=>'editor',
	],
	vn4_tbpf().'login_time'=>[
		'ip'=>'text',
		'count'=>'number',
		'time'=>'number',
	],
	vn4_tbpf().'jobs'=>[
		'queue'=>'text',
		'payload'=>'editor',
		'attempts'=>'number',
		'reserved_at'=>'text',
	],

];

foreach ($argTableDefault as $table_name => $columns) {

	if( ! Schema::hasTable($table_name) ){
		
		Schema::create($table_name, function($table)
		{
			$table->increments('id')->unsignedInteger();
		});

	}

	$after = 'id';

	foreach ($columns as $key => $column) {

		Schema::table($table_name, function($table) use ($arg_type_mysql_input, $key, $column, $after, $table_name){

			$change = Schema::hasColumn( $table_name, $key )?true:false;

			if( is_string($column) ){

				if( $change ){
					$table = $arg_type_mysql_input[$column]($table,$key,$after,['title'=>$key])->change();
				}else{
					$table = $arg_type_mysql_input[$column]($table,$key,$after,['title'=>$key]);
				}

			}else{

				$column['title'] = $key;

				if( $change ){
					$table = $arg_type_mysql_input[$column['view']]($table,$key,$after,$column)->change();
				}else{
					$table = $arg_type_mysql_input[$column['view']]($table,$key,$after,$column);
				}
			}

		});

		$after = $key;

	}

	Schema::table($table_name, function($table) use ($table_name, $key, $column, $after){

		if( Schema::hasColumn( $table_name, 'created_time' ) ){
			$table->float('created_time',15,4)->before('created_at')->nullable()->change();
		}else{
			$table->float('created_time',15,4)->before('created_at')->nullable();
		}

		if( Schema::hasColumn( $table_name, 'updated_time' ) ){
			$table->float('updated_time',15,4)->before('created_at')->nullable()->change();
		}else{
			$table->float('updated_time',15,4)->before('created_at')->nullable();
		}

		if( !Schema::hasColumn( $table_name, 'created_at' ) ){
			$table->timestamps();
		}

	});

	DB::statement('ALTER TABLE ' . $table_name . ' ENGINE = MyISAM');
	
}
