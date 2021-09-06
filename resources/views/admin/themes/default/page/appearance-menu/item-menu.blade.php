<?php 
	$attrtitle = isset($attrtitle)?$attrtitle:'';
	$target = isset($target)?$target:'';
	$classes = isset($classes)?$classes:'';
	$xfn = isset($xfn)?$xfn:'';
	$description = isset($description)?$description:'';
 ?>

<li class="dd-item wrap-{!!$class!!}" {!!$strData!!} data-attrtitle="{{$attrtitle}}" data-target="{{$target}}" data-classes="{{$classes}}" data-xfn="{{$xfn}}" data-description="{!!htmlentities($description)!!}" >

	<div class="dd-handle">{{$label}}
	</div>
	<i class="fa icon-collapse icon-detail-all"></i>
	<i class="fa icon-remove"></i>
	<i class="fa icon-edit"></i>
	<p class="menu_type">{!!$label_type!!}</p>
	<div class="menu_item_info">

		<?php 
			do_action('item-menu',$param);
		 ?>

		@if($menu_type === 'custom links')
		<div class="form-group">
			<label class="control-label col-xs-12 in-url">URL
				<input type="text" class="form-control input-links" name="links" value="{{$links}}" placeholder="http://">
			</label>
		</div>
		@endif
		
		<div class="form-group in-label">
			<label class="control-label col-xs-12">@__('Navigation Label')
				<input type="text" value="{{$label}}" class="form-control input-nav-label">
			</label>
		</div>

		<div class="form-group in-attr">
			<label class="control-label col-xs-12">@__('Title Attribute')
				<input type="text" data-trigger="attrtitle" value="{{$attrtitle}}" name="attrtitle" class="form-control change-data-menu">
			</label>
		</div>

		<div class="form-group in-target">
			<label class="control-label col-xs-12">
				<input type="checkbox" data-trigger="target" @if($target) checked @endif value="_blank" class="form-control change-target" name="target">@__('Open link in a new tab')
			</label>
		</div>

		<div class="form-group in-option">
			<label class="control-label col-xs-6">@__('CSS Classes (optional)')
				<input type="text" data-trigger="classes" name="classes" value="{{$classes}}" class="form-control change-data-menu">
			</label>
			<label class="control-label col-xs-6">@__('Link Relationship (XFN)')
				<input type="text" data-trigger="xfn" name="xfn" value="{{$xfn}}" class="form-control change-data-menu">
			</label>
		</div>

		<div class="form-group in-description">
			<label class="control-label col-xs-12">@__('Description')
				<textarea name="description" data-trigger="description" class="form-control change-data-menu" rows="3">{{$description}}</textarea>
				<p class="note">The description will be displayed in the menu if the current theme supports it.</p>
			</label>
		</div>

		<div class="clearfix"></div>
		<p class="menu_item_controls"> <a type="button" class="btn-control btn-remove">@__('Delete')</a> | <a type="button" class="btn-control btn-cancel">@__('Close')</a></p>
	</div>

	{!!$children??''!!}
</li>