<div class="session session-content session-{!!$k!!}">
  <div class="warpper-sidenav-header bd-bt">
    <div class="sidenav-header">
      <div class="icon-back show-session" data-session="screen-1"></div>
      <h4 class="title-small">{!!$title_small!!}</h4>
      <h2 class="title">{!!$s['title']!!}</h2>
      @if( isset($description) )
       <i class="icon-question"></i>
      @endif
    </div>

    @if( isset($description) )
     <div class="sidenav-description bd-t">
      {!!$description!!}
    </div>
    @endif

  </div>
  <div class="pd">
      @if( !isset($s['ajaxUrl']) )
         @foreach($s['fields'] as $k => $f)
            @if( isset($f['title']) )
              <label for="{!!$k!!}">{!!$f['title']!!}</label>
            @endif
            @if( isset($f['note']) )
              <p>{!!$f['note']!!}</p>
            @endif
            {!!get_field($f['view'],['key'=>'options['.$k.']','value'=>get_option($k)])!!}
        @endforeach
      @endif
  </div>
</div>