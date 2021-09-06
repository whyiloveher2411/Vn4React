<?php 
  title_head(__('Widgets'));
 ?>
@extends(backend_theme('master'))

@section('css')
  <style>
    .form-control{
      font-weight: normal;
    }
    .widget-list-ready .widget-item .x_title, .widget-item .x_title{
        background: #fafafa;
        color: #23282d;
        border: 1px solid #e5e5e5;
        cursor: pointer;
    }
    .widget-list-ready .widget-item .x_title:hover, .widget-item .x_title:hover{
        border-color: #999;
    }
    .widget-list-right .area-widget>.x_panel {
      border: 1px solid #e5e5e5;
    }
    .widget-item{
      border: none;
      box-shadow: none;
     -webkit-transition: none;
     -o-transition: none;
     transition: none;
    }
    .widget-item label{
      width: 100%;
    }
    
    .widget-list-ready .widget-item  .collapse-link{
      display: none;
    }
    .widget-list-ready .x_panel{
      background: transparent;
      float: left;
    }
     .widget-list-ready .widget-item-warpper{
        padding: 0;
        display: inline;
     }
     .widget-list-ready .widget-item-warpper:nth-child(odd){
      padding-right: 5px;
      clear: both;
     }
     .widget-list-ready .widget-item-warpper:nth-child(even){
      padding-right: 5px;
     }
    .widget-item .x_content{
      display: none;
      border: 1px solid #e5e5e5;
      border-top: none;
    }
    .widget-list-ready .widget-item .x_title h2,.widget-list-right .area-widget>.x_title h2, .widget-item .x_title h2{
      line-height: 25px;
      text-transform: initial;
      font-weight: bold;
      font-size: 13px;
    }
    .area-widget.active_hover{
      border:1px solid #000;
    }
    .area-widget>.x_content{
      padding: 0 10px;
    }
    .widget-list-right .area-widget>.x_title {
      border: none;
    }
    .action-widget{
      margin-top:5px;
    }
    .area-widget .widget-item{
      width: 100% !important;
      margin-top: -10px;
    }
    .widget-list-right .area-widget>.x_title h2{
      font-size: 17px;
      line-height: 28px;
    }
    .delete-widget-item:hover, .delete-widget-item:active{
      color: #dc0000;
    }
    .delete-widget-item, .close-widget-item{
      text-decoration: underline;
    }

    .area-widget>.x_content{
      display: block;
    }

    .area-widget.hide_more>.x_content{
      display: none;
    }

    .widget-placeholder{
      margin-bottom: 10px;
      background: #000;
      width: 100%;
      height: 45px;
    }

    .ui-sortable-placeholder{
        border: 1px dashed  #b7b7b7 !important;
        visibility: inherit !important;
        z-index: -1 !important;
        width: 100%;
    }
    .x_panel , .x_title{
      float: none;
      z-index: initial;
    }
    .list-widget-item{
      padding: 5px 0;
    }
    .ui-draggable-dragging{
      z-index: 1000;
    }
    .ui-draggable-handle{
      width: 100% !important;
    }
    .list-widget-added{
      padding: 10px 0;
    }

    .list-widget-added .ui-sortable-helper{
      width: 100% !important;
      padding: 0 10px !important;
      background: transparent;
    }
    .widgets-chooser ul.widgets-chooser-sidebars {
        margin: 0;
        list-style-type: none;
        max-height: 300px;
        overflow: auto;
    }
    .widgets-chooser li {
        width: 100% !important;
        padding: 10px 15px 10px 35px;
        border-bottom: 1px solid #ccc;
        background: #fff;
        margin: 0;
        cursor: pointer;
        outline: 0;
        position: relative;
        -webkit-transition: background .2s ease-in-out;
        transition: background .2s ease-in-out;
    }
    .widgets-chooser li.widgets-chooser-selected {
        background: #00a0d2;
        color: #fff;
    }
    .widgets-chooser li.widgets-chooser-selected:before, .widgets-chooser li.widgets-chooser-selected:focus:before {
      content: "\f00c";
      display: block;
      -webkit-font-smoothing: antialiased;
      font: normal normal normal 14px/1 FontAwesome;
      color: #fff;
      position: absolute;
      top: 12px;
      left: 12px;
    }
    .widgets-chooser-actions{
      text-align: center;
      margin: 5px 0;
    }
    .widgets-chooser-actions button{
      margin: 0 5px 0 0;
    }
    .chooser .widget-item-warpper:not(.widget-item-warpper-active){
        -webkit-transition: opacity .1s linear;
        transition: opacity .1s linear;
        opacity: .2;
        pointer-events: none;
    }
    .widgets-chooser-item .widgets-chooser{
      display: none;
    }
    .input-link-parent{
      display: inline-block;
    }
  </style>
@stop
@section('content')

<?php  
  
    $list_widgets = use_module('widget');
  
    $list_sidebar = apply_filter('register_sidebar',[]);
    $list_sidebar2 = do_action('register_sidebar',$list_sidebar);

    if( $list_sidebar2 ) $list_sidebar = $list_sidebar2;

    $theme_name = theme_name();

    $i = 0;

 ?>

<div class="row">
  <div class="col-xs-12 col-md-5">
     <div class="x_panel vn4-bg-trans" id="widgets-left" style="z-index: 1;">
        <div class="x_title">
          <h2>
              @__('Available Widgets')
          </h2>
          <ul class="nav navbar-right panel_toolbox">
             <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          
          <p>@__('To activate a widget drag it to a sidebar or click on it. To deactivate a widget and delete its settings, drag it back.')</p>
            
          <div class="widget-list-ready">

            <?php 
              foreach ($list_widgets as $key => $widget) {
                  $widget['data'] = [];
                 (new Vn4Widget($key, $widget['title'], $widget ))->form_widget_html_left();
              }
             ?>

          </div>
          <div class="clearfix"></div>
          <div class="widgets-chooser-general" style="display:none;">
            <div class="widgets-chooser">
              <ul class="widgets-chooser-sidebars">

                @foreach($list_sidebar as $key => $sidebar)
                  @if($i === 0)
                  <li tabindex="0" class="widgets-chooser-selected {!!str_slug($key)!!}" data-class="{!!str_slug($key)!!}" >{!!$sidebar['title']!!}</li>
                  @else
                  <li tabindex="0" class="{!!str_slug($key)!!}" data-class="{!!str_slug($key)!!}">{!!$sidebar['title']!!}</li>
                  @endif
                  <?php $i ++; ?>
                @endforeach

                <?php $i = 0; ?>
              </ul>
              <div class="widgets-chooser-actions">
                <button class="vn4-btn btn-cancel">Hủy</button>
                <button class="vn4-btn vn4-btn-blue btn-add">Thêm</button>
              </div>
            </div>
          </div>
          
        </div>
      </div>

      <div class="x_panel area-widget vn4-bg-trans" id="sidebar-not-uses" data-id="sidebar_not_uses">

        <div class="x_title">
          <h2>
              @__('Inactive Widgets')
          </h2>
          <ul class="nav navbar-right panel_toolbox">
             <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          
          <p class="descripion-sidebar">@__('Drag widgets here to remove them from the sidebar but keep their settings')</p>

          <div class="list-widget-added connectedSortable">
              <?php 

                   $sidebarDetail = Vn4Model::table(vn4_tbpf().'widget')->where('sidebar_id','sidebar_not_uses')->where('theme',$theme_name)->first();

                    if( $sidebarDetail ){

                        $widgets = json_decode($sidebarDetail->content,true);

                        foreach ($widgets as $widget) {

                          if( isset($list_widgets[$widget['type']]) ){

                            $widgetDetail = $list_widgets[$widget['type']];
                            $widgetDetail['data'] = $widget['data'];

                            $widget = (new Vn4Widget($widget['type'], $list_widgets[$widget['type']]['title'], $widgetDetail ));

                            $widget->form_widget_html_right();
                          }
                          
                        }
                    }

               ?>
          </div>
        </div>
      </div>

  </div>
  <div class="col-xs-12 col-md-7 widget-list-right" style="z-index: 1;">
    <div class="row">

    @if( count($list_sidebar) > 0 )
      <?php 

      		if( count($list_sidebar) > 1 ){
          		list($list_sidebar_left, $list_sidebar_right) = array_chunk($list_sidebar, ceil(count($list_sidebar) / 2),true);
          	}else{
          		$list_sidebar_left = $list_sidebar;
          		$list_sidebar_right = [];
          	}
       ?>
        <div class="col-xs-12 col-md-6 widget-column-1">
          @foreach($list_sidebar_left as $key => $sidebar)
            <div class="x_panel area-widget" data-id="{!!$key!!}" id="{!!str_slug($key)!!}">

              <div class="x_title">
                <h2>
                    {!!$sidebar['title']!!}
                </h2>
                <ul class="nav navbar-right panel_toolbox">
                   <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                  </li>
                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                
                <p class="descripion-sidebar">{!!$sidebar['description']!!}</p>
                
                <div class="list-widget-added connectedSortable">
                    <?php 
                        
                        $sidebarDetail = Vn4Model::table(vn4_tbpf().'widget')->where('sidebar_id',$key)->where('theme',$theme_name)->first();

                        if( $sidebarDetail ){

                            $widgets = json_decode($sidebarDetail->content,true);

                            foreach ($widgets as $widget) {

                              if( isset($list_widgets[$widget['type']]) ){

                                $widgetDetail = $list_widgets[$widget['type']];
                                $widgetDetail['data'] = $widget['data'];

                                $widget = (new Vn4Widget($widget['type'], $list_widgets[$widget['type']]['title'], $widgetDetail ));

                                $widget->form_widget_html_right();
                              }
                              
                            }
                        }
                        
                     ?>
                </div>
              </div>
            </div>
          @endforeach

          <?php $i = 0; ?>

        </div>

        <div class="col-xs-12 col-md-6 widget-column-2">
          
          @foreach($list_sidebar_right as $key => $sidebar)
            
            <div class="x_panel area-widget" id="{!!str_slug($key)!!}" data-id="{!!$key!!}">

              <div class="x_title">
                <h2>
                    {!!$sidebar['title']!!}
                </h2>
                <ul class="nav navbar-right panel_toolbox">
                   <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                  </li>
                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                
                <p class="descripion-sidebar">{!!$sidebar['description']!!}</p>
                
                <div class="list-widget-added connectedSortable">
                    <?php 

                      $sidebarDetail = Vn4Model::table(vn4_tbpf().'widget')->where('sidebar_id',$key)->where('theme',$theme_name)->first();

                      if( $sidebarDetail ){

                          $widgets = json_decode($sidebarDetail->content,true);

                          foreach ($widgets as $widget) {

                            if( isset($list_widgets[$widget['type']]) ){

                              $widgetDetail = $list_widgets[$widget['type']];
                              $widgetDetail['data'] = $widget['data'];

                              $widget = (new Vn4Widget($widget['type'], $list_widgets[$widget['type']]['title'], $widgetDetail ));

                              $widget->form_widget_html_right();
                            }
                            
                          }
                       }
                     ?>
                </div>
              </div>
            </div>

          @endforeach

          <?php $i = 0; ?>

        </div>
    @else
     <h4 style="font-size:18px;text-align: center;">
      <img style="box-shadow: none;width: 200px;max-width: 200px;height: auto;max-height: 200px;display: block;margin: 0 auto;" src="{!!asset('admin/images/data-not-found.png')!!}">
      <strong>@__('Sidebar not found')<br> 
        <span style="color:#ababab;font-size: 16px;">@__('Seems like no sidebar have been created yet.')</span>
      </strong>
    </h4>
    @endif


    </div>
      
  </div>
</div>

  <?php 
  
add_action('vn4_footer',function(){

    ?>
     <script src="{!!asset('admin/js/jquery-ui.min.js')!!}" async></script>
    <?php
},'add_jquery_ui',true);

 ?>

@stop

@section('js')

    <script>
      $(window).load(function() {

        function update_sidebar_widget(){

            var $list_sidebar = $('.area-widget'),
              list_sidebar_widget = [];


            $list_sidebar.each(function(index, el) {
              
              $widget_item = $(el).find('.widget-item');

              var list_widget = [];

              $widget_item.find('>form').each(function(index, el2) {

                var valueOfItem = [];

                $(el2).find('.input-widget-item').each(function(index3,el3){
                  valueOfItem.push($(el3).find(':input').serialize());
                });

                list_widget.push({ type: $(el2).find('>:input[name=key]').val(),data:valueOfItem});


              });
            
              if( list_widget.length ){
                list_sidebar_widget.push({[$(el).data('id')]: list_widget});
              }else{
                list_sidebar_widget.push({[$(el).data('id')]: ''});
              }

            });


            vn4_ajax({
              type:'POST',
              show_loading:true,
              data:{
                list_sidebar_widget:list_sidebar_widget,
              },
              callback:function(result){
                
              }

            });
            
        }

        var is_updating = false;


        $( function() {

          $( ".list-widget-added" ).sortable({
              revert: 0,
              handle: '.widget-handle',
              scroll: false,
              revertDuration:0,
              forcePlaceholderSize: true,
              connectWith: ".connectedSortable",
              stop:function(event, ui){

              },
              update:function(){
                if(!is_updating){
                  is_updating = true;

                  update_sidebar_widget();

                  setTimeout(function() {

                    is_updating = false;

                  }, 1000);

                }
              }
          });
        });



            var column_draggable = $( ".widget-list-ready .widget-item" ).draggable({
              connectToSortable: ".connectedSortable",
              helper: "clone",
              handle: '.x_title',
              scrollSpeed:2,
              revertDuration:0,
              revert: "invalid",
              start:function(){
                $('.area-widget').addClass('active_hover');
              },
              stop:function(event, ui){
                  $('.area-widget').removeClass('active_hover');
              },

            });



          $('body').on('click', '.delete-widget-added', function(event) {
            event.preventDefault();
            $(this).closest('.widget-item').remove();

            update_sidebar_widget();
          });

          $('body').on('click', '.close-widget-added', function(event) {
            event.preventDefault();
            
            $(this).closest('.widget-item').find('.collapse-link:first').trigger('click');
          });

          $('.widget-list-ready ').on('click', '.widget-item', function(event) {
            event.preventDefault();
            event.stopPropagation();
            var $this = $(this);

            $this.closest('.widget-item-warpper').toggleClass('widget-item-warpper-active');

            if( $this.closest('.widget-item-warpper').hasClass('widget-item-warpper-active') ){

              $this.closest('#widgets-left').addClass('chooser');

              $this.closest('.widget-item-warpper').find('.widgets-chooser-item:first').empty().append($('.widgets-chooser-general').html());

              $this.closest('.widget-item-warpper').find('.widgets-chooser-item:first .widgets-chooser').slideDown('fast');

            }else{

              $this.closest('#widgets-left').removeClass('chooser');

              $this.closest('.widget-item-warpper').find('.widgets-chooser-item:first .widgets-chooser').slideUp('fast',function(){
                  $this.closest('.widget-item-warpper').find('.widgets-chooser-item:first').empty();
              });

            }

            
          });

          $('#widgets-left').on('click', '.widgets-chooser-item .widgets-chooser .btn-cancel', function(event) {

            event.preventDefault();

            var $this = $(this);

            $this.closest('.widget-item-warpper-active').removeClass('widget-item-warpper-active');

            $this.closest('#widgets-left').removeClass('chooser');

            $this.closest('.widgets-chooser-item').find('.widgets-chooser').slideUp('fast',function(){

                $this.closest('.widget-item-warpper').find('.widgets-chooser-item:first').empty();

            });
          });

          $('#widgets-left').on('click', '.widgets-chooser-sidebars li', function(event) {
            event.preventDefault();
            $('.widgets-chooser-selected').removeClass('widgets-chooser-selected');
            $('.'+$(this).attr('data-class')).addClass('widgets-chooser-selected');
          });


          $('#widgets-left').on('click', '.widgets-chooser-item .widgets-chooser .btn-cancel', function(event) {

            event.preventDefault();

            var $this = $(this);

            $this.closest('.widget-item-warpper-active').removeClass('widget-item-warpper-active');

            $this.closest('#widgets-left').removeClass('chooser');

            $this.closest('.widgets-chooser-item').find('.widgets-chooser').slideUp('fast',function(){

                $this.closest('.widget-item-warpper').find('.widgets-chooser-item:first').empty();

            });
          });

          $('#widgets-left').on('click', '.widgets-chooser-item .widgets-chooser .btn-add', function(event) {

            event.preventDefault();

            var $this = $(this);

            $('.widget-list-right #'+ $this.closest('.widgets-chooser').find('.widgets-chooser-selected:first').attr('data-class')+' .list-widget-added').append($this.closest('.widget-item-warpper').find('.widget-item:first').prop('outerHTML'));

            $this.closest('.widget-item-warpper-active').removeClass('widget-item-warpper-active');

            $this.closest('#widgets-left').removeClass('chooser');

            $this.closest('.widgets-chooser-item').find('.widgets-chooser').slideUp('fast',function(){

                $this.closest('.widget-item-warpper').find('.widgets-chooser-item:first').empty();

            });

            update_sidebar_widget();
          });

          $('body').on('click', '.btn-save-widget', function(event) {
            event.preventDefault();
            update_sidebar_widget();
          });


      });
      
    </script>
@stop