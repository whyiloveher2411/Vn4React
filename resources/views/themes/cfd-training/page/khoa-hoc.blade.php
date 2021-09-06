@extends(theme_extends())

<?php 

	title_head('Khóa học');
    $GLOBALS['menu-main'] = 'khoa-hoc';
 ?>

@section('content')
    <main class="homepage" id="main">
        <section class="section-courseoffline">
            <div class="container">
                <h2 class="main-title">Khóa học CFD</h2>
                <p class="top-des">
                    Khóa học thực chiến tại <strong>CFD</strong> được thiết kế giúp cho thành viên trải nghiệm những dự án thực tế, bám sát yêu cầu nhà tuyển dụng, cũng như những kỹ năng cần thiết để ứng tuyển tại các công ty.
                </p>
                <div class="textbox">
                <h2 class="main-title">Offline</h2>
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
                    <h2 class="main-title">Online</h2>
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
                <div class="text-deco">C</div>
            </div>
        </section>
    </main>
@stop
    