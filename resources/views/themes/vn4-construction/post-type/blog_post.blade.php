@extends(theme_extends())

@section('content')
<div class="slider-area ">
    <div class="single-slider hero-overly slider-height2 d-flex align-items-center" data-background="{!!get_media($post->background)!!}">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="hero-cap pt-100">
                        <h2>{!!$post->title!!}</h2>
                        <nav aria-label="breadcrumb ">
                            <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{!!route('index')!!}">@__t('Home')</a></li>
                            <li class="breadcrumb-item"><a href="{!!route('page','blog')!!}">@__t('Blog')</a></li> 
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
<section class="blog_area single-post-area section-padding">
  <div class="container">
     <div class="row">
        <div class="col-lg-8 posts-list">
           <div class="single-post">
              <div class="feature-img" style="text-align: center;">
                 <img class="img-fluid" src="{!!get_media($post->image)!!}" alt="">
              </div>
              <div class="blog_details">
                 <h2>{!!$post->description!!}
                 </h2>
                 <ul class="blog-info-link mt-3 mb-4">
                  <?php 
                      $category_detail = json_decode($post->category_detail,true);
                   ?>
                    <li><a href="{!!get_permalinks($category_detail)!!}"><i class="fa fa-user"></i> 
                       
                        {!!$category_detail['title']!!}</a></li>

                    </a></li>
                 </ul>
                {!!$post->content!!}
              </div>
           </div>
           <div class="navigation-top">
              <div class="d-sm-flex justify-content-between text-center">
                
                 <div class="col-sm-4 text-center my-2 my-sm-0">
                    <!-- <p class="comment-count"><span class="align-middle"><i class="fa fa-comment"></i></span> 06 Comments</p> -->
                 </div>
                 <ul class="social-icons">
                    <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                    <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                 </ul>
              </div>
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

@stop