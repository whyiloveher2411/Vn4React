@extends(theme_extends())
@section('content')

<?php 
    $theme_option = theme_options('page','blog');

    if( isset($theme_option) ){
        $blog = get_post('page',$theme_option);

        if( $blog ){
            $background = get_media($blog->background);
            $number_of_post_in_each_page = $blog->number_of_post_in_each_page;
        }

    }


 ?>
<!-- slider Area Start-->
<div class="slider-area ">
    <div class="single-slider hero-overly slider-height2 d-flex align-items-center" data-background="{!!$background!!}">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="hero-cap pt-100">
                        <h2>{!!$post->title!!}</h2>
                        <nav aria-label="breadcrumb ">
                            <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{!!route('index')!!}">@__t('Home')</a></li>
                            <li class="breadcrumb-item"><a href="#">{!!$post->title!!}</a></li> 
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- slider Area End-->
<!--================Blog Area =================-->
<section class="blog_area section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mb-5 mb-lg-0">
                <div class="blog_left_sidebar">

                    <?php 
                        $posts = $post->related('blog_post','tag',[
                            'count'=>$number_of_post_in_each_page,'paginate'=>__t('page')
                        ]);
                     ?>

                     @forelse($posts as $p)
                    <article class="blog_item">
                        <div class="blog_item_img">
                            <img class="card-img rounded-0" src="{!!get_media($p->image,null,'listing')!!}" alt="">
                            <a href="{!!$link = get_permalinks($p)!!}" class="blog_item_date">
                                <h3>{!!get_date($p->created_at,'d')!!}</h3>
                                <p>{!!get_date($p->created_at,'F')!!}</p>
                            </a>
                        </div>

                        <div class="blog_details">
                            <a class="d-inline-block" href="{!!$link!!}">
                                <h2>{!!$p->title!!}</h2>
                            </a>
                            <p>{!!$p->description!!}</p>
                            <ul class="blog-info-link">
                                <li><a href="{!!$link!!}"><i class="fa fa-user"></i> 

                                <?php 
                                    $category_detail = json_decode($p->category_detail,true);
                                 ?>
                                {!!$category_detail['title']!!}</a></li>
                            </ul>
                        </div>
                    </article>
                    @empty
                    <p style="text-align: center;font-size: 28px;">Post Not Found.</p>
                    @endforelse

                    {!!get_paginate($posts,'default')!!}
                </div>
            </div>
            <div class="col-lg-4">
                <div class="blog_right_sidebar">
                    {!!get_sidebar('sidebar-primary','primary')!!}
                </div>
            </div>
        </div>
    </div>
</section>
<!--================Blog Area =================-->
@stop