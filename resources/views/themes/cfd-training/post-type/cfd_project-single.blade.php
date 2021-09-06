<?php 
    $student = $post->relationship('cfd_student');

    $col = $col??'col-md-6 course';
?>

<div class="{!!$col!!}">
    <div class="wrap">
        <a href="#" class="cover">
            <img data-src="{!!get_media($post->thubnail,null,'thubnail-1')!!}" src="@theme_asset()img/thumb-load.jpg" class="lazyload" alt="">
        </a>
        <div class="info">
            <a href="#" class="name">{!!$post->title!!}</a>
            <p class="des">{!!$post->description!!}</p>
        </div>
        <div class="bottom">
            <div class="teacher">
                <div class="avatar">
                    <img data-src="{!!get_media($student->avatar,null,'thumbnail-1')!!}" src="@theme_asset()img/thumb-load.jpg" class="lazyload" alt="">
                </div>
                <div class="name">{!!$student->title!!}</div>
            </div>
            <div class="register-btn">Website</div>
        </div>
    </div>
</div>