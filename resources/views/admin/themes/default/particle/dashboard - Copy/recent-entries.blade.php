<?php 
// Template Name: Recent Entries
// Icon: fa-clock-o
 ?>

@if( isset($setting) && $setting )



<?php 



	$post_type = isset($widget['data']['post_type']) && $widget['data']['post_type']? $widget['data']['post_type'] :false;

	$limit = isset($widget['data']['limit']) && $widget['data']['limit']? $widget['data']['limit'] :10;



	$post_types = get_admin_object();

	$options = '';

	foreach ($post_types as $key => $value) {

		$options .= '<option '.($post_type === $key ? 'selected="selected"':'').' value="'.$key.'">'.$value['title'].'</option>';

	}

 ?>



	<div class="form-group">

		<label>Section</label>

		<p>Which section do you want to pull recent entries from?</p>

		<select name="data[post_type]" class="form-control" style="width:auto;max-width: 100%;">

			{!!$options!!}			

		</select>

	</div>

	<div class="form-group">

		<label>Limit <input class="form-control" value="{!!$limit!!}" name="data[limit]" style="width:70px;"> </label>

	</div>



@else

<?php 

	$post_type = isset($widget['data']['post_type']) && $widget['data']['post_type']? $widget['data']['post_type'] :false;

	$limit = isset($widget['data']['limit']) && $widget['data']['limit']? $widget['data']['limit'] :10;



	if( !$post_type || !($admin_object = get_admin_object($post_type)) ){

		echo 'Please install to use the widget';

		return;

	}

	$key = array_key_first($admin_object['fields']);

	$posts = DB::table($admin_object['table'])->where('type',$post_type)->take($limit)->get([$key,Vn4Model::$id,'created_at','author']);

?>



<div class="content-warper">



	<div class="widget-heading">
  		<h2 style="z-index: 1;position: relative;"><a style="z-index: 1;" href="#" onclick="window.parent.location = '{!!route('admin.show_data',['post_type'=>$post_type])!!}';return false;">Recent {!!$admin_object['title']!!} Entries</a></h2>
	</div>

	<div class="body">

	 @forelse($posts as $p)

	 <?php 

	 	$user = get_post('user',$p->author);

	  ?>

	 <p class="light"><a href="#" onclick="window.parent.show_popup($(this));" data-title="Edit &quot;{!!$p->{$key}!!}&quot;" data-iframe="{!!route('admin.create_data',['post_type'=>$post_type,'post'=>$p->id, 'action_post'=>'edit'])!!}">{!!$p->{$key}!!}</a> {!!get_date_time($p->created_at)!!}@if($user), {!!$user->last_name!!} @endif </p>

	 @empty

	 <h4 style="font-size:16px;text-align: center;">

	 	<img style="box-shadow: none;width: 200px;max-width: 100%;height: auto;max-height: 200px;display: block;margin: 0 auto;" src="{!!asset('admin/images/data-not-found.png')!!}"><strong>@__('Nothing To Display.') <br> <span style="color:#ababab;font-size: 14px;">Seems like no {!!$admin_object['title']!!} have been created yet.</span></strong>

 	</h4>

	 @endforelse

	</div>

</div>



@endif

