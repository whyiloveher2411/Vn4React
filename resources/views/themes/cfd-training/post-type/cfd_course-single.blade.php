<?php 
    $teachers = $post->relationship('cfd_teacher');
    $thumbnail = get_media($post->thubnail);

    $status = ['da-ket-thuc'=>['title'=>'Đã kết thúc','color'=>'#797979'],'dang-dien-ra'=>['title'=>'Đang diễn ra','color'=>'#f4744b'],'sap-khai-gian'=>['title'=>'Sắp khai giảng','color'=>'#5a46ff']];
?>

<div class="col-md-4 course">
    <div class="wrap">
        <a class="cover" href="{!!$link = get_permalinks($post)!!}">
            <img  src="@theme_asset()img/thumb-load.jpg" class="lazyload" data-src="{!!$thumbnail!!}" alt="">
            <!-- <img src="@theme_asset()img/thumb-load.jpg" alt=""> -->

            @if( $post->course_status )
            <span class="badge b1" style="background: {!!$status[$post->course_status]['color']!!}">{!!$status[$post->course_status]['title']!!}</span>
            @endif

            <div class="hover">
                <!-- <div class="top">
                    <div class="user">
                        <img src="@theme_asset()img/icon-user-white.svg" alt="">
                        12</div>
                    <div class="heart">
                        <img src="@theme_asset()img/icon-heart.svg" alt=""> 100
                    </div>
                </div>
                <div class="share">
                    <img src="@theme_asset()img/icon-viewmore.svg" alt="">
                </div> -->
            </div>
        </a>
        <div class="info">
            <a class="name" href="{!!$link!!}">
                {!!$post->title!!}
            </a>
            <p class="des">
                {!!$post->short_description!!}
            </p>
        </div>
        <div class="bottom">
             @foreach($teachers as $t)
            <div class="teacher">
                <div class="avatar">
                    <img data-src="{!!get_media($t->avatar,null,'thubnail-1')!!}" src="@theme_asset()img/thumb-load.jpg" class="lazyload" alt="">
                </div>
                <div class="name">{!!$t->title!!}</div>
            </div>
            @endforeach

             @if( $post->course_status === 'sap-khai-gian')
            <a class="register-btn" href="{!!route('page',['page'=>'dang-ky','id'=>$post->id])!!}">Đăng Ký</a>
            @else
            <a class="register-btn" href="{!!$link!!}">Chi tiết</a>
            @endif
        </div>
    </div>
</div>

