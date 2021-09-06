<?php

$routeName =  Route::currentRouteName();

$routeType = Route::current()->parameters['type'];

$lang_default = language_default();
$lang_default2 = $lang_default;

$languages = languages();

$urlParam = '';

$r = request();
$input = $r->except(['translate_post','language','action_post']);

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

if( $key_lang_default = $r->get('language') ){

	if( isset($languages[$key_lang_default]) ){
		$lang_default = $languages[$key_lang_default];
		$lang_default['key'] = $key_lang_default;
	}

}else{
	$lang_default['key'] = $lang_default['lang_slug'];
}
$listPostConnect = [];


if( $post !== null ){

	$listPostConnect = $post->getMeta('vn4-multiple-language-post-connect');

	if( isset($listPostConnect['post']) ){
		$listPostConnect = $listPostConnect['post'];
	}else{
		$listPostConnect = [];
	}
	
	foreach ($languages as $key => $value) {
		if( $value['lang_slug'] === $post->language ){
			$lang_default = array_merge($value,['key'=>$key]);
			break;
		} 
	}

}elseif( $translate_post = $r->get('translate_post') ){

	$post = get_post($post_type,$translate_post);

	if( $post ){
		$listPostConnect = $post->getMeta('vn4-multiple-language-post-connect');

		if( isset($listPostConnect['post']) ){
			$listPostConnect = $listPostConnect['post'];
		}else{
			$listPostConnect = [];
		}

		if( !$post->language || !isset($languages[$post->language]) ){
			$post->language = $lang_default2['lang_slug'];
			$post->save();
		}

		$listPostConnect[$post->language] = ['id'=>$post->id,'title'=>$post->title];
		$has_translate_post = true;
	}
}

?>

@if( $post && (!$post->language || isset($languages[$post->language])) )

@endif


@if( is_array($listPostConnect) )
	@foreach ($listPostConnect as $key => $p)
		@if( isset($languages[$key]) )
		<input type="hidden" value="{!!$p['id']!!}" name="postConnect[{!!$key!!}][id]">
		<input type="hidden" value="{!!$p['title']!!}" name="postConnect[{!!$key!!}][title]">
		@endif
	@endforeach
@endif

@__('Languages')
<div class="dropdown" style="display:inline;">
  <a href="#" class="dropdown-toggle vn4-btn" data-toggle="dropdown" role="button" aria-expanded="false"><img title="{!!$lang_default['lang_name']!!}" style="margin-top: -3px;" src="{!!plugin_asset($plugin,'flags/'.$lang_default['flag'].'.png')!!}"> {!!$lang_default['lang_name']!!} <i class="fa fa-sort-desc" style="vertical-align: top;margin-top: 4px;"></i></a>

  <input type="hidden" name="language_post" value="{!!$lang_default['key']!!}">

  <ul class="dropdown-menu" role="menu" style="margin-top:8px;">

  	@foreach ($languages as $key => $l)
		@if( $key !== $lang_default['key'])
			@if( isset($listPostConnect[$l['lang_slug']]) )
	    	<li><a href="{!!route($routeName,['type'=>$routeType,'post'=>$listPostConnect[$l['lang_slug']]['id'],'action_post'=>'edit'])!!}" ><img title="{!!$l['lang_name']!!}" style="" src="{!!plugin_asset($plugin,'flags/'.$l['flag'].'.png')!!}"> {!!$l['lang_name']!!} - <span style="color:#666666;">1 version</span></a></li>
	    	@else
	    	<li><a href="@if( $post ){!!$urlParam.$key.'&post='.$post->id.'&action_post=copy'!!}@else{!!$urlParam.$key!!}@endif" ><img title="{!!$l['lang_name']!!}" style="" src="{!!plugin_asset($plugin,'flags/'.$l['flag'].'.png')!!}"> {!!$l['lang_name']!!}</a></li>
	    	@endif
		@endif
	@endforeach
  </ul>
</div>


