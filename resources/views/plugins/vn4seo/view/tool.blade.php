<?php 
  title_head(__('Tool'));


  $active_sitemap = $plugin->getMeta('active_sitemap');

  add_action('vn4_heading',function() use ($active_sitemap){
    echo get_field('checkbox',['value'=>$active_sitemap,'list_option'=>['active'=>''],'key'=>'active_sitemap','name'=>'active','toggle'=>true,'layout'=>'horizontal']);
  });


 ?>
@extends(backend_theme('master'))
@section('css')
  
  <style>
    .title-master .checkbox{
      display: inline-block !important;
      margin: 0;
    }
    .vn4_tabs_top>.content-bottom{
      background: none;
      border: none;
      padding: 0;
    }
    .menu-top{
        border-bottom: 1px solid #ddd;
    }

    .disabled{
      opacity: .6;
       pointer-events: none;
       cursor: not-allowed;
    }
    .disabled .disabled{
      opacity: 1;
    }
  </style>
@stop
@section('content')

<form method="POST">
      <input type="hidden" value="{!!csrf_token()!!}" name="_token">
      <input type="hidden" @if($active_sitemap) value="1" @else value="0" @endif name="active_sitemap" id="active_sitemap2">

  <div class="row post_type_sitemap @if(!$active_sitemap) disabled @endif">
    
      <div class="col-md-6 col-xs-12">

        <h3>Import and Export</h3>
        <p class="note">Import setting from other SEO plugins and export your settings for re-use on (another) website.</p>
        <a class="vn4-btn vn4-btn-link" href="{!!route('admin.plugins.'.$plugin->key_word,['page'=>'tool','action'=>'check_html'])!!}">Export</a>
        <hr>

        <h3>Check html</h3>
        <p class="note">Check for html issues EX: link, image ...</p>
        <a class="vn4-btn vn4-btn-link" href="{!!route('admin.plugins.'.$plugin->key_word,['page'=>'tool','action'=>'check_html'])!!}">Check</a>
        <hr>

      </div>

  </div>
        <input style="margin-left:10px;" type="submit" class="vn4-btn vn4-btn-blue" name="save-change" value="@__('Save changes')">
    
</form>

@stop

@section('js')
<script type="text/javascript">

$(window).load(function(){
  $('#active_sitemap input[name="active[]"]').click(function(){
      $('#active_sitemap2').attr('value',$(this).prop('checked')?1:0);
      $('.post_type_sitemap').toggleClass('disabled');
  });
});
</script>
@stop
