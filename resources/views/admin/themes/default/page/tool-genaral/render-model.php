<?php
App::setLocale('en');

$admin_object = get_admin_object();

$dataChange = [];

foreach ($admin_object as $key => $config) {

	if( !isset($dataChange[$key]['Relationship']) ) $dataChange[$key]['Relationship'] = [];
	if( !isset($dataChange[$key]['Use']) ) $dataChange[$key]['Use'] = [];

	$dataChange[$key]['ModelName'] = str_replace(' ', '',$config['title']);
	$dataChange[$key]['ModelName'] = preg_replace("/[^A-Za-z0-9]/", '',$dataChange[$key]['ModelName']);
	$dataChange[$key]['TableName'] = $config['table'];
	$dataChange[$key]['ObjectType'] = $key;

	foreach ($config['fields'] as $key2 => $field) {
		if( isset($field['view']) && $field['view'] === 'relationship_onetomany'){

			$dataChange[$key]['Relationship']['belongsto_'.$key.'_'.$key2] = "//One ".$config['title']." belongs to one ".$admin_object[$field['object']]['title']
			."\r\n\tpublic function ".strtolower(preg_replace("/[^A-Za-z0-9 ]/", '', str_replace(' ','',$field['title'])))."()" 
			."\r\n\t{"
				."\r\n\t\treturn \$this->$key2 ? get_post('$field[object]', \$this->$key2 ) : null ;"
			."\r\n\t}";
			// if( isset($dataChange[$field['object']]['Relationship']['hasmany_'.$key2]) ) dd($key2);
			$dataChange[$field['object']]['Relationship']['hasmany_'.$key.'_'.$key2] = "//One ".$admin_object[$field['object']]['title']." has many ".$config['title']
			."\r\n\tpublic function ".$dataChange[$key]['ModelName']."s(\$param = [])" 
			."\r\n\t{"
				."\r\n\t\t\$callback = function(\$q){"
				    ."\r\n\t\t\treturn \$q->where('$key2', \$this->id);"
				."\r\n\t\t};"
				."\r\n\t\tif( isset(\$param['callback']) ){"
				    ."\r\n\t\t\t\$param = array_merge(\$param, ['callback'=>[\$callback, \$param['callback']]]);"
				."\r\n\t\t}else{"
				    ."\r\n\t\t\t\$param = array_merge(\$param, ['callback'=>\$callback]);"
				."\r\n\t\t}"
				."\r\n\t\treturn get_posts('$key', \$param);"
			."\r\n\t}";
		}

		if( isset($field['view']) && $field['view'] === 'relationship_onetoone'){

			$dataChange[$key]['Relationship']['belongsto_'.$key.'_'.$key2] = "//One ".$config['title']." belongs to one ".$admin_object[$field['object']]['title']
			."\r\n\tpublic function ".strtolower(preg_replace("/[^A-Za-z0-9 ]/", '', str_replace(' ','',$field['title'])))."()" 
			."\r\n\t{"
				."\r\n\t\treturn \$this->$key2 ? get_post('$field[object]', \$this->$key2 ) : null ;"
			."\r\n\t}";
			// if( isset($dataChange[$field['object']]['Relationship']['hasmany_'.$key2]) ) dd($key2);
			$dataChange[$field['object']]['Relationship']['hasone_'.$key.'_'.$key2] = "//One ".$admin_object[$field['object']]['title']." has one ".$config['title']
			."\r\n\tpublic function ".$dataChange[$key]['ModelName']."(\$param = [])" 
			."\r\n\t{"
				."\r\n\t\t\$callback = function(\$q){"
				    ."\r\n\t\t\treturn \$q->where('$key2', \$this->id);"
				."\r\n\t\t};"
				."\r\n\t\tif( isset(\$param['callback']) ){"
				    ."\r\n\t\t\t\$param = array_merge(\$param, ['callback'=>[\$callback, \$param['callback']]]);"
				."\r\n\t\t}else{"
				    ."\r\n\t\t\t\$param = array_merge(\$param, ['callback'=>\$callback]);"
				."\r\n\t\t}"
				."\r\n\t\t\$param['count'] = 1;"
	            ."\r\n\t\t\$posts = get_posts('$key', \$param);"
	            ."\r\n\t\tif( isset(\$posts[0]) ) return \$posts[0];"
	            ."\r\n\t\treturn null; "
			."\r\n\t}";
		}

		if( isset($field['view']) && $field['view'] === 'relationship_manytomany'){

			$dataChange[$key]['Use']['DB'] = 'use DB;';

			$dataChange[$key]['Relationship']['belongsto_'.$key.'_'.$key2] = "//One ".$config['title']." belongs to many ".$admin_object[$field['object']]['title']
			."\r\n\tpublic function ".strtolower(preg_replace("/[^A-Za-z0-9 ]/", '', str_replace(' ','',$field['title'])))."s(\$param = [])" 
			."\r\n\t{"
				."\r\n\t\t\$callback = function(\$q){"
	                ."\r\n\t\t\treturn \$q->whereIn(Vn4Model::\$id,DB::table(vn4_tbpf().'".$key."_".$field['object']."')->where('post_id',\$this->id)->pluck('tag_id'));"
	            ."\r\n\t\t};"
	            ."\r\n\t\tif( isset(\$param['callback']) ){"
	                ."\r\n\t\t\t\$param = array_merge(\$param, ['callback'=>[\$callback, \$param['callback']]]);"
	            ."\r\n\t\t}else{"
	                ."\r\n\t\t\t\$param = array_merge(\$param, ['callback'=>\$callback]);"
	            ."\r\n\t\t}"
	            ."\r\n\t\treturn get_posts('$field[object]', \$param);"
			."\r\n\t}";

			$dataChange[$field['object']]['Use']['DB'] = 'use DB;';
			$dataChange[$field['object']]['Relationship']['hasmany_'.$key.'_'.$key2] = "//One ".$admin_object[$field['object']]['title']." has many ".$config['title']
			."\r\n\tpublic function ".$dataChange[$key]['ModelName']."s(\$param = [])" 
			."\r\n\t{"
				."\r\n\t\t\$callback = function(\$q){"
				    ."\r\n\t\t\treturn \$q->whereIn(Vn4Model::\$id,DB::table(vn4_tbpf().'".$key."_".$field['object']."')->where('tag_id',\$this->id)->pluck('post_id'));"
				."\r\n\t\t};"
				."\r\n\t\tif( isset(\$param['callback']) ){"
				    ."\r\n\t\t\t\$param = array_merge(\$param, ['callback'=>[\$callback, \$param['callback']]]);"
				."\r\n\t\t}else{"
				    ."\r\n\t\t\t\$param = array_merge(\$param, ['callback'=>\$callback]);"
				."\r\n\t\t}"
				."\r\n\t\treturn get_posts('$key', \$param);"
			."\r\n\t}";

		}


		

	}

}

foreach ($dataChange as $key => $value) {
	$content = file_get_contents(cms_path('resource','views/default/Model.template.php'));
	foreach ($value as $keyChange => $valueChange) {

		if( is_array($valueChange) ){
			$content = str_replace('['.$keyChange.']', implode("\r\n\r\n\t",$valueChange), $content);
		}else{
			$content = str_replace('['.$keyChange.']', $valueChange, $content);
		}
	}
	
	file_put_contents(cms_path('public','../app/Model/'.$value['ModelName'].'.php'), $content);

}

vn4_create_session_message( __('Success!'), __('Render Model Success!'), 'success', true );

return redirect()->back();