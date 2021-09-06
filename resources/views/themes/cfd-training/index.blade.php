@extends(theme_extends())

<?php 
    title_head('Home');
    $GLOBALS['menu-main'] = 'trang-chu';
 ?>

@section('content')
<main class="homepage" id="main">
    <div class="banner jarallax">
        <div class="container">
            <div class="content">
                <h2 class="title">THỰC CHIẾN</h2>
                <h3 class="des">ĐỂ TRỞ THÀNH CREATIVE FRONT-END DEVELOPER</h3>
                <div class="btn main round"><a href="{!!route('page','khoa-hoc')!!}" style="color:white;">KHÓA HỌC</a></div>
            </div>
            <img src="@theme_asset()img/icon-scrolldown.svg" alt="" class="icon-scrolldown">
        </div>
        <img src="@theme_asset()img/banner-background.jpg" alt="" class="jarallax-img">

    </div>
    <section class="section-1">
        <div class="container">
            <p class="top-des">
                Chào mừng đến với <strong>CFD</strong>!<br>
                Nơi dành cho những bạn theo đuổi nghề Web Developer và UX/UI Designer.<br>
                Nếu bạn đang tự học hoặc học ở một nơi nào đó mà vẫn chưa thể làm ra sản phẩm hoàn thiện và những kỹ năng thực tế cần có, thì CFD chính là nơi giúp bạn làm điều đó.
            </p>
            <div class="textbox">
                <h3 class="sub-title">KHÓA HỌC</h3>
                <h2 class="main-title">ONLINE</h2>
            </div>
            <div class="list row">

                <?php
                    $courses = get_posts('cfd_course',['count'=>6,'callback'=>function( $q ){   
                        $q->where('course_type','online');
                    }]);
                ?>

                @foreach($courses as $c)
                {!!get_single_post($c)!!}
                @endforeach

            </div>
        </div>
    </section>
    <section class="section-2 section-blue">
        <img src="@theme_asset()img/dots.svg" alt="" class="dots">
        <img src="@theme_asset()img/line.svg" alt="" class="line">
        <div class="container">
            <div class="textbox">
                <h3 class="sub-title">KHÓA HỌC</h3>
                <h2 class="main-title">OFFLINE</h2>
            </div>
            <div class="list row">
                <?php
                    $courses = get_posts('cfd_course',['count'=>6,'callback'=>function( $q ){   
                        $q->where('course_type','offline');
                    }]);
                ?>

                @foreach($courses as $c)
                {!!get_single_post($c)!!}
                @endforeach
                
            </div>
            <div class="text-deco">C</div>
        </div>
    </section>
    <section class="section-3">
        <div class="container">
            <div class="video">
                <iframe id="video-intro"
                src="https://www.youtube-nocookie.com/embed/6t-MjBazs3o?controls=0&showinfo=0&rel=0&enablejsapi=1&version=3&playerapiid=ytplayer"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen allowscriptaccess="always"></iframe>
                <div class="play-btn btn-video-intro">
                    <img src="@theme_asset()img/play-video-btn.png" alt="">
                </div>
            </div>
        </div>
    </section>

    <div class="section-4">
        <div class="textbox">
            <h3 class="sub-title">CHÚNG TA</h3>
            <h2 class="main-title">LÀ MỘT TEAM</h2>
        </div>
        <div class="list">
            <div class="item carousel-cell">
                <img data-flickity-lazyload="@theme_asset()img/img_team1.png" alt="">
            </div>
            <div class="item carousel-cell">
                <img data-flickity-lazyload="@theme_asset()img/img_team2.png" alt="">
            </div>
            <div class="item carousel-cell">
                <img data-flickity-lazyload="@theme_asset()img/img_team3.png" alt="">
            </div>
            <div class="item carousel-cell">
                <img data-flickity-lazyload="@theme_asset()img/img_team4.png" alt="">
            </div>
            <div class="item carousel-cell">
                <img data-flickity-lazyload="@theme_asset()img/img_team3.png" alt="">
            </div>
            <div class="item carousel-cell">
                <img data-flickity-lazyload="@theme_asset()img/img_team4.png" alt="">
            </div>
        </div>
    </div>

</main>
@stop