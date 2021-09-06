<ul class="navbar-nav ml-auto">
    @foreach($menu as $m)
    <li class="nav-item" style="display: flex;align-items: center;">
        <a class="nav-link" href="{!!$m['link']!!}" @if( isset($m['target']) && $m['target']) target="{!!$m['target']!!}" @endif @if($m['xfn']) {!!$m['xfn']!!} @endif @if($m['attrtitle']) title="{!!$m['attrtitle']!!}" @endif>{!!$m['label']!!}</a>
    </li>
    @endforeach
</ul>
