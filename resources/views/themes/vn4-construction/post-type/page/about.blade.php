@extends(theme_extends())

<?php 
    $session = $post->section;
 ?>
@section('content')
 <main>
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
     @forswitch( $session as $s)
        @is('who-we-are')
            <section class="support-company-area fix pt-10 section-padding30">
                <div class="support-wrapper align-items-end">
                    <div class="left-content">
                        <!-- section tittle -->
                        <div class="section-tittle section-tittle2 mb-55">
                            <div class="front-text">
                                <h2 class="">{!!$s['front-text']!!}</h2>
                            </div>
                            <span class="back-text">{!!$s['back-text']!!}</span>
                        </div>
                        <div class="support-caption">
                            {!!$s['content']!!}
                            <a href="{!!get_link($s['link'])!!}" class="btn red-btn2">@__t('Explore more')</a>
                        </div>
                    </div>
                    <div class="right-content">
                        <!-- img -->
                        <div class="right-img">
                            <img src="{!!get_media($s['image'])!!}" alt="">
                        </div>
                        <div class="support-img-cap text-center">
                            {!!$s['text-image']!!}
                        </div>
                    </div>
                </div>
            </section>
        @endis
        @is('testimonial')
            <div class="testimonial-area t-bg testimonial-padding">
                <div class="container ">
                    <div class="row">
                        <div class="col-xl-12">
                            <!-- Section Tittle -->
                            <div class="section-tittle section-tittle6 mb-50">
                                <div class="front-text">
                                    <h2 class="">{!!$s['front-text']!!}</h2>
                                </div>
                                <span class="back-text">{!!$s['back-text']!!}</span>
                            </div>
                        </div>
                    </div>
                   <div class="row">
                        <div class="col-xl-10 col-lg-11 col-md-10 offset-xl-1">
                            <div class="h1-testimonial-active">

                                @forif($s['testimonial'] as $s2)
                                <div class="single-testimonial">
                                     <!-- Testimonial Content -->
                                    <div class="testimonial-caption ">
                                        <div class="testimonial-top-cap">
                                            <!-- SVG icon -->
                                            <svg xmlns="http://www.w3.org/2000/svg"xmlns:xlink="http://www.w3.org/1999/xlink"width="86px" height="63px">
                                            <path fill-rule="evenodd"  stroke-width="1px" stroke="rgb(255, 95, 19)" fill-opacity="0" fill="rgb(0, 0, 0)"
                                            d="M82.623,59.861 L48.661,59.861 L48.661,25.988 L59.982,3.406 L76.963,3.406 L65.642,25.988 L82.623,25.988 L82.623,59.861 ZM3.377,25.988 L14.698,3.406 L31.679,3.406 L20.358,25.988 L37.340,25.988 L37.340,59.861 L3.377,59.861 L3.377,25.988 Z"/>
                                            </svg>
                                            <p>{!!$s2['content']!!}</p>
                                        </div>
                                        <!-- founder -->
                                        <div class="testimonial-founder d-flex align-items-center">
                                           <div class="founder-text">
                                                <span>{!!$s2['name']!!}</span>
                                                <p>{!!$s2['title']!!}</p>
                                           </div>
                                        </div>
                                    </div>
                                </div>
                                @endforif
                               
                            </div>
                        </div>
                   </div>
                </div>
            </div>
        @endis
        @is('teams')
            <div class="team-area section-padding30">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            <!-- Section Tittle -->
                            <div class="section-tittle section-tittle5 mb-50">
                                <div class="front-text">
                                    <h2 class="">{!!$s['front-text']!!}</h2>
                                </div>
                                <span class="back-text">{!!$s['back-text']!!}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                       <?php 
                            $teams = get_posts('team',['callback'=>function($q) use ($s){
                                $q->whereIn('id',$s['teams'])->orderByRaw('FIELD(id, '.implode(',', $s['teams']).')');
                            }]);
                         ?>
                        @foreach($teams as $s2)
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-">
                            <div class="single-team mb-30">
                                <div class="team-img">
                                    <img src="{!!get_media($s2->image,null,'listing')!!}" alt="">
                                </div>
                                <div class="team-caption">
                                    <span>{!!$s2->title!!}</span>
                                    <h3>{!!$s2->position!!}</h3>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endis
    @endforswitch
</main>
@stop