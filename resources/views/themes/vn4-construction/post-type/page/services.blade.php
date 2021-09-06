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
    <!-- slider Area End-->
    <!-- Services Area Start -->
    <div class="services-area1 section-padding30">
        <div class="container">
            <!-- section tittle -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-tittle mb-55">
                        <div class="front-text">
                            <h2 class="">{!!$post->{'front-text'}!!}</h2>
                        </div>
                        <span class="back-text">{!!$post->{'back-text'}!!}</span>
                    </div>
                </div>
            </div>
            <div class="row">

                <?php  
                    $order = $post->order_data;

                    if( !isset($order['orderBy']) || !isset($order['orderType']) ){
                        $order = ['created_at','desc'];
                    }else{
                        $order = [$order['orderBy'],$order['orderType']];
                    }
                    

                    $services = get_posts('service',['count'=>100,'order'=>$order]);
                 ?>

                 @foreach($services as $s)
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="single-service-cap mb-30">
                        <a href="{!!$link = get_permalinks($s)!!}">
                            <div class="service-img">
                                <img src="{!!get_media($s->image,null,'listing')!!}" alt="">
                            </div>
                        </a>
                        <div class="service-cap">
                            <h4><a href="{!!$link!!}">{!!$s->title!!}</a></h4>
                            <a href="{!!$link!!}" class="more-btn">@__t('Explore more') <i class="ti-plus"></i></a>
                        </div>
                        <div class="service-icon">
                            <img src="@theme_asset()img/icon/services_icon1.png" alt="">
                        </div>
                    </div>
                </div>
                @endforeach

                
            </div>
        </div>
    </div>
    <!-- Services Area End -->
</main>
@stop