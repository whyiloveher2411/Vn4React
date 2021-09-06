@extends(theme_extends())



<?php 



    title_head('CFD Team');

    $GLOBALS['menu-main'] = 'team';



    $teachers = get_posts('cfd_teacher',100);

    $students = get_posts('cfd_student',['count'=>1000,'paginate'=>'page','callback'=>function($q){ $q->where('student_type','hoc-vien');}]);

 ?>





@section('content')

    <main class="team" id="main">
        <section>
            <div class="container">

                <div class="top">

                    <h2 class="main-title">CFD team</h2>

                    <p class="top-des">
                        Chúng ta không phải một lớp học, những thành viên CFD là một TEAM, cùng học hỏi và hỗ trợ lẫn nhau dưới sự hướng dẫn từ những người đồng sáng lập CFD.
                    </p>

                </div>

                <div class="list row">



                    @foreach($teachers as $t)

                    <div class="item col-md-6 col-sm-6">

                        <div class="wrap">

                            <div class="cover">

                                <img data-src="{!!get_media($t->avatar,null,'thubnail-2')!!}" src="@theme_asset()img/thumb-load.jpg"  class="lazyload" alt="">

                            </div>

                            <div class="info">

                                <div class="name">

                                    {!!$t->title!!}

                                </div>

                                <p class="title">  {!!$t->position!!}</p>

                                @if($t->website)
                                <p class="website"><a href="{!!$t->website!!}" target="_blank" rel="nofollow">{!!$t->website!!}</a></p>
                                @endif

                            </div>

                        </div>

                    </div>

                    @endforeach



                    @foreach($students as $s)

                    <div class="item col-md-3 col-sm-4">

                        <div class="wrap">

                            <div class="cover">

                                <?php $img = get_media($s->avatar,null,'thumbnail-2');  ?>


                                @if( $img )
                                <img data-src="{!!$img!!}" src="@theme_asset()img/thumb-load.jpg"  class="lazyload" alt="">
                                @else

                                <?php 
                                    $text = explode('-',str_slug($s->title));
                                 ?>
                                <span class="text">{!!strtoupper(substr(end($text), 0, 1))!!}</span>
                                <img src="@theme_asset()img/thumb-member.jpg" alt="">
                                @endif

                            </div>

                            <div class="info">

                                <div class="name">

                                    {!!$s->title!!}

                                </div>

                                <p class="title">{!!$s->description!!}</p>

                            </div>

                        </div>

                    </div>

                    @endforeach

                    {!!get_paginate($students)!!}


                </div>

            </div>
        </section>
    </main>

@stop