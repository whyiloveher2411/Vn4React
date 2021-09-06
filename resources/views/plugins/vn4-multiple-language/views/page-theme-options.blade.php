<?php 
$lang_default = language_default();
$languages = languages();

$r = request();

$request_lang = $r->get('language',$lang_default['lang_slug']);

if( isset($languages[$request_lang]) ){
	$lang_default = $languages[$request_lang];
}

$input = $r->except(['language']);
$urlParam = '';
foreach ($input as $key => $p) {

	if( $key === 'post' ){
		$urlParam = $urlParam.'&translate_post='.$p;
	}else{
		$urlParam = $urlParam.'&'.$key.'='.$p;
	}
}

if( $urlParam !== '' ){
	$urlParam = '?'.substr($urlParam, 1).'&language=';
}else{
	$urlParam = '?language=';
}
?>

<div class="dropdown" style="display:inline;">
  <a href="#" class="dropdown-toggle vn4-btn" data-toggle="dropdown" role="button" aria-expanded="false"><img title="{!!$lang_default['lang_name']!!}" style="margin-top: -3px;" src="{!!plugin_asset($plugin,'flags/'.$lang_default['flag'].'.png')!!}"> {!!$lang_default['lang_name']!!} <i class="fa fa-sort-desc" style="vertical-align: top;margin-top: 4px;"></i></a>
  <ul class="dropdown-menu" role="menu" style="margin-top:8px;">
  	@foreach ($languages as $key => $l)
		@if( $key !== $lang_default['lang_slug'])
	    	<li><a href="{!!$urlParam.$key!!}" ><img title="{!!$l['lang_name']!!}" style="" src="{!!plugin_asset($plugin,'flags/'.$l['flag'].'.png')!!}"> {!!$l['lang_name']!!}</a></li>
		@endif
	@endforeach
  </ul>
</div>