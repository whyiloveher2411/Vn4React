@extends(theme_extends())



<?php 



    title_head('Hợp tác');

    $GLOBALS['menu-main'] = 'hop-tac';



    $messages = Session::get('messages');



    if( $messages ){

        $messages = $messages->messages();

    }

    else $messages = [];





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

    .register-course .wrap label textarea, .register-course .wrap label input{
        width: 100%;
    }

</style>

    <main class="register-course" id="main">

        <div class="section-1">

            @if(!Session::get('success'))

            <form action="{!!route('post',['contact','post'])!!}" method="POST">

                <input type="hidden" name="_token" value="{!!csrf_token()!!}">

                <div class="wrap container">

                    <!-- <div class="main-sub-title">liên hệ</div> -->

                    <h2 class="main-title">Hợp tác cùng CFD</h2>
                    <p class="top-des">
                        Đừng ngần ngại liên hệ với <strong>CFD</strong> để cùng nhau tạo ra những sản phẩm giá trị, cũng như việc hợp tác với các đối tác tuyển dụng, công ty trong và ngoài nước.
                    </p>

                    <div class="form">





                        <label>

                            <p>Họ và tên<span>*</span></p>



                            <div>

                            <input name="name" type="text" value="{{ old('name') }}" placeholder="Họ và tên bạn">

                            {!!getMessage($messages, 'name')!!}

                            </div>



                        </label>

                        <label>

                            <p>Số điện thoại</p>

                            <div>

                            <input name="phone" type="text" value="{{ old('phone') }}" placeholder="Số điện thoại">

                            {!!getMessage($messages, 'phone')!!}

                            </div>



                        </label>

                        <label>

                            <p>Email<span>*</span></p>

                            <div>

                            <input name="email" type="text" value="{{ old('email') }}" placeholder="Email của bạn">

                            {!!getMessage($messages, 'email')!!}

                            </div>

                        </label>

                        <label>

                            <p>Website</p>

                            <div>

                            <input name="website" type="text" value="{{ old('website') }}" placeholder="Đường dẫn website http://">

                            {!!getMessage($messages, 'website')!!}

                            </div>

                        </label>

                        <label>

                            <p>Tiêu đề<span>*</span></p>

                            <div>

                            <input name="title" type="text" value="{{ old('title') }}" placeholder="Tiêu đề liên hệ">

                            {!!getMessage($messages, 'title')!!}

                            </div>



                        </label>

                        <label>

                            <p>Nội dung<span>*</span></p>

                            <div>

                            <textarea name="content" name="" id="" cols="30" rows="10">{{ old('content') }}</textarea>

                            {!!getMessage($messages, 'content')!!}

                            </div>

                        </label>

                        

                        <div class="btn main rect btn-contact">Gửi</div>

                    </div>

                </div>

            </form>

            @else

            <div class="register-success">

                <div class="contain">

                    <div class="main-title">đăng ký thành công</div>

                    <p>

                        <strong>Chào mừng {{ old('name') }} đã trở thành thành viên mới của CFD Team.</strong> <br>

                        Cảm ơn bạn đã đăng ký khóa học tại <strong>CFD</strong>, chúng tôi sẽ chủ động liên lạc với bạn thông qua facebook

                        hoặc số điện thoại của bạn.

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