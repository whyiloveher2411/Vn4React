<?php

if( env('EXPERIENCE_MODE') ){
    return experience_mode();
}

$obj = Vn4Model::firstOrAddnew(vn4_tbpf().'setting',['key_word'=>'list_role','type'=>'option_permission']);

if( $r->has('delete-role-submit') ){
  $obj->delete();
  return redirect()->back();
}

$list_role = $obj->meta;

if( !$list_role ){
  $list_role = '';
}else{

  $list_role = json_decode($list_role, true );

}

if( !$list_role ){
  $list_role = [];
}

if( $r->has('create_role') ){

  $title = $r->get('create_role_name','none_name');

  $list_role[str_slug($title)] = ['title'=>$title,'list_permission'=>''];

  $obj->meta = json_encode($list_role);

  $obj->save();

  return redirect()->route('admin.page',['page'=>'user-role-editor','post_role'=>str_slug($title)]);

}
if( isset($list_role[$r->get('role_name')]) ){

  if($r->has('permission')){
    $list_role[$r->get('role_name')]['list_permission'] = json_encode($r->get('permission'));
  }else{
    $list_role[$r->get('role_name')]['list_permission'] = '';
  }

  $obj->meta = json_encode($list_role);

  $obj->save();

  return redirect()->route('admin.page',['page'=>'user-role-editor','post_role'=>$r->get('role_name')]);
}

return redirect()->back();

      
