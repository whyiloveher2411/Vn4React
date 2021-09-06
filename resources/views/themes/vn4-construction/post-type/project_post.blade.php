@extends(theme_extends())
<?php 
    $cat = get_post('project_category',$post->category);
 ?>
@section('content')
<main>
    <div class="slider-area ">
        <div class="single-slider hero-overly slider-height2 d-flex align-items-center" data-background="{!!get_media( $post->background,get_media($cat->background))!!}">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="hero-cap pt-100">
                            <h2>{!!$post->title!!}</h2>
                            <nav aria-label="breadcrumb ">
                                <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{!!route('index')!!}">@__t('Home')</a></li>
                                @if( $cat )
                                <li class="breadcrumb-item"><a href="{!!get_permalinks($cat)!!}">{!!$cat->title!!}</a></li> 
                                @endif
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="services-details-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="single-services section-padding2">
                        {!!$post->content!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@stop
