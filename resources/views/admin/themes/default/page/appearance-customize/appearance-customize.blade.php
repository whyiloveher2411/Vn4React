@extends(backend_theme('master-customize'))
<?php 

  $user = Auth::user();
  $user->customize_time = time() + 1;
  $user->save();
  $GLOBALS['sectionConfig'] = [
    'site-identity'=>[
      'title'=>'Site Identity',
      'title-small'=>'Customizing',
      'fields'=>[
          'system'=>[
              'view'=>[
                'form'=>function($arg){
                    ?>
                      <label for="">Logo</label>
                      {!!get_field('image',['value'=>theme_options('site','logo'),'key'=>'options[site_logo]'])!!}
                      <label>
                        Site Title
                        <input type="text" name="options[site_title]" class="form-control" value="{!!setting('site_title')!!}">
                      </label>
                      <label>
                        Site Title
                        <textarea type="text" name="options[site_description]" class="form-control" rows="3">{!!setting('general_description')!!}</textarea>
                      </label>
                      <label>Site Icon</label>
                      <p>Site Icons are what you see in browser tabs, bookmark bars, and within the WordPress mobile apps. Upload one here!</p>
                      <p>Site Icons should be square and at least 512 × 512 pixels.</p>
                      {!!get_field('image',['value'=>theme_options('site','favicon'),'key'=>'options[site_favicon]'])!!}
                    <?php
                }
              ]
          ]
      ]
    ],
    'menu'=>[
      'title'=>'Menu',
      'title-small'=>'Customizing',
      'description'=>'',
      'ajaxUrl'=>'?getMenuItem=true',
    ],
    'homepage-settings'=>[
      'title'=>'Homepage Settings',
      'title-small'=>'Customizing',
      'fields'=>[
          'system'=>[
              'view'=>[
                  'form'=>function($arg){
                    ?>
                        <p>Bạn có thể chọn những gì được hiển thị trên trang chủ của trang web của bạn. Nó có thể là bài viết theo thứ tự thời gian đảo ngược (blog cổ điển), hoặc một trang cố định / tĩnh. Để thiết lập một trang chủ tĩnh, trước tiên bạn cần tạo hai Trang. Một trang sẽ trở thành trang chủ và trang kia sẽ là nơi bài đăng của bạn được hiển thị.</p>
                        <?php 
                              $homepage_setting = [
                                  'title'=>'Homepage',
                                  'view'=>[
                                      'form'=>function($arg){
                                          return vn4_view(backend_theme('page.setting.input_reading_homepage'),$arg);
                                      }
                                  ]
                              ];
                          ?>
                          <label>Your homepage displays</label>
                          {!!get_field($homepage_setting['view'],['value'=>'','key'=>'homepage_setting'])!!}
                    <?php
                  }
              ]
          ]
      ]
    ],
    'additional-css'=>[
      'title'=>'Additional CSS',
      'title-small'=>'Customizing',
      'description'=>'',
    ],

  ];

   $sectionConfig = do_action('customize_register', function($fiter){

      foreach ($fiter as $k => $v) {
          if( !isset($GLOBALS['sectionConfig'][$k]) ){
            $GLOBALS['sectionConfig'][$k] = $v;
          }else{
            $fields = null;

            if( isset($GLOBALS['sectionConfig'][$k]['fields']) ){
              $fields = $GLOBALS['sectionConfig'][$k]['fields'];
            }

            if( isset($v['fields']) ){
              $fields = array_merge($fields,$v['fields']);
            }

            $GLOBALS['sectionConfig'][$k] = array_merge($GLOBALS['sectionConfig'][$k],$v);

            if( $fields ){
              $GLOBALS['sectionConfig'][$k]['fields']  = $fields;
            }
          }
      }

      return $fiter;

   });
   $sectionConfig = $GLOBALS['sectionConfig'];

   foreach ($sectionConfig as $k => $v) {
     if( !isset($v['title-small']) ) $sectionConfig[$k]['title-small'] = 'Customizing';

     if( isset($v['fields']) ){
      foreach ($v['fields'] as $k2 => $v2) {
          if( !isset($v2['view'])) $sectionConfig[$k]['fields'][$k2]['view'] = 'input';
      }
     }
   }
 ?>
@section('content')

      <style type="text/css">
        .nestable-lists .fa{
          display: none;
        }
      </style>
      <form method="POST" id="form-main">
        <input type="hidden" name="_token" value="{!!csrf_token()!!}">
        <div class="sidenav">

            <div class="sidenav-top">
              <a href="{!!route('admin.page','appearance-theme')!!}">
              <div class="icon"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 512.001 512.001" style="width:11px;enable-background:new 0 0 512.001 512.001" xml:space="preserve"><g><g><path d="M294.111,256.001L504.109,46.003c10.523-10.524,10.523-27.586,0-38.109c-10.524-10.524-27.587-10.524-38.11,0L256,217.892    L46.002,7.894c-10.524-10.524-27.586-10.524-38.109,0s-10.524,27.586,0,38.109l209.998,209.998L7.893,465.999    c-10.524,10.524-10.524,27.586,0,38.109c10.524,10.524,27.586,10.523,38.109,0L256,294.11l209.997,209.998    c10.524,10.524,27.587,10.523,38.11,0c10.523-10.524,10.523-27.586,0-38.109L294.111,256.001z"/></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg></div>
              </a>

              <span class="vn4-btn vn4-btn-blue" id="save-customize" >Published</span>

            </div>

            <div class="sidenav-content">


              <div class="session session-screen-1">
                <div class="warpper-sidenav-header bd-bt">
                  <div class="sidenav-header">
                    <h4 class="title-small">You are customizing</h4>
                    <h2 class="title">{!!setting('general_site_title')!!}</h2>
                    <i class="icon-question"></i>
                  </div>
                  <div class="sidenav-description bd-t">
                      Customizer cho phép bạn xem trước các thay đổi đối với trang web của bạn trước khi xuất bản chúng. Bạn có thể điều hướng đến các trang khác nhau trên trang web của mình trong bản xem trước. Chỉnh sửa phím tắt được hiển thị cho một số yếu tố có thể chỉnh sửa.
                    </div>
                </div>
                

                <div class="sidenav-header mg-bt bd-bt bd-t change-theme">
                  <h4 class="title-small">Active Theme</h4>
                  <h2 class="title-small2">Kymco Theme</h2>
                  <span class="vn4-btn vn4-btn-white btn-change show-session" data-session="theme">Change</span>
                </div>

                 <ul class="nav-session">

                  @foreach($sectionConfig as $k => $s)
                    @if( isset($s['fields']) || isset($s['ajaxUrl']) )
                      <li data-session="{!!$k!!}" class="show-session" @if( isset($s['ajaxUrl']) ) data-ajax="{!!$s['ajaxUrl']!!}" @endif>
                        {!!$s['title']!!}
                     </li>
                    @endif
                  @endforeach
                 </ul>
              </div>
              
              <div class="session session-content session-theme">
                <div class="warpper-sidenav-header bd-bt">
                  <div class="sidenav-header">
                    <div class="icon-back show-session" data-session="screen-1"></div>
                    <h4 class="title-small">You are browsing </h4>
                    <h2 class="title">Themes</h2>
                    <i class="icon-question"></i>
                  </div>
                   <div class="sidenav-description bd-t">
                    <p>Tìm kiếm một chủ đề? Bạn có thể tìm kiếm hoặc duyệt qua thư mục chủ đề vn4cms.com, cài đặt và xem trước các chủ đề, sau đó kích hoạt chúng ngay tại đây.</p>
                    <p>Trong khi xem trước một chủ đề mới, bạn có thể tiếp tục điều chỉnh những thứ như tiện ích và menu và khám phá các tùy chọn dành riêng cho chủ đề.</p>
                  </div>
                </div>
              </div>

              @foreach($sectionConfig as $k1 => $s)
                  @if( isset($s['fields']) || isset($s['ajaxUrl'])  )
                  <div class="session session-content session-{!!$k1!!}">
                    <div class="warpper-sidenav-header bd-bt">
                      <div class="sidenav-header">
                        <div class="icon-back show-session" data-session="screen-1"></div>
                        <h4 class="title-small">{!!$s['title-small']!!}</h4>
                        <h2 class="title">{!!$s['title']!!}</h2>
                        @if( isset($s['description']) && $s['description'] )
                         <i class="icon-question"></i>
                        @endif
                      </div>

                      @if( isset($s['description']) && $s['description'] )
                       <div class="sidenav-description bd-t">
                        {!!$s['description']!!}
                      </div>
                      @endif

                    </div>
                    <div class="pd">
                        @if( !isset($s['ajaxUrl']) )
                           @foreach($s['fields'] as $k2 => $f)
                              @if( isset($f['title']) )
                                <label for="{!!$k2!!}">{!!$f['title']!!}</label>
                              @endif
                              @if( isset($f['note']) )
                                <p>{!!$f['note']!!}</p>
                              @endif
                              {!!get_field($f['view'],['key'=>'options['.$k2.']','value'=>theme_options($k1,$k2)])!!}
                          @endforeach
                        @endif
                    </div>
                  </div>
                @endif
              @endforeach

            </div>
            

            
            <div class="sidenav-footer">
              <div class="hide-control">
                <div class="icon">
                    
                    <div class="icon-warpper">
                      <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 52 52" style="enable-background:new 0 0 52 52;" xml:space="preserve" width="18px" height="18px"> <g> <path d="M26,0C11.663,0,0,11.663,0,26s11.663,26,26,26s26-11.663,26-26S40.337,0,26,0z M26,50C12.767,50,2,39.233,2,26 S12.767,2,26,2s24,10.767,24,24S39.233,50,26,50z" fill="#555d66"/> <polygon points="32,36.783 32,15.438 14.043,25.806 " fill="#eee"/> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> </svg>
                  </div>

                </div> <span>Hide Controls</span>

              </div>
              <div class="icon-device">
                
                <div class="icon-desktop" data-width="100%">
                  <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 385.477 385.477" style="enable-background:new 0 0 385.477 385.477;" xml:space="preserve"> <g> <g id="Desktop_2_"> <g> <path d="M385.477,294.777V22.675H0v272.102h170.064v45.35h-45.35v22.675h136.051v-22.675h-45.35v-45.35H385.477z M22.675,249.427 V45.35h340.127v204.076H22.675z"/> </g> </g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> </svg>
                </div>
                <div class="icon-tablet" data-width="768px">
                  <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 401.991 401.991" style="enable-background:new 0 0 401.991 401.991;" xml:space="preserve"> <g> <path d="M352.029,13.418C343.077,4.471,332.332,0,319.766,0H82.223C69.66,0,58.906,4.471,49.959,13.418 c-8.945,8.949-13.418,19.7-13.418,32.264v310.633c0,12.566,4.473,23.309,13.418,32.261c8.947,8.949,19.701,13.415,32.264,13.415 h237.542c12.566,0,23.312-4.466,32.264-13.415c8.946-8.952,13.422-19.701,13.422-32.261V45.683 C365.451,33.118,360.965,22.364,352.029,13.418z M213.843,378.299c-3.613,3.614-7.898,5.421-12.849,5.421 c-4.952,0-9.233-1.807-12.85-5.421c-3.617-3.62-5.424-7.904-5.424-12.847c0-4.948,1.807-9.239,5.424-12.847 c3.621-3.62,7.902-5.434,12.85-5.434c4.95,0,9.235,1.813,12.849,5.434c3.614,3.607,5.428,7.898,5.428,12.847 C219.271,370.395,217.457,374.676,213.843,378.299z M328.902,319.767c0,2.478-0.91,4.613-2.71,6.427 c-1.813,1.814-3.949,2.711-6.427,2.711H82.223c-2.474,0-4.615-0.904-6.423-2.711s-2.712-3.949-2.712-6.427V45.683 c0-2.475,0.903-4.617,2.712-6.424c1.809-1.809,3.949-2.712,6.423-2.712h237.542c2.478,0,4.613,0.9,6.427,2.712 c1.807,1.807,2.71,3.949,2.71,6.424V319.767z"/> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> </svg>
                </div>
                <div class="icon-mobile" data-width="320px">
                  <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 35 35" style="enable-background:new 0 0 35 35;" xml:space="preserve"> <g> <path d="M25.302,0H9.698c-1.3,0-2.364,1.063-2.364,2.364v30.271C7.334,33.936,8.398,35,9.698,35h15.604 c1.3,0,2.364-1.062,2.364-2.364V2.364C27.666,1.063,26.602,0,25.302,0z M15.004,1.704h4.992c0.158,0,0.286,0.128,0.286,0.287 c0,0.158-0.128,0.286-0.286,0.286h-4.992c-0.158,0-0.286-0.128-0.286-0.286C14.718,1.832,14.846,1.704,15.004,1.704z M17.5,33.818 c-0.653,0-1.182-0.529-1.182-1.183s0.529-1.182,1.182-1.182s1.182,0.528,1.182,1.182S18.153,33.818,17.5,33.818z M26.021,30.625 H8.979V3.749h17.042V30.625z"/> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> </svg>
                </div>
              </div>
              </a>

                
            </div>
      </div>
      </form>

      <div class="main">
          <iframe id="iframe-preview" src="{!!route('index',['iframe'=>'customize'])!!}" frameborder="0" style="background: white;"></iframe>
      </div>
@stop

@section('js')
<script>
    $(window).load(function(event){

        $(window).on("beforeunload", function(e) {
            if (window._formHasChanged) {
                  var message = "Are you sure? You didn't finish the form!", e = e || window.event;
                  if (e) {
                      e.returnValue = message;
                  }

                  var data = $('#form-main').serializeArray();
                  data.push({name:'action',value:'recover'});

                   $.ajax({
                      type: 'POST',
                      dataType: 'Json',
                      data: data,
                      success:function(result){

                      }
                    });

                  return message;
            }
        });

        window.callNavMenu = function(nav){

            var $this = $('.show-session[data-session=menu]');

            if( !$this.hasClass('called-ajax') ){
              $this.addClass('called-ajax');

              vn4_ajax({
                url: $this.data('ajax'),
                type:'POST',
                data: $this.data(),
                callback:function(result){

                  $('.session-'+$this.data('session')+' .pd').html(result.html);

                    $this.closest('.sidenav-content').find('.session').animate({opacity:0},300,function(){
                      $this.closest('.session').hide();
                      $('.session-'+$this.data('session')).css({opacity:9});
                      $('.session-'+$this.data('session')).show();
                      $('.session-'+$this.data('session')).animate({'opacity':1},300);

                      $('.menu-active-for-'+nav).trigger('click');
                    });

                    if( result.script ){
                      eval(result.script);
                    }

                }
              });
            }else{
              $this.closest('.session').animate({opacity:0},300,function(){
                $this.closest('.session').hide();
                $('.session-'+$this.data('session')).css({opacity:9});
                $('.session-'+$this.data('session')).show();
                $('.session-'+$this.data('session')).animate({'opacity':1},300);

                $('.menu-active-for-'+nav).trigger('click');
              });
            }

        };

        $('.icon-device div').click(function(event) {

          if( $(this).hasClass('active') ){
              $('.main iframe').animate({'width':'100%'},300);
              $(this).removeClass('active');
          }else{
              $(this).parent().find('.active').removeClass('active');
              $(this).addClass('active');
              $('.main iframe').animate({'width':$(this).data('width')},300);
          }
        });

        $('.hide-control').click(function(event) {
            $(this).toggleClass('active');

            if( $(this).hasClass('active') ){
              $(this).find('span').hide();
              $('.main').animate({'padding-left':'0'},300);
              $('.sidenav').animate({'left':'-100%'},300);

              $(this).animate({'-ms-transform': 'rotate(180deg)', '-webkit-transform': 'rotate(180deg)','transform': 'rotate(180deg)'},300);

            }else{
              var $this = $(this);
              $('.sidenav').animate({'left':'0'},300,function(){
                  $this.find('span').show();
              });
              $('.main').animate({'padding-left':'300px'},300);

              $(this).animate({'-ms-transform': 'rotate(0deg)', '-webkit-transform': 'rotate(0deg)','transform': 'rotate(0deg)'},300);

            }
        });

        $(document).on('click','.show-session',function(event) {
            var $this = $(this);

            if( $this.data('ajax') && !$this.hasClass('called-ajax') ){
              $this.addClass('called-ajax');

              vn4_ajax({
                url: $this.data('ajax'),
                type:'POST',
                data: $this.data(),
                callback:function(result){

                  $('.session-'+$this.data('session')+' .pd').html(result.html);

                  $this.closest('.session').animate({opacity:0},300,function(){
                      $this.closest('.session').hide();
                      $('.session-'+$this.data('session')).css({opacity:9});
                      $('.session-'+$this.data('session')).show();
                      $('.session-'+$this.data('session')).animate({'opacity':1},300);
                  });

                  if( result.script ){
                    eval(result.script);
                  }

                }
              });
            }else{
              $this.closest('.session').animate({opacity:0},300,function(){
                  $this.closest('.session').hide();
                  $('.session-'+$this.data('session')).css({opacity:9});
                  $('.session-'+$this.data('session')).show();
                  $('.session-'+$this.data('session')).animate({'opacity':1},300);
              });
            }
        });

        $('.sidenav-header .icon-question').click(function(event) {
            $(this).toggleClass('active');
            $(this).closest('.session').find('.sidenav-description').slideToggle(300);
        });

        $('.btn-preview').click(function(event) {
          document.getElementById('iframe-preview').contentWindow.location.reload(true);
        });
        
        $(document).on('click', '#save-customize', function(event) {
          if( $(this).hasClass('disable') ){
            alert('Bạn đã click button này rồi.');
            return;
          }
          $(this).css({'opacity':'.5'});
          $(this).addClass('disable');
          var $this = $(this);
          event.preventDefault();
          var data = $('#form-main').serializeArray();
            data.push({name:'action',value:'save-customize'});

            $.ajax({
              type: 'POST',
              dataType: 'Json',
              data: data,
              success:function(data){
                if(data.success){
                  $this.css({'opacity':'1'});
                  window._formHasChanged = false;
                  $this.removeClass('disable');
                }
              }
            })
            .done(function() {
            })
            .fail(function() {
            })
            .always(function() {
            });

        });
        $(document).on('change','form',function(){
            window._formHasChanged  = true;

            var data = $('#form-main').serializeArray();
            data.push({name:'action',value:'preview'});
            $.ajax({
              type: 'POST',
              dataType: 'Json',
              data: data,
              success:function(data){
                if(data.success){
                  document.getElementById('iframe-preview').contentWindow.location.reload(true);
                }
              }
            })
            .done(function() {
            })
            .fail(function() {
            })
            .always(function() {
            });

        });
    });
</script>


<script src="{!!asset('admin/js/jquery.nestable.js')!!}"></script>
    <script>
      $(document).ready(function() {

          // Click select all
          $('.content-li-object').on( 'click', 'a.select-all', function(event) {
             event.preventDefault();
             event.stopPropagation();
             $(this).closest('.content-li-object').find('input[type="checkbox"]').prop({checked:true});
          });

          // Load object
        function load_data_to_li_object($this, data){

          $this.addClass('have_data');
          $this.removeClass('loading');
          $this.find('.fa:first').removeClass('fa-spin');

          var data_object = $this.attr('object-type');
          var ul = $this.find('.content-li-object .row_object:first');

          for(i = 0; i < data.result.length; i ++){
            ul.append('<li class=""><label><input type="checkbox" class="check_obj" name="'+data_object+'[]" value="'+data.result[i].id+'"> '+data.result[i].title+'</label></li>');
          }

          if(data.result.length < 1){
            ul.append('<li class="no_item"><p><i>@__('no data available')</i></p></li>');
          }else{
            $this.find('.content-li-object').append('<p class="button-controls"><span class="list-controls"><a href="#" class="select-all">@__('Select All')</a></span><span class="add-to-menu"><button type="submit" class="button-secondary vn4-btn submit-add-to-menu right" object-type="'+data_object+'" name="add-post-type-menu-item">@__('Add to Menu')</button><span class="spinner"></span></span></p>')
          }

          $this.addClass('active');
          $this.find('.fa:first').addClass('over_fa');
          $this.find('.content-li-object').slideDown(200);
        };

          //click load object
        $('.list_object .li_object').click(function(event) {

          var $this = $(this);

          var object_type = $this.attr('object-type');

          $('.list_object .li_object.active .content-li-object').slideUp(200,function(){
            $(this).closest('.li_object').removeClass('active');
          });


          if($this.hasClass('active')){

            $this.find('.content-li-object').slideUp(200,function(){
              $this.removeClass('active');
            });
            $this.find('.fa:first').addClass('out_fa');
            window.setTimeout( function () { $this.find('.fa:first').removeClass('out_fa'); }, 550 );

          }else{
            if(!$(this).hasClass('have_data')){
              $this.addClass('loading');
              $this.find('.fa:first').addClass('fa-spin');

              if( !$(this).hasClass('not-object') ){

                vn4_ajax({

                  data:{
                    object_type:object_type,
                    type:'get object data'
                  },
                  callback:function(data){


                  <?php  $do_action_load_menu = do_action('js_load_item_menu'); ?>
                   
                    load_data_to_li_object($this,data);
                  }

                });
                
              }else{
                $this.removeClass('loading');
                $this.find('.fa:first').removeClass('fa-spin');
                $this.addClass('active');
                $this.find('.fa:first').addClass('over_fa');
                $this.find('.content-li-object').slideDown(200);
              }

            }else{

              $this.addClass('active');
              $this.find('.content-li-object').slideDown(200);
            }

          }

        });
          
        $('.content-li-object').click(function(event) {
           event.stopPropagation();
        });

        $('body').on('click', '.dd-item .fa', function(event) {
           event.preventDefault();
           event.stopPropagation();
           $(this).closest('.dd-item').find('.menu_item_info:first').slideToggle('fast');
        });

          $('body').on('change','.input-nav-label',function(event){

             $value = $(this).val();

             if( !$value ) $value = '(no label)';

             $(this).closest('.dd-item').attr('data-label',$value);
             $(this).closest('.dd-item').find('.dd-handle:first').text($value);
             $(this).attr('value',$value);
          });

          //select menu to edit
          $('#submit_selected_menu_edit').click(function(event) {
             if($('#selected_menu_edit').val()){
                window.location.href = replaceUrlParam(window.location.href,'id',$('#selected_menu_edit').val());
             }
          });

          // Clear menu - not save
          $('#clear_menu').click(function(event) {
             event.preventDefault();
             event.stopPropagation();
             $('.dd-list').empty();
          });



          // Change input link of custome links
          $('body').on('change','.input-links',function(event){
             $(this).closest('.dd-item').attr('data-links',$(this).val());
             $(this).attr('value',$(this).val());
          });

          // nestable
          window.updateOutput = function(e) {
            var list = e.length ? e : $(e.target),
            output = list.data('output');

            if (window.JSON) {
              output.val(window.JSON.stringify(list.nestable('serialize'))); //, null, 2));

              var content = window.JSON.stringify(list.nestable('serialize'));
              var id = output.closest('.pd').find('.menu-id').val();

              vn4_ajax({

                data:{
                  'content':content,
                  'id':id,
                  'action':'save-menu'
                },
                callback:function(result){
                  window._formHasChanged = true;
                  document.getElementById('iframe-preview').contentWindow.location.reload(true);
                }

              })


             } else {
                output.val('JSON browser support required for this demo.');
             }


          };

        // activate Nestable for list 1
        $('#nestable').nestable({
          group: 1,
          maxDepth: 5,
          expandBtnHTML:'',
          collapseBtnHTML:'',
        });

        // output initial serialised data
        $(document).on('click', '#nestable-menu', function(e) {
          var target = $(e.target),
          action = target.data('action');
          if (action === 'expand-all') {
            $('.dd').nestable('expandAll');
          }
          if (action === 'collapse-all') {
            $('.dd').nestable('collapseAll');
          }
        });

          $(document).on('click','.btn-remove', function(event) {
             event.preventDefault();
             event.stopPropagation();
             $(this).closest('.dd-item').find('.dd-handle').css({background: '#de0000',color: 'white'});
             $(this).closest('.dd-item').find('i.fa').css({color: 'white'});
             $(this).closest('.dd-item').find('.menu_type').css({color: 'white'});

             $(this).closest('.menu_item_info').slideUp('fast',function(){
                $(this).closest('.dd-item').remove();
             });
          });

          $(document).on('click', '.btn-cancel', function(event) {
             event.preventDefault();
             event.stopPropagation();
             $(this).closest('.menu_item_info').slideUp('fast');

          });

        $('.submit-add-custom-links').click(function(event) {

          var url = $('#url_custom_links').val();
          var linkText = $('#link_text_custom_links').val();
          var selector = '.dd-list:first';

          if(linkText){

            vn4_ajax({
              data:{
                links:url,
                label:linkText,
                selector:selector,
                      key:'custom links',
                type:'add menu item'
              }
            });
            
          }
          
        });

          $('body').on('change', '.change-data-menu', function(event) {
               $(this).closest('.dd-item').attr('data-'+$(this).attr('data-trigger'),$(this).val());
          });

          $('body').on('click', 'input[type=checkbox]', function(event) {
             if( $(this).prop('checked') ){
               $(this).closest('.dd-item').attr('data-'+$(this).attr('data-trigger'),$(this).val());
             }else{
               $(this).closest('.dd-item').attr('data-'+$(this).attr('data-trigger'),'');
             }
          });

          $('.content-li-object').on('click', '.submit-add-to-menu', function(event) {

             event.preventDefault();
             var key = $(this).attr('object-type');

             var list_object = $(this).closest('.content-li-object').find( ".check_obj[name='"+key+"[]']:checked" ).map(function(index, el) {
                return $(el).val();
             }).get();

             var selector = '.dd-list:first';
             vn4_ajax({

                data:{
                   list_object:list_object,
                   selector:selector,
                   key:key,
                   type:'add menu item'
                }

             });

          });


          //Ajax create new menu
          $('body').on('click', '#create_new_menu', function(event) {
            event.preventDefault();

            if( $('#input_name_menu_new').val() === '' ){
              $('#input_name_menu_new').css({border:'1px solid red'});
              return;
            }else{
              $('#input_name_menu_new').css({border:'1px solid #ccc'});

                vn4_ajax({

                    data:{

                      'name':$('#input_name_menu_new').val(),
                      'create_new_menu':true,
                    }
                });
            }
          });

          $(document).on('click','save-menu',function(){
            updateOutput($('#nestable').data('output', $('#nestable-output')));
          });
        

      });
    </script>
@stop