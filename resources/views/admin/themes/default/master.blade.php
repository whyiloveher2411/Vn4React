<!DOCTYPE html>

<html lang="{!!App::getLocale()!!}">

  <head>

    <script>

      window.startTime = (new Date).getTime();

    </script>

    <link rel="icon" href="{!!asset('admin/favicon.ico')!!}">



    <?php

    $user = Auth::user();



    $mode =  $user->getMeta('admin_mode',['light-mode','Light Mode']);



    $class_body = $user->getMeta('collapse',false)?'collapse-body':'nav-md';



    do_action('admin_after_open_head'); 



    $isFrame = Request::has('iframe');



    ?>

    @if( isset($mode[0]) && $mode[0] === 'dark-mode')
    <style type="text/css" id="style-darkmode-default">
      *{
        background: rgb(24, 26, 27) !important;
        border-color:rgb(48, 52, 54) !important;
      }
      svg *{
        fill: transparent !important;
      }
    </style>
    @endif

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    

    <title>{!!strip_tags(vn4_one_or(do_action('title_head'),'Quản trị admin')),' &lsaquo; ',setting('general_site_title','Site title')!!}</title>



     <link href="@asset(vendors/bootstrap/css/bootstrap.min.css)" rel="stylesheet">

     <link href="@asset(admin/css/custom.min.css)" rel="stylesheet">

     <link href="@asset(admin/css/default.css)" rel="stylesheet">

     <link rel="stylesheet" type="text/css" href="{!!asset('admin/css/mode/'.$mode[0].'.css')!!}">

      <meta name="domain" content="{!!url('/')!!}">

      <meta name="url_create_thumbnail" content="{!!route('admin.controller',['controller'=>'image','method'=>'filemanager-create-thumbnail'])!!}">

      <meta class="load-more" data-type="js" content="{!!route('admin.controller',['controller'=>'javascript','method'=>'load-more'])!!}">

      <meta name="url_filemanagerUploadFileDirect" content="{!!route('admin.controller',array_merge(['controller'=>'image','method'=>'filemanager-upload-file-direct'],Route::current()->parameters()))!!}">

      <link href="@asset()vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet"><link href="{!!asset('admin/css/nav-top-login.css')!!}" rel="stylesheet">



    <?php 

       do_action('vn4_head');

     ?>

    @yield('css')



  </head>



  <body class="custom_scroll {!!$class_body!!} @yield('body-class') {!!$isFrame?'is-iframe':''!!} ">



    <input type="text" id="laravel-token" value="{!!csrf_token()!!}" hidden>

    <input type="text" id="text-download" value="{{__('Download')}}" hidden>

    <input type="text" id="text-edit" value="{{__('Edit')}}" hidden>

    <input type="text" id="text-remove" value="{{__('Remove')}}" hidden>



    <input type="text" id="is_link_admin_vn4_cms" value="true" hidden>



    @if( !$isFrame )

      @include( 'admin.nav-top' )

     @endif

    

    @yield('input-info')

    

    <div class="container body">

      <div class="main_container">



          @if( !$isFrame )

            <div class="left_col">

              @include(backend_theme('particle.sidebar',['class_body'=>$class_body]))

            </div>

           @endif



          <div class="right_col"  role="main">



          @if( !$isFrame )

            @include(backend_theme('particle.conduct'))

            <div >

              <h1 class="title title-master"><span class="pull-left"> <?php do_action('vn4_heading_before') ?> {!!title_head()!!}&nbsp;</span> <?php do_action('vn4_heading') ?></h1>

              <div class="clearfix"></div>

            </div>

          @endif

          

          <?php do_action('admin.master'); ?>



          @yield('content')

          

          <div class="clearfix"></div>

          </div>



        </div>

        @include(backend_theme('particle.footer'))

    </div>



    <?php $session = session()->pull('message', false); ?>

      

    <div class="message-warper">

    @if( $session )

      @include(backend_theme('particle.session_message'),['session'=>$session])

    @endif

    </div>



    <div class="popup-loadding">

        

        <div class="content-warper">

            <img data-src="{!!asset('/admin/images/image-loading-data-1.svg')!!}">

            <p class="content">

              .... <span>@__('Loading')</span> ...

            </p>

        </div>

    </div>



    <div class="vn4-message">

        <span class="hide_message"><i class="fa fa-times" aria-hidden="true"></i></span>

      <h4></h4>

    </div>



    <div class="popup-fixed">

        <div class="popup-warper">

            <div class="popup-header">

              <a href="#" class="a-poupup-title">

                <span class="popup-title"></span>

              </a>

               <span class="icon-close"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/><path d="M0 0h24v24H0z" fill="none"/></svg></span>



            </div>

            <div class="popup-content" style="margin-right: 40px;padding-right: 0;overflow:hidden;">

               

            </div>

            <div class="popup-footer">

                <span class="vn4-btn">Cancel</span>

                <span class="vn4-btn vn4-btn-blue">Create</span>

            </div>

        </div>

    </div>

    

    <div class="dropup helper-link">

      <a class="dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-expanded="true">

        <i class="fa fa-question-circle" aria-hidden="true"></i>

      </a>



      <?php 

        $links = [

          ['title'=>__('Shortcuts'),'link'=>route('admin.page','help'),'popup'=>true],

          ['title'=>__('Document'),'link'=>'https://vn4cms.com/vi/document/gioi-thieu-vn4cms'],

          ['title'=>__('Contact'),'link'=>'https://vn4cms.com/vi/page/lien-he-2'],

        ];



        $links = apply_filter('links_helper',$links);

       ?>

      <ul class="dropdown-menu dropdown-menu-right" role="menu" data-type="page">



        @foreach($links as $link)



        @if( isset($link['popup']) && $link['popup'] )

        <li><a data-popup="1" data-title="{!!$link['title']!!}" data-iframe="{!!$link['link']!!}"><label>{!!$link['title']!!}</label></a></li>

        @else

        <li><a target="_blank" href="{!!$link['link']!!}"><label>{!!$link['title']!!}</label></a></li>

        @endif

        @endforeach

      </ul>

    </div>

    <script src="@asset()vendors/jquery/jquery.min.js?v=1"></script>

    <script src="@asset()vendors/bootstrap/js/bootstrap.min.js?v=1"></script>

    <script src="@asset()admin/js/main.js?v=1"></script>

    <?php do_action('vn4_footer'); ?>



    @yield('js')
    
    @if( isset($mode[0]) && $mode[0] === 'dark-mode')

    <script src="@asset()admin/js/darkreader.js"></script>
    <script>
      $(window).load(function(){
        if ($(".darkreader")[0]){
             console.log("Darkreader Extension detected");
        } else {
            setTimeout(function() {
               DarkReader.setFetchMethod('GET');
               DarkReader.enable({
                  brightness: 100,
                  contrast: 100,
                  sepia: 0
               });

               $('#style-darkmode-default').remove();
             }, 10);
        }
      });
    </script>
    @endif
    
  </body>

</html>