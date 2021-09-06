@if( $type === 'chose-menu')
<li class=""><label><input type="checkbox" class="check_obj" name="vn4-multiple-language-language-switcher-menu[]" value="language-switcher">Language switcher</label></li>
@else
<?php 
	$label = 'Language switcher';
	$attrtitle = isset($attrtitle)?$attrtitle:'';
	$target = isset($target)?$target:'';
	$classes = isset($classes)?$classes:'';
	$xfn = isset($xfn)?$xfn:'';
	$description = isset($description)?$description:'';
 ?>

<li class="dd-item" data-posttype="vn4-multiple-language-language-switcher-menu" data-attrTitle="{{$attrtitle}}" data-target="{{$target}}" data-classes="{{$classes}}" data-xfn="{{$xfn}}" data-description="{{$description}}" >

	<div class="dd-handle">{!!$label!!}
	</div>
	<i class="fa icon-collapse icon-detail-all"></i>
	<i class="fa icon-remove"></i>
	<i class="fa icon-edit"></i>
	<p class="menu_type">{!!$label!!}</p>
	<div class="menu_item_info">

		<div class="form-group">
			<label class="control-label col-xs-12">@__('Title Attribute')
				<input type="text" data-trigger="attrTitle" value="{{$attrtitle}}" name="attrtitle" class="form-control change-data-menu">
			</label>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-12">
				<input type="checkbox" data-trigger="target" @if($target) checked @endif value="_blank" class="form-control change-target" name="target">@__('Open link in a new tab')
			</label>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-6">@__('CSS Classes (optional)')
				<input type="text" data-trigger="classes" name="classes" value="{{$classes}}" class="form-control change-data-menu">
			</label>
			<label class="control-label col-xs-6">@__('Link Relationship (XFN)')
				<input type="text" data-trigger="xfn" name="xfn" value="{{$xfn}}" class="form-control change-data-menu">
			</label>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-12">@__('Description')
				<textarea name="description" data-trigger="description" class="form-control change-data-menu" rows="3">{{$description}}</textarea>
				<p class="note">The description will be displayed in the menu if the current theme supports it.</p>
			</label>
		</div>

		<div class="clearfix"></div>
		<p class="menu_item_controls"> <a type="button" class="btn-control btn-remove">@__('Delete')</a> | <a type="button" class="btn-control btn-cancel">@__('Close')</a></p>
	</div>

	{!!@$children!!}
</li>

@endif