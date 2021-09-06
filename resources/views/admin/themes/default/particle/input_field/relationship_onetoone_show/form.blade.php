<?php 
	
	if($post){

		$value = get_posts($object, ['count'=>1,'callback'=>function($q) use ($post,$field) {
			return $q->where($field,$post->id);
		}]);

		$admin_object = get_admin_object();

		if( isset($value[0]) ){

			if( isset($express) ){

				if( is_array($express) ){
					$shows = [];
					foreach($express as $v){
						$shows[] = $value[0]->{$v};
					}
				 	?>
					<a class="vn4-btn" target="_blank"  href="{!!route('admin.create_data',['type'=>$object,'post'=>$value[0]->id,'action_post'=>'edit'])!!}">{!!implode(' - ',$shows)!!}</a>
					<?php
				}elseif( is_callable($express) ){
					?>
					<a class="vn4-btn" target="_blank"  href="{!!route('admin.create_data',['type'=>$object,'post'=>$value[0]->id,'action_post'=>'edit'])!!}">{!!$express($value[0])!!}</a>
					<?php
				}
			}else{
				?>
				<a class="vn4-btn" target="_blank"  href="{!!route('admin.create_data',['type'=>$object,'post'=>$value[0]->id,'action_post'=>'edit'])!!}">{!!$value[0]->title!!}</a>
				<?php 
			}
		}else{ ?>
			<a href="{!!route('admin.create_data',['type'=>$object,'relationship_field_'.$field=>$post->id])!!}" class="vn4-btn vn4-btn-blue">Add New {!!$admin_object[$object]['title']!!}</a>
			<?php
		}
	}else{
		echo '(Create Post Before Add Data)';
	}

 ?>