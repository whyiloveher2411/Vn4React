@foreach($menu as $m)
<li>
	@if( isset($m['children']))
		<a href="{!!$m['link']!!}" class="dropdown-toggle" @if( isset($m['target']) && $m['target']) target="{!!$m['target']!!}" @endif @if($m['xfn']) {!!$m['xfn']!!} @endif @if($m['attrtitle']) title="{!!$m['attrtitle']!!}" @endif>{!!$m['label']!!}</a>
		<ul class="submenu">
			@foreach($m['children'] as $m2)
            <li><a href="{!!$m2['link']!!}" @if( isset($m2['target']) && $m2['target']) target="{!!$m2['target']!!}" @endif @if($m2['xfn']) {!!$m2['xfn']!!} @endif @if($m2['attrtitle']) title="{!!$m2['attrtitle']!!}" @endif >{!!$m2['label']!!}</a></li>
			@endforeach
        </ul>
	@else
		<a href="{!!$m['link']!!}" @if( isset($m['target']) && $m['target']) target="{!!$m['target']!!}" @endif @if($m['xfn']) {!!$m['xfn']!!} @endif @if($m['attrtitle']) title="{!!$m['attrtitle']!!}" @endif>{!!$m['label']!!}</a>
	@endif
</li>
@endforeach
