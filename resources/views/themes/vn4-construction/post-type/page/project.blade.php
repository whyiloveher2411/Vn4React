@extends(theme_extends())
@section('content')
 <main>
    <!-- slider Area Start-->
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
                                <li class="breadcrumb-item"><a href="#">{!!$post->title!!}</a></li> 
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="project-area  section-padding30">
        <div class="container">
           <div class="project-heading mb-35">
                <div class="row align-items-end">
                    <div class="col-lg-12">
                        <div class="section-tittle section-tittle3">
                            <div class="front-text">
                                <h2 class="">{!!$post->{'front-text'}!!}</h2>
                            </div>
                            <span class="back-text">{!!$post->{'back-text'}!!}</span>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="properties__button" style="float: none;">
                            <nav> 
                                <?php 
                                    $project_category = get_posts('project_category',['order'=>['id','asc']]);
                                    $projects = get_posts('project_post',['count'=>$post->number_of_projects_in_each_page,'paginate'=>__t('page')]);
                                 ?>

                                <div class="nav nav-tabs" id="nav-tab" role="tablist" style="justify-content: left;">
                                    @foreach($project_category as $c)
                                    <a class="nav-item nav-link" href="{!!get_permalinks($c)!!}"> {!!$c->title!!}</a>
                                    @endforeach
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
           </div>
            <div class="row">
                <div class="col-12">
                    <div class="tab-content active" id="nav-tabContent">
                        <div class="tab-pane fade active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">           
                            <div class="project-caption">
                                <div class="row">

                                    @foreach($projects as $p)
                                    <div class="col-lg-4 col-md-6">
                                        <div class="single-project mb-30">
                                            <a href="{!!$link = get_permalinks($p)!!}">
                                                <div class="project-img">
                                                    <img src="{!!get_media($p->image,null,'listing')!!}" alt="">
                                                </div>
                                            </a>
                                            <div class="project-cap">
                                                <a href="{!!$link!!}" class="plus-btn"><i class="ti-plus"></i></a>
                                                <h4><a href="{!!$link!!}">{!!$p->title!!}</a></h4>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                {!!get_paginate($projects,'default')!!}
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@stop