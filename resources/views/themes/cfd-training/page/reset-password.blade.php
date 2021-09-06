@extends(theme_extends())



<?php 



    title_head('Đặt lại mật khẩu');


    $messages = Session::get('messages');

    if( $messages ){

        $messages = $messages;

    }

    else $messages = [];


    $access_token = Request::get('token');

    if( !$access_token ) return vn4_redirect(route('index'));

    $key = "cfdtraining_api_reset_password";
    $decoded = (array) \Firebase\JWT\JWT::decode($access_token, $key, array('HS256'));

    if( !$decoded ) return vn4_redirect(route('index'));


    $time = time();

    if( ($time - $decoded['time']) > 86400 ){
         return vn4_redirect(route('index'));
    }

    // session()->forget('user_frontend');

    function getMessage($messages, $key){

        $str = '';

        if( isset($messages[$key]) ){

            foreach ($messages[$key] as $v) {

                $str .= '<p class="mess-error">'.$v.'</p>';

            }

        }

        return $str;

    }



 ?>



@section('content')

<style type="text/css">

    .form label div{

        flex:1;

    }

    .mess-error{
        color: red;
        margin-top: 3px;
        width: 100% !important;
        font-size: 14px;
    }
    .register-course .wrap label textarea, .register-course .wrap label input{
        width: 100%;
    }

</style>

    <main class="register-course" id="main">

        <div class="section-1">

            @if(!Session::get('success'))

            <form action="{!!route('post',['account','dat-lai-mat-khau'])!!}" method="POST">

                <input type="hidden" name="_token" value="{!!csrf_token()!!}">
                <input type="hidden" name="access_token" value="{!!$access_token!!}">
                <div class="wrap container">

                    <!-- <div class="main-sub-title">liên hệ</div> -->

                    <h2 class="main-title">đặt lại mật khẩu</h2>
                    <p class="top-des">
                        <!-- Đừng ngần ngại liên hệ với <strong>CFD</strong> để cùng nhau tạo ra những sản phẩm giá trị, cũng như việc hợp tác với các đối tác tuyển dụng và công ty trong và ngoài nước. -->
                    </p>

                    <div class="form">



                        <label>

                            <p>Mật khẩu mới<span>*</span></p>

                            <div>

                            <input name="password" type="password" value="{{ old('password') }}" placeholder="Mật khẩu mới">

                            {!!getMessage($messages, 'password')!!}

                            </div>



                        </label>

                        <label>

                            <p>Xác nhận mật khẩu<span>*</span></p>

                            <div>

                            <input name="confirm_pasword" type="password" value="{{ old('confirm_pasword') }}" placeholder="Xác nhận mật khẩu">

                            {!!getMessage($messages, 'confirm_pasword')!!}

                            </div>

                        </label>

                        <div class="btn main rect btn-contact">Gửi</div>

                    </div>

                </div>

            </form>

            @else

            <div class="register-success">

                <div class="contain">

                    <div class="main-title">Thay đổi mật khẩu thành công</div>

                    <p style="text-align: center;">

                        Vui lòng đăng nhập lại

                    </p>

                </div>

                <a href="/" class="btn main rect">về trang chủ</a>

            </div>

            @endif
        </div>

    </main>

@stop



@section('js')

      <script type="text/javascript">



      $('.btn-contact').on('click',function(){

        $(this).closest('form').submit();

      });

    </script>

@stop