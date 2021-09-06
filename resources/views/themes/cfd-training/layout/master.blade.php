<!DOCTYPE html>
<html {!!get_language_attributes()!!} >
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<meta name="google-signin-client_id" content="360363510993-2er3n3bbpvqke21a01tvasbue9mjcar8.apps.googleusercontent.com">

	@head
	<style type="text/css">
		@font-face {
		  font-family: "ab";
		  src: url("@theme_asset()fonts/SVN-Avobold.woff2") format("woff2"), url("@theme_asset()fonts/SVN-Avobold.woff") format("woff");
		  font-weight: bold;
		  font-style: normal;
		  font-display: fallback;
		}

		@font-face {
		  font-family: "Main";
		  src: url("@theme_asset()fonts/SVN-Avoitalic.woff2") format("woff2"), url("@theme_asset()fonts/SVN-Avoitalic.woff") format("woff");
		  font-weight: normal;
		  font-style: italic;
		  font-display: fallback;
		}

		@font-face {
		  font-family: "main";
		  src: url("@theme_asset()fonts/SVN-Avo.woff2") format("woff2"), url("@theme_asset()fonts/SVN-Avo.woff") format("woff");
		  font-weight: normal;
		  font-style: normal;
		  font-display: fallback;
		}

		@font-face {
		  font-family: "Main";
		  src: url("@theme_asset()fonts/SVN-Avobolditalic.woff2") format("woff2"), url("@theme_asset()fonts/SVN-Avobolditalic.woff") format("woff");
		  font-weight: bold;
		  font-style: italic;
		  font-display: fallback;
		}
    </style>
	<link rel="stylesheet" href="@theme_asset()dest/style.min.css?v=2">
	@yield('css')

</head>
<body {!!get_body_class()!!}>
	@header

	@yield('content')

	@footer

	<div class="popup-form popup-login" data-id="login" style="display: none;">
        <div class="wrap">
            <!-- login-form -->
            <form id="popup-login" >
	            <div class="ct_login" >
	                <h2 class="title">Đăng nhập</h2>
	                <input type="hidden" class="url_post" value="{!!route('post',['controller'=>'account','method'=>'login'])!!}">
					<input name="email" type="text" placeholder="Email / Số điện thoại">
					<input name="password" type="password" placeholder="Mật khẩu">
					<p class="mess-error" id="message_login"></p>
	                <div class="remember">
	                    <label class="btn-remember">
	                        <div>
	                            <input type="checkbox">
	                        </div>
	                        <p>Nhớ mật khẩu</p>
	                    </label>
	                    <a href="#" class="forget btn-open-popup" data-id="reset-password">Quên mật khẩu?</a>
	                </div>
	                <div class="btn rect main btn-login">đăng nhập</div>
	                <div class="text-register" style="">
	                    <strong>hoặc đăng nhập bằng</strong>
	                </div>
	                <div>
	                    <div class="btn btn-icon rect white btn-google" id="googleSignIn">
	                        <img src="@theme_asset()img/google.svg" alt="">
	                        Google
	                    </div>

						<p class="mess-error" id="message_login_by_g"></p>

	                </div>
	                <div class="close">
	                    <img src="@theme_asset()img/close-icon.png" alt="">

	                </div>
	            </div>
            </form>
            
        </div>
    </div>

    <div class="popup-form popup-login" data-id="reset-password" style="display: none;">
        <div class="wrap">
            <form id="popup-datlaimatkhau">
            	<input type="hidden" class="url_post" value="{!!route('post',['controller'=>'account','method'=>'reset-password'])!!}">
	            <div class="ct_email">
	                <h2 class="title">Đặt lại mật khẩu</h2>
	                <input type="text" name="email" placeholder="Email">
					<p class="mess-error" id="message_reset_password"></p>
	                <div class="btn rect main btn-next" id="datlaimatkhau">Tiếp theo</div>
	                <div class="back btn-open-popup" data-id="login" ></div>
	                <div class="close">
	                    <img src="@theme_asset()img/close-icon.png" alt="">
	                </div>
	            </div>
            </form>
        </div>
    </div>

     <div class="popup-video popup-loading" id="popuploading" data-id="loading" style="display: none;z-index: 9999;">
        <div class="loader">
            <h2 class="title">Tiến trình đăng ký đang diễn ra</h2>
            <div class="icon_loader"><img src="@theme_asset()img/loader.svg" alt=""></div>
        </div>
    </div>

    <div class="popup-form popup-login"  data-id="register" style="display: none;">
        <div class="wrap">
            <h2 class="title">Đăng ký</h2>
            <div class="btn btn-icon rect white btn-google" id="googleSignIn2">
                <img src="@theme_asset()img/google.svg" alt="">
                Google
            </div>
			<p class="mess-error" id="message_register"></p>
            <p class="policy">
                Bằng việc đăng kí, bạn đã đồng ý <a href="{!!route('page','dieu-khoan')!!}">Điều khoản bảo mật</a> của CFD
            </p>
            <div class="close">
                <img src="@theme_asset()img/close-icon.png" alt="">
            </div>
        </div>
    </div>


	<script src="@theme_asset()dest/jsmain.min.js"></script>
    <script src="@theme_asset()js/main.js"></script>
    
 	@yield('js')

	 <script>

	 	function loading($message, $callback = null){
	 		if( $message ){
	 			$('.popup-loading .title').text($message);
	 			$('.popup-loading').show();
	 		}else{
	 			$('.popup-loading').hide();
	 		}

	 		if( $callback ){
	 			$callback();
	 		}
	 	}

	 	 function onLoadGoogleCallback(){
		    gapi.load('auth2', function() {
		      auth2 = gapi.auth2.init({
		        client_id: '360363510993-2er3n3bbpvqke21a01tvasbue9mjcar8.apps.googleusercontent.com',
		        cookiepolicy: 'single_host_origin',
		        scope: 'email'
		      });

		    auth2.attachClickHandler(element, {},
		      function(googleUser) {
		          handleEmailResponse(googleUser.getAuthResponse().access_token);
		          // console.log(googleUser.getAuthResponse().access_token);
		          // console.log('Signed in: ' + googleUser.getBasicProfile().getEmail());
		        }, function(error) {
		          // alert('Sign-in error:' + error);
		        }
		      );
		    });

		    gapi.load('auth2', function() {
		      auth2 = gapi.auth2.init({
		        client_id: '360363510993-2er3n3bbpvqke21a01tvasbue9mjcar8.apps.googleusercontent.com',
		        cookiepolicy: 'single_host_origin',
		        scope: 'email'
		      });

		    auth2.attachClickHandler(element2, {},
		      function(googleUser) {
		          handleEmailResponse(googleUser.getAuthResponse().access_token, true);
		          // console.log(googleUser.getAuthResponse().access_token);
		          // console.log('Signed in: ' + googleUser.getBasicProfile().getEmail());
		        }, function(error) {
		          // alert('Sign-in error:' + error);
		        }
		      );
		    });

		    element = document.getElementById('googleSignIn');
		    element2 = document.getElementById('googleSignIn2');
		  }

		  $('.btn-open-popup').on('click', function () {

		        $('.popup-login').fadeOut(200);

		        $('.popup-login[data-id="'+$(this).data('id')+'"]').fadeIn(200);
		    })



		  /**
		   * Response callback for when the API client receives a response.
		   *
		   * @param resp The API response object with the user email and profile information.
		   */
		  function handleEmailResponse(resp, is_register = false) {
		    
		    if( is_register ){
		    	$.ajax({
			      url: '{!!route('post',['account','register-by-google'])!!}',
			      type: 'POST',
			      dataType: 'json',
			      data: {
			          @if( request()->has('rel') )
			          rel: '{!!Input::get('rel')!!}',
			          @endif
			        _token: '{!!csrf_token()!!}',
			        access_token: resp
			        },
			      success:function(result){
		          	if( result.message ){
		          		$('#message_register').text(result.message);
					}else{
		          		$('#message_register').text('');
					}
					if( result.redirect ){
						window.location.href = result.redirect;
					}
					if( result.reload ){
						window.location.reload(result.reload);
					}
			      }
			    });
		    }else{
			    $.ajax({
			      url: '{!!route('post',['account','login-by-google'])!!}',
			      type: 'POST',
			      dataType: 'json',
			      data: {
			          @if( request()->has('rel') )
			          rel: '{!!Input::get('rel')!!}',
			          @endif
			        _token: '{!!csrf_token()!!}',
			        access_token: resp
			        },
			      success:function(result){
		          	if( result.message ){
		          		$('#message_login_by_g').text(result.message);
					}else{
		          		$('#message_login_by_g').text('');
					}
					if( result.redirect ){
						window.location.href = result.redirect;
					}
					if( result.reload ){
						window.location.reload(result.reload);
					}
			      }
			    });
		    }

	  	}


		 $(window).on('load',function(){
			

		 	$('#datlaimatkhau').on('click',function(event){
				event.preventDefault();

        		loading('Tiến trình reset mật khẩu đang diễn ra');

		 		var data = $('#popup-datlaimatkhau').serializeArray();
					data.push({name:'_token',value: '{!!csrf_token()!!}'});
					url = $('#popup-datlaimatkhau').find('.url_post').val();
					$.ajax({
						url:url,
						method:"POST",
						dataType:"Json",
						data:data,
						success:function(result){
							
        					loading();

							if( result.message ){
				          		$('#message_reset_password').text(result.message);
							}else{
				          		$('#message_reset_password').text('');
							}

							if( result.redirect ){
								window.location.href = result.redirect;
							}
							if( result.reload ){
								window.location.reload(result.reload);
							}
						}
					});
		 	});

			$('.btn-login').on('click',function(event){
				event.preventDefault();

				var data = $('#popup-login').serializeArray();
				data.push({name:'_token',value: '{!!csrf_token()!!}'});
				url = $('#popup-login').find('.url_post').val();
				$.ajax({
					url:url,
					method:"POST",
					dataType:"Json",
					data:data,
					success:function(result){
						if( result.message ){
			          		$('#message_login').text(result.message);
						}else{
			          		$('#message_login').text('');
						}
						if( result.redirect ){
							window.location.href = result.redirect;
						}
						if( result.reload ){
							window.location.reload(result.reload);
						}
					}
				});
			});

			let script = document.createElement('script');

		 	script.src = 'https://apis.google.com/js/platform.js?onload=onLoadGoogleCallback';

			document.head.appendChild(script);


			

			//  facebook
			setTimeout(() => {
				window.fbAsyncInit = function() {
				FB.init({
					xfbml            : true,
					version          : 'v8.0'
				});
				};

				(function(d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) return;
				js = d.createElement(s); js.id = id;
				js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
				fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
			}, 2000);

		 });

		
	 </script>

	<div id="fb-root"></div>

	<div class="fb-customerchat"
		attribution=setup_tool
		page_id="102469741550135"
	theme_color="#00afab"
	logged_in_greeting="Chào bạn! Bạn có cần tư vấn gì không?"
	logged_out_greeting="Chào bạn! Bạn có cần tư vấn gì không?">
	</div>

	 
</body>
</html>
