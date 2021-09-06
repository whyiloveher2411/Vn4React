<?php 

$admin_object = get_admin_object($field['object']);

$posts = get_posts($field['object'], ['callback'=>function($q) use ($post,$field) {
	return $q->where($field['field'],$post->id);
}]);

 ?>


<?php 
    foreach ($posts as $p) {
        echo '<a class="vn4-btn margin-2dot5" href="#" data-popup="1" data-title="Editing: '.($p['title']??'').'" data-iframe="'.route('admin.create_data',['type'=>$p['type'],'post'=> ($p[Vn4Model::$id]??'none') ,'action_post'=>'edit']).'">'.(isset($p['title']) ? $p['title'] : '').'</a>';
    }
 ?>

 <p style="margin: 5px;"><a href="#" data-popup="1" data-title="Create {!!$admin_object['title']!!}" data-iframe="{!!route('admin.create_data',['type'=>$field['object'],'relationship_field_'.$field['field']=>$post->id])!!}" class="vn4-btn vn4-btn-blue">Create {!!$admin_object['title']!!}</a></p>

