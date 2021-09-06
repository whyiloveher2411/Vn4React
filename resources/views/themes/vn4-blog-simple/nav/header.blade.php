@foreach($menu as $m)
<a href="{!!$m['link']!!}" @if( isset($m['target']) && $m['target']) target="{!!$m['target']!!}" @endif @if($m['xfn']) {!!$m['xfn']!!} @endif @if($m['attrtitle']) title="{!!$m['attrtitle']!!}" @endif>{!!$m['label']!!}</a>
@endforeach
