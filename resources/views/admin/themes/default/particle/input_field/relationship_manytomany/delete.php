<?php

$table_relationships = vn4_tbpf().$type.'_'.$field['object'];

foreach ($ids as $id) {

	$list_tag_id =  DB::table($table_relationships)->where('post_id',$id)->pluck('tag_id')->toArray();

	DB::table($table_relationships)->where('post_id',$id)->where('type',$field['object'])->where('field',$key_field)->delete();

	foreach ($list_tag_id as $tagid) {
		DB::table($list_admin_object[$field['object']]['table'])->where(Vn4Model::$id,$tagid)->update(['count_'.$type.'_'.$key_field => DB::table($table_relationships)->where('tag_id',$tagid)->where('field',$key_field)->count()]);
	}
}