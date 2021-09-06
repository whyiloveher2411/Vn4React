<?php 

    if( !$post && isset($default_value ) ) $value = $default_value;

	$post_type = get_admin_object();

 ?>

<div class="input-link-parent">


	<?php 
    	$value = json_decode($value,true);
	 ?>

	@if( isset($value['type']) )


		@if( $value['type'] === 'post-detail' && isset($post_type[$value['post_type']]) && $post_detail = get_post($value['post_type'], $value['id']) )

			<input type="hidden" class="input-title" value="{!!$post_detail->title!!}">
			<div style="border: 1px solid #ccc;padding: 10px;font-weight: bold;line-height: 14px;overflow-wrap: break-word;"> <span style="color: #9a9a9a;line-height: 14px;" class="link-type"> Post Type: {!!$post_type[$value['post_type']]['title']!!}</span> <br>
		    <span class="value-input-link" style="line-height: 14px;"><a target="_blank" href="{!!get_permalinks($post_detail)!!}">{!!$post_detail->title!!}</a></span>
		    </div>

		@elseif( $value['type'] === 'custom-link' && isset($value['link']) )

			<input type="hidden" class="input-title" value="{!!$value['link']!!}">

			<div style="border: 1px solid #ccc;padding: 10px;font-weight: bold;line-height: 14px;overflow-wrap: break-word;"> <span style="color: #9a9a9a;line-height: 14px;" class="link-type"> @__('Custom Link'):</span> <br>
		    <span class="value-input-link" style="line-height: 14px;"><a target="_blank" href="{!!$value['link']!!}">{!!$value['link']!!}</a></span>
		    </div>

		@elseif( $value['type'] === 'page' && isset($value['page']) )

			<input type="hidden" class="input-title" value="{!!$value['page']!!}">

			<div style="border: 1px solid #ccc;padding: 10px;font-weight: bold;line-height: 14px;overflow-wrap: break-word;"> <span style="color: #9a9a9a;line-height: 14px;" class="link-type"> @__('Page'):</span> <br>
		    <span class="value-input-link" style="line-height: 14px;"><a target="_blank" href="{!!route('page',$value['page'])!!}">{!!$value['page']!!}</a></span>
		    </div>

		@endif


    @else

	<input type="hidden" class="input-title" value="@__('(Not Value)')">

	<div style="border: 1px solid #ccc;padding: 10px;font-weight: bold;line-height: 14px;"> <span style="color: #9a9a9a;line-height: 14px;" class="link-type"> Post:</span> <br>
    <span class="value-input-link" style="line-height: 14px;">Lorem ipsum dolor sit amet, consectetur adipisicing elit</span>
    </div>
    @endif

    <div class="input-group-addon open-popup-input-link" data-popup="1" data-title="@__('Input Link')" data-max-width="700px" data-iframe="{!!route('admin.controller',['controller'=>'input-link','method'=>'get-link','postType'=>'page'])!!}" style="cursor: pointer;font-weight: bold;">Link</div>
	<input type="hidden" name="{!!isset($name)?$name:$key!!}" value="{{json_encode($value)}}" id="{!!$key!!}" class="form-control input-text">
</div>

