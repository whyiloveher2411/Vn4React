@extends(theme_extends())



<?php 

    title_head('Đăng ký');

    $GLOBALS['menu-main'] = 'dang-ky';



    $account = check_login_frontend();



    $course = get_post('cfd_course',Request::get('id'));



    if( !$course ){

        return vn4_redirect( route('page','khoa-hoc') );

    }



    $messages = Session::get('messages');


    if( $messages ){

        if( is_string($messages) ){

        }else{

            $messages = $messages->messages();
        }
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

    $nguoi_gioi_thieu = false;

    if( $account ){
        $nguoi_gioi_thieu = get_nguoi_gioi_thieu($account);
    }else{
        $nguoi_gioi_thieu = get_nguoi_gioi_thieu();
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
        <section>

            <div class="container">

            @if(!Session::get('success'))

            <form action="{!!route('post',['register-course','post'])!!}" method="POST">

                <input type="hidden" name="_token" value="{!!csrf_token()!!}">

                <input type="hidden" name="cfd_course" value="{!!$course->id!!}">

                <input type="hidden" class="payment_method_input" name="payment_method" value="Chuyển khoản">



                @if( $account )

                <input type="hidden" name="cfd_student" value="{!!$account->id!!}">

                @endif



                <div class="wrap">

                    <div class="main-sub-title">ĐĂNG KÝ</div>
                    <h1 class="main-title">{!!$course->title,' - ',$course->course_type!!} </h1>
                    <div class="main-info">
                        <div class="date"><strong>Khai giảng:</strong> {!!get_date($course->opening_time)!!}</div>
                        <div class="time"><strong>Thời lượng:</strong> {!!count(json_decode($course->content,true)??[])!!} buổi</div>
                         @if( $nguoi_gioi_thieu && $course->money_affiliate_1)
                        <div class="time"><strong>Học phí:</strong>  <del>{!!number_format($course->money)!!} VNĐ</del> - {!!number_format($course->money - $course->money_affiliate_1 * 1000)!!} VNĐ </div>
                        @else
                        <div class="time"><strong>Học phí:</strong> {!!number_format($course->money)!!} VND</div>
                        @endif

                    </div>


                    <div class="form">

                        @if( $messages && is_string($messages) )
                        <p class="mess-error" style="position: unset;text-align: center;font-size: 18px;margin-bottom: 30px;">{!!$messages!!}</p>
                        @endif

                        <label>

                            <p>Họ và tên<span>*</span></p>



                            <div>

                            <input type="text" name="title" value="{!!$account->title??old('title')!!}" placeholder="Họ và tên bạn">

                            {!!getMessage($messages, 'title')!!}

                            </div>



                        </label>

                        <label>

                            <p>Số điện thoại<span>*</span></p>

                            <div>

                            <input type="text" name="phone" value="{!!$account->phone??old('phone')!!}" placeholder="Số điện thoại">

                            {!!getMessage($messages, 'phone')!!}

                            </div>



                        </label>

                        <label>

                            <p>Email<span>*</span></p>

                            <div>

                            <input type="text" name="email" @if( $account ) value="{!!$account->email!!}" readonly="readonly" @else value="{!!old('email')!!}" @endif  placeholder="Email của bạn">

                            {!!getMessage($messages, 'email')!!}

                            </div>



                        </label>

                        <label>

                            <p>URL Facebook<span>*</span></p>

                            <div>

                            <input type="text" name="facebook" value="{!!$account->facebook??old('facebook')!!}" placeholder="https://facebook.com">

                            {!!getMessage($messages, 'facebook')!!}

                            </div>



                        </label>

                        @if( $account && $account->total_coin_current > 0 )
                        <label class="disable">
                            <p>Sử dụng COIN</p>
                            <div class="checkcontainer">
                                Hiện có <strong>{!!$account->total_coin_current!!} COIN</strong> <br>
                               <!--  Giảm giá còn <span><strong>5.800.000 VND</strong>, còn lại 100 COIN</span>
                                Cần ít nhất 200 COIN để giảm giá -->
                                <input type="checkbox" value="yes" @if( old('use_coin') ) checked="checked" @endif name="use_coin">
                                <span class="checkmark"></span>
                            </div>
                        </label>
                        @endif



                        <label>

                            <p>Hình thức thanh toán</p>

                            <div class="select">

                                <div class="head">Chuyển khoản</div>

                                <div class="sub change_method_payment" >

                                    <a href="#">Chuyển khoản</a>

                                    <a href="#">Thanh toán tiền mặt</a>

                                </div>

                            </div>

                        </label>

                        <label>

                            <p>Ý kiến cá nhân</p>

                            <div>

                            <input type="text" name="opinion" value="{!!old('opinion')!!}" placeholder="Định hướng và mong muốn của bạn.">

                            {!!getMessage($messages, 'opinion')!!}

                            </div>



                        </label>

                        <div class="btn main rect btn-register btn-submit">đăng ký</div>

                    </div>

                </div>

            </form>

            @else

            <div class="register-success">

                <div class="contain">

                    <div class="main-title">đăng ký thành công</div>

                    <p>

                        <strong>Chào mừng {{ old('title') }} đã trở thành thành viên mới của CFD Team.</strong> <br>

                        Cảm ơn bạn đã đăng ký khóa học tại <strong>CFD</strong>, chúng tôi sẽ chủ động liên lạc với bạn thông qua số điện thoại của bạn.

                    </p>

                </div>

                <a href="/" class="btn main rect">về trang chủ</a>

            </div>
            </div>
        </section>

        @endif

    </main>

@stop



@section('js')

      <script type="text/javascript">

      $('.btn-submit').on('click',function(){

        let $this = $(this);

        loading('Tiến trình đăng ký đang diễn ra',function(){
           $this.closest('form').submit();
        });

      });



      $('.change_method_payment a').on('click',function(){

        $('.payment_method_input').val($(this).text());

      });

    </script>

@stop

