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
                                <li class="breadcrumb-item"><a href="{!!route('page','service')!!}">@__t('Service')</a></li> 
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- slider Area End-->
    <!-- Services Details Start -->
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
    <!-- Services Details End -->
</main>
@stop