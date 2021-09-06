@extends(theme_extends())



<?php 



    title_head('Dự án');

    $GLOBALS['menu-main'] = 'du-an';

    $posts = get_posts('cfd_project',['count'=>8,'paginate'=>'page','callback'=>function($q){
        $q->where('show_on_public','1');
    }]);

  ?>





@section('content')

    <main class="projectpage" id="main">

        <section class="section-1">

            <div class="container">
                <h2 class="main-title">dự án</h2>
                <p class="top-des">

                    Tổng hợp dự án của các thành viên và học viên tại CFD.

                </p>
                <div class="list row">
                    <h2 style="margin: auto;">Đang cập nhật dự án</h2>
                    
                    @foreach($posts as $p)

                    <?php 
                        $student = $p->relationship('cfd_student');
                    ?>

                    <a href="{!!$p->url_website!!}" target="_blank" rel="nofollow" class="item col-md-4">

                        <div class="wrap">

                            <div class="cover">

                                <img src="{!!get_media($p->thubnail,null,'project-page')!!}" alt="">

                            </div>

                            <div class="info">

                                <h2 class="name">{!!$p->title!!}</h2>

                                <div class="makeby">Hoàn thành bởi {!!$student->title!!} </div>

                            </div>

                        </div>

                    </a>
                    @endforeach
                    

                </div>
<!-- 
                <div class="bottom">

                    <div class="btn overlay round btn-more">

                        tải thêm

                    </div>

                </div> -->

            </div>

        </section>

    </main>

@stop