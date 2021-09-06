<?php 
    header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    

    $time_login = Vn4Model::firstOrAddnew(vn4_tbpf().'login_time',['ip'=>Request::ip()]);

    $limit_login_count =  setting('security_limit_login_count',false);

    $signin_with_google_account = setting('security_active_signin_with_google_account');

    $limit_login = ( $time_login->time > time()?$time_login->time - time() : false ) && $limit_login_count &&  $time_login->count >= $limit_login_count;

 ?>
@if( $limit_login )
  @include(backend_theme('particle.login-limit-countdown'))
@else
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{!!setting('admin_cms_title','Quản trị admin')!!} | Login</title>

    <link rel="icon" href="{!!asset('admin/favicon.ico')!!}">
    <!-- Bootstrap -->
    <link href="{!!asset('admin/css/bootstrap.min.css')!!}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{!!asset('admin/css/font-awesome.min.css')!!}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{!!asset('admin/css/nprogress.css')!!}" rel="stylesheet">
    <!-- Animate.css -->
    <link href="{!!asset('admin/css/animate.min.css')!!}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{!!asset('admin/css/custom.min.css')!!}" rel="stylesheet">
    <style>
      .session-message .session-message-icon-close{
        display: none;
      }
      .registration_form, .login_form{
          padding: 0px 60px;
          margin: 0;
          width: 536px;
          max-width: 100%;
          position: initial;
          top: auto;
      }
      .login_content h1{
        position: relative;
      }
      .countdown {
          position: relative;
          float: left;
      }
      label{
          width: 100%;
          display: block;
          margin: 14px 0 4px;
          color: white;
          text-align: left;
          line-height: 30px;
          font-size: 17px;
          text-shadow: none;
      }
      .countdown h2 {
          text-align:center;
          position: absolute;
          line-height: 125px;
          width: 100%;
      }
      .image-prefix{
        width: 70%;
        min-height: 100vh;
        align-items: center;
        justify-content: center;
        display: flex;
        background: {!!setting('admin_template_color-left','#582979')!!};
        color: white;
      }
      .login_wrapper{
        max-width: inherit;
        align-items: center;
        justify-content: center;
        display: flex;
        min-height: 100vh;
        width: 600px;
        background: {!!setting('admin_template_color-right','#394959')!!};
        color: white;
      }
      @media (max-width: 768px){
        .image-prefix{
            width: 0%;
        }
        .login_wrapper{
            width: 100%;
        }
      }
      svg {
         -webkit-transform: rotate(-90deg);
          transform: rotate(-90deg);
      }
      .login{
        min-height: 100vh;
        background: white;
      }
      .circle_animation {
        stroke-dasharray: 440; /* this value is the pixel circumference of the circle */
        stroke-dashoffset: 440;
        transition: all 1s linear;
      }
     
      .login_content input[type="text"], .login_content input[type="email"], .login_content input[type="password"]{
          width: 100%;
          margin-right: 8px;
          border: 1px solid transparent;
          font-size: 16px;
          font-weight: 400;
          line-height: 24px;
          width: 100%;
          -webkit-box-sizing: border-box;
          box-sizing: border-box;
          height: 40px;
          padding: 10px 16px;
          outline: none;
          border-radius: 8px;
          -webkit-transition: background-color 200ms ease, outline 200ms ease, color 200ms ease, -webkit-box-shadow 200ms ease;
          transition: background-color 200ms ease, outline 200ms ease, color 200ms ease, -webkit-box-shadow 200ms ease;
          transition: background-color 200ms ease, outline 200ms ease, color 200ms ease, box-shadow 200ms ease;
          transition: background-color 200ms ease, outline 200ms ease, color 200ms ease, box-shadow 200ms ease, -webkit-box-shadow 200ms ease;
          -webkit-appearance: none;
          -moz-appearance: none;
          appearance: none;
          color: #0d0c22;
          background-color: #f3f3f4;
          box-shadow: none;
      }
      .or_login_p{
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 20px;
        position: relative;
      }

      .or_login_p:before{
        content: "";
        display: inline-block;
        width: 100%;
        height: 1px;
        position: absolute;
        background: white;
        z-index: 1;
      }
      .or_login_p span{
          background: #394959;
          z-index: 10;
          padding: 0 10px;
      }
      
    </style>
    <?php 
        do_action('vn4_head');

        $active_capcha = false;

        if( setting('security_active_recapcha_google') === '["active"]' && setting('security_recaptcha_sitekey') && setting('security_recaptcha_secret') ){

          $active_capcha = true;
          
        }

     ?>
  </head>

  <body class="login">
      
      <div style="display: flex;">
        <div class="image-prefix">
          <div style="padding: 20px;text-align: center;">

              <p style="max-width:430px;margin: 0 auto;font-size: 77px;line-height: 77px;font-weight: bold;text-align: left;text-shadow: 7px 7px 9px rgba(0, 0, 0, 0.5);">{!!setting( 'admin_template_logan', 'do <br> something<br><span style="color:#18b797;font-size: 85px;">you love</span><br> today')!!}</p>

          </div>
        </div>
        <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content" style="margin: 0;width: 100%;">
              <input type="text" value='{!!csrf_token()!!}' name='_token' hidden>


              @if( $img = get_media(setting('admin_template_logo')) )
              <div><img style="max-height: 140px;box-shadow:none;" src="{!!$img!!}" /></div>
              <br>
              @endif


              <h2 style="margin-top: 20px; text-align: left;font-weight: bold;font-size: 24px;text-shadow: none;">{!!setting('admin_template_headline-right',__('Sign in to Backend'))!!}</h2>
              <h4>{!!isset($message)?$message:''!!}</h4>

             
               @if( $signin_with_google_account === '["active"]' )
               <br>
              <div id="googleSignIn" style="display: inline-flex;align-items: center;justify-content: center;background: #f3f3f4;color: #333;text-transform: capitalize;width: 100%;height: 40px;line-height: 40px;padding: 0 20px;font-size: 18px;border-radius: 4px;cursor: pointer;">
                <img src="https://cfdtraining.vn/themes/cfd-training/img/google-icon.png" style="margin-right: 10px;margin-left: 0;box-shadow: none;">
                Google
              </div>

                <div class="or_login_p">
                <span>OR</span>
              </div>
              @endif

              <div id="divUsername">
                <label style="width: 100%;">
                  Username
                <input type="text" class="form-control" name='username' id="username" required="" />
                </label>
              </div>
              <div id="divPassword">
                <label style="width: 100%;">
                  Password
                  <input type="password" class="form-control" name='password' id="password" required="" />
                </label>
              </div>

              <div id="divGoogle_authenticator" style="margin-bottom: 20px;display:none;">
                <label style="width: 100%;"> Authentication Code
                <input type="number" class="form-control" placeholder="Google Authenticator" name='google_authenticator' id="google_authenticator" required="" />
                </label>
                <p style="margin-top:5px;">@__('The account has 2-layer security enabled, please enter the code on your google authenticator app previously saved.')</p>
              </div>


             <div id="divRememberme" style="text-align: left;">
                <label><input type="checkbox" name="rememberme" id="rememberme" value="true">Remember me</label>
              </div>
              <br>
                
              
                @if($active_capcha)
                <div class="recaptcha-login" id="recaptcha-login"></div>
                <br>
                @endif

               <?php 
                do_action('login');
               ?>
              <div style="text-align: left;margin-bottom: 20px;">
               <button type="submit" id="login_btn" class="vn4-btn" style="border: none;height: 40px;font-size: 18px;width: 100%;">@__t('Sign in')</button>
              </div>

              @if( Request::has('copyright') )
              <h2 style="margin-top: 0; text-align: left;font-weight: bold;font-size: 12px;text-shadow: none;bottom: 0;right: 15px;position: fixed;font-style: italic;">{!!__('Code by Vn4CMS')!!}</h2>
              @endif

          </section>



        </div>
      </div>
      </div>

    <?php $session = session()->pull('message', false); ?>
    
    @if( $session )

      @include(backend_theme('particle.session_message'),['session'=>$session])

    @endif
    
    <div class="popup-loadding"><p class="content"><i class="fa fa-spinner fa-spin icon"></i>...@__('Checking login information')...</p></div>

    <script src="{!!asset('')!!}vendors/jquery/jquery.min.js?v=1"></script>


    <script>

     @if( $signin_with_google_account === '["active"]' )
       function onLoadGoogleCallback(){
        gapi.load('auth2', function() {
          auth2 = gapi.auth2.init({
            client_id: '{!!setting('security_google_oauth_client_id')!!}',
            cookiepolicy: 'single_host_origin',
            scope: 'email'
          });

        auth2.attachClickHandler(element, {},
          function(googleUser) {
              handleEmailResponse(googleUser.getAuthResponse().access_token);
              // console.log(googleUser.getAuthResponse().access_token);
              // console.log('Signed in: ' + googleUser.getBasicProfile().getEmail());
            }, function(error) {
                alert('Sign-in error:' + error.error);
            }
          );
        });

        element = document.getElementById('googleSignIn');
      }


      /**
       * Response callback for when the API client receives a response.
       *
       * @param resp The API response object with the user email and profile information.
       */
      function handleEmailResponse(resp) {
        

        $.ajax({
          url: '{!!route('login')!!}',
          type: 'POST',
          dataType: 'json',
          data: {
            _token: '{!!csrf_token()!!}',
            access_token: resp,
            login_by_google_rq:true,
            rememberme:$('#rememberme').prop('checked'),
            },
          success:function(data){
              if(data.message){
                alert(data.message);
              }

              if(data.url){
                window.location.href = data.url;
                return true;
              }
          }
        });

      }

      @endif

      $(window).on('load',function() {

          @if( $active_capcha )
          setTimeout(function() {

            var url = "https://www.google.com/recaptcha/api.js";
            $.ajax({
              url: url,
              dataType: "script",
              success: function(){

                  setTimeout(function() {

                    window.capcha_login = grecaptcha.render('recaptcha-login', {
                      'sitekey': '{!!setting('security_recaptcha_sitekey')!!}',
                    });

                  }, 1000);
                
               
              }
            });

          });
          @endif
          
             $(document).on('click','#login_btn',function(event) {
                event.preventDefault();

                @if( $active_capcha )
                if(  grecaptcha.getResponse(window.capcha_login) ){
                @endif

                  $('.popup-loadding').show();
                  $.ajax({
                    url: '{!!route('login')!!}',
                    type: 'POST',
                    dataType: 'Json',
                    data: {
                      _token:'{!!csrf_token()!!}',
                      username: $('#username').val(),
                      @if( Request::has('rel') )
                      rel: '{!!Request::get('rel')!!}',
                      @endif
                      password:$('#password').val(),
                      rememberme:$('#rememberme').prop('checked'),
                      google_authenticator:$('#google_authenticator').val(),
                      @if($active_capcha) 
                      'g-recaptcha-response':grecaptcha.getResponse(window.capcha_login)
                      @endif
                    },
                    success:function(data){
                      $('.popup-loadding').hide();

                      if( data.active_google_authenticator ){
                        $('#divUsername').hide();
                        $('#divPassword').hide();
                        $('#divRememberme').hide();
                        $('#divGoogle_authenticator').show();
                      }
                      
                      if(data.message){
                        alert(data.message);
                      }

                      if(data.url){
                        window.location.href = data.url;
                        return true;
                      }

                      
                      @if($active_capcha) 
                      grecaptcha.reset(window.capcha_login);
                      @endif
                    }
                  }).fail(function() {
                    alert(data.message);
                  });
                

                @if($active_capcha) 
                }else{
                  alert('{!!__('Please confirm you are not a robot before submit')!!}');
                }
                @endif


              });

          @if( $signin_with_google_account === '["active"]' )
          let script = document.createElement('script');
          script.src = 'https://apis.google.com/js/platform.js?onload=onLoadGoogleCallback';
          document.head.appendChild(script);
          @endif
        });
    </script>
    <?php 
        do_action('vn4_footer');
     ?>
  </body>
</html>
@endif