<?php
    $author = $post->relationship('blog_author');
    $category = $post->relationship('blog_category');
?>
<div class="item display-between">
    <div class="left flex">
        <a href="{!!$link = get_permalinks($post)!!}">
            <h2 class="title-2">{!!$post->title!!}</h2>
        </a>
        <div class="info">
            <div class="dif">
                @if($author)<span><a href="{!!get_permalinks($author)!!}">{!!$author->title!!}</a></span><span class="dot"></span>@endif 
                @if($category)<a href="{!!get_permalinks($category)!!}"><span>{!!$category->title!!}</span></a>@endif
                <span class="dot"></span><span class="time">{!!get_date($post->created_at)!!}</span><span class="dot"></span><span>4 min read</span>

            </div>
        </div>
        <p class="description">{!!$post->description!!}</p>
        <a href="{!!$link!!}" class="btn-read">Tiếp tục đọc <img src="@theme_asset()img/right-arrow.svg" alt=""></a>
    </div>
    <div class="right">
        <a href="{!!$link!!}">
            <img class="thumbnail" src="{!!get_media($post->thumbnail,null,'listting')!!}" alt="">
        </a>
    </div>
</div>