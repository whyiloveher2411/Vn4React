<?php 
  title_head(__('Sitemap'));

  $active_sitemap = $plugin->getMeta('active_sitemap');
 ?>
  
  <style>
    .title-master .checkbox{
      display: inline-block !important;
      margin: 0;
    }
    .vn4_tabs_top>.content-bottom{
      background: none;
      border: none;
    }
    .menu-top{
        border-bottom: 1px solid #ddd;
    }

    .disabled{
      opacity: .2;
       pointer-events: none;
       cursor: not-allowed;
    }
    .disabled .disabled{
      opacity: 1;
    }
  </style>

  <input type="hidden" name="form" value="sitemap">

  <input type="hidden" @if($active_sitemap) value="1" @else value="0" @endif name="active_sitemap" id="active_sitemap2">

  <div class="row">
    
      <div class="col-md-3 col-xs-12">
        <h3>Custom post types</h3>
        <p class="note">Activate sitemap for custom post types.</p>

        <label> Active: 
          {!!get_field('checkbox',['value'=>$active_sitemap,'list_option'=>['active'=>''],'key'=>'active_sitemap','name'=>'active','toggle'=>true,'layout'=>'horizontal'])!!}
        </label>

        @if($active_sitemap)
        <p style="margin-top: 10px;">
          <a class="vn4-btn vn4-btn-link" href="{!!route('sitemap_detail','sitemap')!!}" target="_blank">See Sitemap</a>
        </p>
        @endif

      </div>
      <div class="col-md-9 col-xs-12  post_type_sitemap @if(!$active_sitemap) disabled @endif" >
        <div class="x_panel" style="padding: 10px 0;border-radius: 4px;">
        <?php 
          $admin_object = get_admin_object();

          $post_type_actived = $plugin->getMeta('post-type-sitemap');

          if( !is_array($post_type_actived) ) $post_type_actived = [];
         ?>
         @foreach($admin_object as $key => $a)
          <div class="col-xs-6 col-md-4 @if( !isset($a['fields']['slug'])) disabled @endif" >
            <label><input type="checkbox"  @if( array_search($key, $post_type_actived) !== false ) checked="checked" @endif  name="post-type-sitemap[]" value="{!!$key!!}"> {!!$a['title']!!}</label>
          </div>
         @endforeach
        <div class="clearfix"></div>
        </div>
      </div>



  </div>

<?php 
  add_action('vn4_footer',function(){
    ?>
    <script type="text/javascript">
      $(window).load(function(){
        $(document).on('click','#active_sitemap input[name="active[]"]',function(){
            $('#active_sitemap2').attr('value',$(this).prop('checked')?1:0);
            $('.post_type_sitemap').toggleClass('disabled');
        });
      });
      </script>
    <?php
  })
 ?>
