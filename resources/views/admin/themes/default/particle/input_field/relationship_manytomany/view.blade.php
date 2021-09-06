<?php 
	$relation_ship = $post->relationship($key);

    // $post_relationship = get_post($field['object'],$value);

    if( is_array($relation_ship) ){
        foreach ($relation_ship as $p) {
            echo '<a class="vn4-btn margin-2dot5" href="#" data-popup="1" data-title="Editing: '.(isset($p['title']) ? $p['title'] : '').'" data-iframe="'.route('admin.create_data',['type'=>$p['type'],'post'=> ($p[Vn4Model::$id]??'none') ,'action_post'=>'edit']).'">'.(isset($p['title']) ? $p['title'] : '').'</a>';
        }
    }else{
    	$relation_ship = $post->relationship($key);
	 	foreach ($relation_ship as $p) {
            echo '<a class="vn4-btn margin-2dot5" href="#" data-popup="1" data-title="Editing: '.(isset($p['title']) ? $p['title'] : '').'" data-iframe="'.route('admin.create_data',['type'=>$p['type'],'post'=> ($p[Vn4Model::$id]??'none') ,'action_post'=>'edit']).'">'.(isset($p['title']) ? $p['title'] : '').'</a>';
        }
    }
 ?>


