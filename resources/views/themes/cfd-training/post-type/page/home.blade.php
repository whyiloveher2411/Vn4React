@extends(theme_extends())



<?php 

    title_head('Home');

    $GLOBALS['menu-main'] = 'trang-chu';



    $banner = $post->banner;

    $video_id = $post->video_id;



    $gallery = get_media($post->gallery,[]);

 ?>



@section('content')

<main class="homepage" id="main">

    <div class="banner jarallax">

        <div class="container">

            <div class="content">
                <h2 class="title">{!!$banner['title']!!}</h2>
                <h2 class="title">{!!$banner['description']!!}</h2>
                <div class="btn main round"><a href="{!!$banner['link']!!}" style="color:white;">{!!$banner['button_label']!!}</a></div>

            </div>

            <!-- <img src="@theme_asset()img/icon-scrolldown.svg" alt="CFD" class="icon-scrolldown"> -->

        </div>
        <div class="jarallax-img">
            
            <img data-src="{!!get_media($banner['background'])!!}" alt="CFD" class="lazyload" srcset="{!!get_media($banner['background'],null,'384w')!!} 384w,  {!!get_media($banner['background'],null,'768w')!!} 768w, {!!get_media($banner['background'],null,'1152w')!!} 1152w,{!!get_media($banner['background'],null,'1536w')!!} 1536w,{!!get_media($banner['background'],null,'1920w')!!} 1920w" />

            <div class="video-bg lazyload" data-src="@theme_asset()video/CFD-video-bg2.mp4"></div>
        </div>
    </div>

    <section class="section-courseoffline">

        <div class="container">

            <p class="top-des">

            <strong>Chào mừng bạn đến với CFD</strong>!<br>
                <!-- Nếu bạn sản phẩm hoàn thiện và những kỹ năng thực tế cần có, thì CFD chính là nơi giúp bạn làm điều đó. -->

                Nơi có những khóa học thực chiến Front-End Dev và UX/UI Design, kết nối và chia sẻ kinh nghiệm giúp bạn có đầy đủ kỹ năng thực tế để tạo ra những sản phẩm sáng tạo, tinh tế và phù hợp.</strong>

            </p>

            

            <div class="textbox">
                <h2 class="main-title">Khóa học Offline</h2>
            </div>

            <div class="list row">

                <?php

                    $courses = get_posts('cfd_course',['count'=>6,'order'=>['opening_time','desc'],'callback'=>function( $q ){   

                        $q->where('course_type','offline');

                    }]);

                ?>



                @foreach($courses as $c)

                {!!get_single_post($c)!!}

                @endforeach

                

            </div>

        </div>

    </section>

    <section class="section-courseonline section-blue">
        <div class="container">

            <div class="textbox">

                <h2 class="main-title">Khóa học Online</h2>

            </div>

            <div class="list row">



                <?php

                    $courses = get_posts('cfd_course',['count'=>6,'order'=>['opening_time','desc'],'callback'=>function( $q ){   

                        $q->where('course_type','online');

                    }]);

                ?>



                @foreach($courses as $c)

                {!!get_single_post($c)!!}

                @endforeach



            </div>



        </div>

    </section>
    <section class="section-different">
        <div class="container">
            <div class="row">
                <div class="titlebox col-md-6 col-xs-12">
                    <h2 class="main-title white textleft">Những điều <br><span>đặc biệt</span> tại CFD</h2>
                    <div class="videodif" data-src="@theme_asset()video/CFD-video-intro.mp4">
                        <img src="@theme_asset()img/thumb-cfd-load.jpg" data-src="@theme_asset()img/img-cfd-dac-biet.jpg" alt="CFD" class="lazyload">
                        <div class="play-btn btn-video-intro">
                            <img src="@theme_asset()img/play-icon.svg" alt="CFD">
                        </div>
                    </div>
                </div>
                <div class="contentbox col-md-6 col-xs-12">
                    <div class="item">
                        <h4>Không cam kết đầu ra</h4>
                        <p>Với CFD thì việc cam kết đầu ra nó sẽ không có ý nghĩa nếu như cả người hướng dẫn và
                            người
                            học không thật sự tâm huyết và cố gắng. Vì thế, đội ngũ CFD sẽ làm hết sức để giúp các
                            thành
                            viên tạo ra sản phẩm có giá trị, thay vì cam kết.
                        </p>
                    </div>
                    <div class="item">
                        <h4>Không chỉ là một lớp học</h4>
                        <p>CFD không phải một lớp học thuần túy, tất cả thành viên là một team, cùng hỗ trợ, chia sẻ
                            và
                            giúp đỡ nhau trong suốt quá trình học và sau này, với sự hướng dẫn tận tâm của các thành
                            viên đồng sáng lập.
                        </p>
                    </div>
                    <div class="item">
                        <h4>Không để ai bị bỏ lại phía sau</h4>
                        <p>Vì chúng ta là một team, những thành viên tiếp thu chậm sẽ được đội ngũ CFD kèm cặp đặc
                            biệt,
                            cùng sự hỗ trợ từ các thành viên khác. Vì mục tiêu cuối cùng là hoàn thành
                            khóa
                            học thật tốt.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section-testimonial">
        <div class="container">
            <div class="textbox">
            <h2 class="main-title white">Học viên cảm nhận về CFD</h2>
            </div>

            <?php 
                $testimonial = $post->testimonial;
                $index = 0;
             ?>

            <div class="testimonial">
                <div class="testimonial-item">
                    <div class="item">
                        <div class="text">
                            @forif( $testimonial as $t)
                            <div class="ct ct-{!!++$index!!} @if( $index == 1) active @endif">
                                <div class="info">
                                    <div class="name">
                                        <h4>{!!$t['name']!!}</h4>
                                        <p>{!!$t['position']!!}</p>
                                    </div>
                                    <div class="quotes"><img src="@theme_asset()img/quotes.svg" alt="CFD"></div>
                                </div>
                                <div class="content">
                                    {!!$t['content']!!}
                                </div>
                                <div class="bottom">
                                    <a href="{!!$t['link']!!}" rel="noreferrer" target="_blank"><img src="@theme_asset()img/facebook.svg" alt="CFD"></a>
                                    <span>{!!$t['date']!!}</span>
                                </div>
                            </div>
                            @endforif

                        </div>
                        <div class="images">
                            <div class="list">

                                @forif( $testimonial as $t)
                                <div class="carousel-cell">
                                    <div class="img">
                                        <picture>
                                            <source media="(max-width: 767px)" srcset="{!!get_media($t['image2'])!!}">
                                            <img data-flickity-lazyload="{!!get_media($t['image'])!!}" alt="CFD">
                                        </picture>
                                    </div>
                                    <div class="ct_m">
                                        <div class="info">
                                            <div class="name">
                                                <h4>{!!$t['name']!!}</h4>
                                                <p>{!!$t['position']!!}</p>
                                            </div>
                                            <div class="quotes"><img src="@theme_asset()img/quotes.svg" alt="CFD"></div>
                                        </div>
                                        <div class="content">
                                            {!!$t['content']!!}
                                        </div>
                                        <div class="bottom">
                                            <a href="{!!$t['link']!!}" rel="noreferrer" target="_blank"><img src="@theme_asset()img/facebook.svg" alt="CFD"></a>
                                            <span>{!!$t['date']!!}</span>
                                        </div>
                                    </div>
                                </div>
                                @endforif
                            </div>
                        </div>
                    </div>

                    <div class="dots"></div>
                    <div class="btn_ctr prev"></div>
                    <div class="btn_ctr next"></div>
                </div>
            </div>
        </div>
    </section>               

    <section class="section-gallery">

        <div class="textbox">

            <h2 class="main-title">Chúng ta là một team</h2>

        </div>

        <div class="list">



            @foreach($gallery as $img)

                <img data-flickity-lazyload="{!!$img!!}" alt="CFD">

            @endforeach



        </div>
        <div class="controls">
            <div class="btn_ctr prev"></div>
            <span>Trượt qua</span>
            <div class="timeline">
                <div class="process"></div>
            </div>
            <div class="btn_ctr next"></div>
        </div>
    </section>

    <section class="section-action">
        <div class="container">
            <h3>Bạn đã sẵn sàng trở thành chiến binh tiếp theo của Team CFD chưa?</h3>
            <div class="btn main round bg-white btn-open-popup" data-id="register">Đăng ký</div>
        </div>
    </section>



</main>


<div class="popup-video" id="popup-video" style="display: none;">
    <div class="wrap">
        <div class="video-src"></div>
    </div>
    <div class="close"></div>
</div>

@stop