@extends(theme_extends())



<?php 

	title_head('Course Detail');

    $account = check_login_frontend();

    $content = json_decode($post->content,true);
    $requireds = json_decode($post->required,true);
    $benefits = json_decode($post->benefits,true);
    $ngay = 0;

    $da_dk = false;

    if( $account && $register = $account->related('cfd_course_register','cfd_student',['count'=>1, 'callback'=>function($q) use ($post){ $q->where('cfd_course', $post->id)->whereIn('trang_thai',['cho-xet-duyet','duoc-duyet']); }]) ){
        $da_dk = true;
    }

    $nguoi_gioi_thieu = false;

    if( $account ){
        $nguoi_gioi_thieu = get_nguoi_gioi_thieu($account);
    }else{
        $nguoi_gioi_thieu = get_nguoi_gioi_thieu();
    }

 ?>



@section('content')

 <main class="course-detail" id="main">

    <section class="banner style2" style="--background:{!!$post->template_color_banner?$post->template_color_banner:'#cde6fb'!!}">

        <div class="container">

            <div class="info">

                <h1>{!!$post->title,' - ',$post->course_type!!}</h1>

                <div class="row">

                    <div class="date"><strong>Khai giảng:</strong> {!!get_date($post->opening_time)!!}</div>

                    <div class="time"><strong>Thời lượng:</strong> {!!count($content)!!} buổi</div>

                </div>
                @if( $post->course_status === 'sap-khai-gian' )
                    @if( !$da_dk )
                        <a href="{!!route('page',['page'=>'dang-ky','id'=>$post->id])!!}" class="btn white round" style="--color-btn:{!!$post->template_color_btn??'#70b6f1'!!}">đăng ký</a>
                    @else
                        <p>Bạn đã đăng ký khóa học này.</p>
                    @endif
                @elseif($post->course_status === 'dang-dien-ra')
                    <p>Khóa học đang diễn ra bạn không thể đăng ký</p>
                @else
                    <p>Khóa học đã kết thúc bạn không thể đăng ký</p>
                @endif
                
            </div>

           

        </div>
        <div class="bottom">
            <div class="container">
                <div class="video">
                    <!-- <div class="icon">
                        <img src="@theme_asset()img/play-icon-white.png" alt="">
                    </div>  -->
                    <!-- Video giới thiệu -->
                    Chi tiết
                </div>

                @if( $nguoi_gioi_thieu && $post->money_affiliate_1)
                <div class="money"><del>{!!number_format($post->money)!!} VNĐ</del> <br> {!!number_format($post->money - $post->money_affiliate_1 * 1000)!!} VNĐ </div>
                @else
                <div class="money">{!!number_format($post->money)!!} VNĐ</div>
                @endif
            </div>
        </div>

    </section>

    <section class="section-2">

        <div class="container">

            <p class="des">{!!$post->long_description!!}</p>

            <!-- <h2 class="title">giới thiệu về khóa học</h2> -->

            <div class="cover">

                <!-- <img data-src="{!!get_media($post->thubnail)!!}" src="@theme_asset()img/thumb-load.jpg" class="lazyload" alt=""> -->

            </div>

            <h3 class="title">nội dung khóa học</h3>


         

            @forif( $content as  $c)
            <div class="accordion">

                <div class="accordion__title">
                    <h3>{!!$c['title']!!}</h3>
                    <div class="date">Ngày {!!++$ngay!!}</div>
                </div>

                <div class="content">

                    {!!$c['content']!!}
                    @if( isset($c['video']['source']) && $c['video']['source'] )
                    @if( $c['video']['status'] == 'public' || $da_dk )
                    <video class="video" width="100%" height="auto" controls>
                      <source src="{!!$c['video']['source']!!}" type="video/mp4">
                    Your browser does not support the video tag.
                    </video>
                    @endif
                    @endif

                    @if( isset($c['slide']['source']) && $c['slide']['source'] )
                    @if( $c['slide']['status'] == 'public' || $da_dk )
                    <p><strong>Slide: </strong><a href="{!!$c['slide']['source']!!}" target="_blank">{!!$c['slide']['source']!!}</a></p>
                    @endif
                    @endif


                </div>

            </div>
            @endforif
            

            <h3 class="title">yêu cầu cần có</h3>

            <div class="row row-check">

                @forif( $requireds as  $c)
                    <div class="col-md-6">{!!$c['content']!!}</div>
                @endforif
               

            </div>

            <h3 class="title">Hình thức học</h3>

            <div class="row row-check">

                @forif( $benefits as  $c)
                    <div class="col-md-6">{!!$c['content']!!}</div>
                @endforif
               

            </div>

            <h3 class="title">

                lịch học

                <div class="sub">*Lịch học và thời gian có thể thống nhất lại theo số đông học viên.</div>

            </h3>

            <p>

                <strong>Ngày bắt đầu: </strong> {!!get_date($post->opening_time)!!} <br>

                <strong>Thời gian học: </strong> {!!$post->schedule!!}

            </p>

             <?php 
                $teachers = $post->relationship('cfd_teacher');
                $mentor = $post->relationship('mentor');
            ?>
            <h3 class="title">Người dạy</h3>


            @foreach($teachers as $t)
                <div class="teachers">
                    <div class="teacher">

                        <div class="avatar">

                            <img data-src="{!!get_media($t->avatar)!!}" src="@theme_asset()img/thumb-load.jpg" class="lazyload" alt="">

                        </div>

                        <div class="info">

                            <div class="name">{!!$t->title!!}</div>

                            <div class="title">{!!$t->position!!}</div>

                            <p class="intro">

                            {!!$t->description!!}

                            </p>

                            @if($t->website)
                            <p class="website"><strong>Website:</strong>  <a rel="noreferrer" href="{!!$t->website!!}" target="_blank">{!!$t->website!!}</a></p>
                            @endif
                            
                        </div>

                    </div>
                </div>
            @endforeach

            @if(isset($mentor[0]))
             <h3 class="title">Người hướng dẫn</h3>
            @foreach($mentor as $t)
                <div class="teachers mentors">
                    <div class="teacher">

                        <div class="avatar">

                            <img data-src="{!!get_media($t->avatar)!!}" src="@theme_asset()img/thumb-load.jpg" class="lazyload" alt="">

                        </div>

                        <div class="info">

                            <div class="name">{!!$t->title!!}</div>

                            <div class="title">{!!$t->position!!}</div>

                            <p class="intro">

                            {!!$t->description!!}

                            </p>

                            @if($t->website)
                            <p class="website"><strong>Website:</strong>  <a rel="noreferrer" href="{!!$t->website!!}" target="_blank">{!!$t->website!!}</a></p>
                            @endif

                        </div>

                    </div>
                </div>
            @endforeach
            @endif


            <div class="bottom">

                <div class="user">

                    <?php
                        $count = $post->related('cfd_student','cfd_project',['count'=>true]);
                    ?>
                    <img src="@theme_asset()img/user-group-icon.png" alt=""> {!!$post->number_student_default + $count!!} bạn đã đăng ký

                </div>

                @if( $post->course_status === 'sap-khai-gian')
                <a href="{!!route('page',['page'=>'dang-ky','id'=>$post->id])!!}"  class="btn main btn-register round" style="color: white;">đăng ký</a>
                @endif

                <a href="https://www.facebook.com/sharer/sharer.php?sdk=joey&amp;u={!!request()->fullUrl()!!}&amp;display=popup&amp;ref=plugin&amp;src=share_button" onclick="return !window.open(this.href, 'Facebook', 'width=640,height=580')"  class="btn-share btn overlay round btn-icon">
                    <img src="@theme_asset()img/facebook.svg" alt="">
                </a>


            </div>





        </div>

    </section>

    <section class="section-3" style="display:none">

        <div class="container">

            <div class="textbox">
                <h3 class="sub-title">DỰ ÁN</h3>
                <h2 class="main-title">THÀNH VIÊN</h2>
            </div>

            <div class="list row">

                 <?php
                     $projects = get_posts('cfd_project',['count'=>8,'paginate'=>'page','callback'=>function($q){
                        $q->where('show_on_public','1')->inRandomOrder();
                    }]);
                ?>

                @foreach($projects as $p)
                {!!get_single_post($p,['col'=>'col-md-4 course'])!!}
                @endforeach


            </div>

        </div>

    </section>

    <section class="section-4">

        <div class="container">
            <div class="textbox">
                <h2 class="main-title">Khóa học liên quan</h2>
            </div>
            <div class="list row">
                


                <?php
                    $courses = get_posts('cfd_course',['count'=>3,'order'=>['opening_time','desc'],'callback'=>function( $q ) use ($post) {   
                        $q->where('course_type',$post->course_type)->where('id','!=',$post->id);
                    }]);
                ?>

                @foreach($courses as $c)
                {!!get_single_post($c)!!}
                @endforeach


            </div>

        </div>

    </section>

</main>

@stop

