@extends(theme_extends())

<?php 
    
    $session = $post->section;

    $data = cache_tag('home',App::getLocale(), function() use ($session) {

        $data = [];

        foreach ($session as $index => $s) {
            if( !$s['delete'] ){
                switch ($s['type']) {
                    case 'services':
                        $data['service'.$index] = get_posts('service',['callback'=>function($q) use ($s){
                            $q->whereIn('id',$s['services'])->orderByRaw('FIELD(id, '.implode(',', $s['services']).')');
                        }]);
                    case 'projects':
                        $data['project'.$index] = get_posts('project_post',['count'=>6]);
                        break;
                    case 'teams':
                        $data['teams'.$index] = get_posts('team',['callback'=>function($q) use ($s){
                            $q->whereIn('id',$s['teams'])->orderByRaw('FIELD(id, '.implode(',', $s['teams']).')');
                        }]);
                        break;
                    case 'blogs':
                        $data['blogs'.$index] = get_posts('blog_post',['callback'=>function($q) use ($s){
                            $q->whereIn('id',$s['blogs']);
                        }]);
                }
            }
            # code...
        }
        return $data;
    });

  
 ?>
@section('content')

<style type="text/css">
	/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content/Box */
.modal-content {
  background-color: #fefefe;
  margin: 15% auto; /* 15% from the top and centered */
  padding: 20px;
  border: 1px solid #888;
  width: 80%; /* Could be more or less, depending on screen size */
}

/* The Close Button */
.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}

</style>
<main>

    @forswitch( $session as $index => $s)

        @is('slider')
            <div class="slider-area ">
                <div class="slider-active">
                    @forif($s['slider'] as $s2)
                    <div class="single-slider  hero-overly slider-height d-flex align-items-center" data-background="{!!get_media($s2['background'])!!}">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-11">
                                    <div class="hero__caption">
                                        <div class="hero-text1">
                                            <span data-animation="fadeInUp" data-delay=".3s">{!!$s2['title-top']!!}</span>
                                        </div>
                                        <h1 data-animation="fadeInUp" data-delay=".5s">{!!$s2['line-1']!!}</h1>
                                        <div class="stock-text" data-animation="fadeInUp" data-delay=".8s">
                                            <h2>{!!$s2['line-2']!!}</h2>
                                            <h2>{!!$s2['line-2']!!}</h2>
                                        </div>
                                        <div class="hero-text2 mt-110" data-animation="fadeInUp" data-delay=".9s">
                                           <span><a href="{!!get_link($s2['link'])!!}">{!!$s2['title-bottom']!!}</a></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforif
                </div>
            </div>
        @endis
        @is('services')
            <div class="services-area1 section-padding30">
                <div class="container">
                    <!-- section tittle -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="section-tittle mb-55">
                                <div class="front-text">
                                    <h2 class="">{!!$s['front-text']!!}</h2>
                                </div>
                                <span class="back-text">{!!$s['back-text']!!}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <?php 
                            $services = $data['service'.$index];
                         ?>

                        @foreach($services as $s2)

                        <div class="col-xl-4 col-lg-4 col-md-6">
                            <div class="single-service-cap mb-30">
                                <div class="service-img">
                                    <a href="{!!$link = get_permalinks($s2)!!}"><img data-src="{!!get_media($s2->image,null,'listing')!!}" alt=""></a>
                                </div>
                                <div class="service-cap">
                                    <h4><a href="{!!$link!!}">{!!$s2['title']!!}</a></h4>
                                    <a href="{!!$link!!}" class="more-btn">@__t('Explore more') <i class="ti-plus"></i></a>
                                </div>
                                <div class="service-icon">
                                    <img data-src="@theme_asset()img/icon/services_icon1.png" alt="">
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
        @endis
        @is('who-we-are')
             <section class="support-company-area fix pt-10">
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
                            <img data-src="{!!get_media($s['image'])!!}" alt="">
                        </div>
                        <div class="support-img-cap text-center">
                            {!!$s['text-image']!!}
                        </div>
                    </div>
                </div>
            </section>
        @endis
        @is('projects')
            <section class="project-area  section-padding30">
                <div class="container">
                   <div class="project-heading mb-35">
                        <div class="row align-items-end">
                            <div class="col-xl-12">
                                <!-- Section Tittle -->
                                <div class="section-tittle section-tittle3">
                                    <div class="front-text">
                                        <h2 class="">{!!$s['front-text']!!}</h2>
                                    </div>
                                    <span class="back-text">{!!$s['back-text']!!}</span>
                                </div>
                            </div>
                        </div>
                   </div>
                    <div class="row">
                        <div class="col-12">
                            <!-- Nav Card -->
                            <div class="tab-content active" id="nav-tabContent">
                                

                                <div class="tab-pane fade active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">           
                                    <div class="project-caption">
                                        <div class="row">
                                             <?php 
                                                $projects = $data['project'.$index];
                                             ?>
                                            @foreach($projects as $p)

                                            <div class="col-lg-4 col-md-6">
                                                <div class="single-project mb-30">
                                                    <a href="{!!$link = get_permalinks($p)!!}">
                                                        <div class="project-img">
                                                            <img data-src="{!!get_media($p->image,null,'listing')!!}" alt="">
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
                                    </div>
                                </div>
                               
                            </div>
                        <!-- End Nav Card -->
                        </div>
                    </div>
                </div>
            </section>
        @endis
        @is('lats-talk-with-us')
            <section class="contact-with-area" data-background="{!!get_media($s['background'])!!}">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-8 col-lg-9 offset-xl-1 offset-lg-1">
                            <div class="contact-us-caption">
                                <div class="team-info mb-30 pt-45">
                                    <!-- Section Tittle -->
                                    <div class="section-tittle section-tittle4">
                                        <div class="front-text">
                                            <h2 class="">{!!$s['front-text']!!}</h2>
                                        </div>
                                        <span class="back-text">{!!$s['back-text']!!}</span>
                                    </div>
                                    <p>{!!$s['content']!!}</p>
                                    <a href="{!!get_link($s['link'])!!}" class="white-btn">@__t('Explore more')</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endis
        @is('counter')
            <div class="count-area">
                <div class="container">
                    <div class="count-wrapper count-bg" data-background="@theme_asset()img/gallery/section-bg3.jpg">
                        <div class="row justify-content-center" >
                            @forif($s['counter'] as $s2)
                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <div class="count-clients">
                                    <div class="single-counter">
                                        <div class="count-number">
                                            <span class="counter">{!!$s2['counter']!!}</span>
                                        </div>
                                        <div class="count-text">
                                            {!!$s2['description']!!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforif
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
                            $teams = $data['teams'.$index];
                         ?>
                        @foreach($teams as $s2)
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-">
                            <div class="single-team mb-30">
                                <div class="team-img">
                                    <img data-src="{!!get_media($s2->image,null,'listing')!!}" alt="">
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

        @is('popup')
		<!-- Trigger/Open The Modal -->

		<div style="display: flex;justify-content: center;align-items: center;margin: 50px">			
		<button id="myBtn" style="    padding: 20px 40px;font-size: 26px;">{!!$s['button']!!}</button>
		</div>

		<!-- The Modal -->
		<div id="myModal" class="modal">

		  <!-- Modal content -->
		  <div class="modal-content">
		    <span class="close">&times;</span>
		    <p>{!!$s['content']!!}</p>
		  </div>

		</div>

        @endis
        @is('blogs')
            <div class="latest-news-area section-padding30">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            <!-- Section Tittle -->
                            <div class="section-tittle section-tittle7 mb-50">
                                <div class="front-text">
                                    <h2 class="">{!!$s['front-text']!!}</h2>
                                </div>
                                <span class="back-text">{!!$s['back-text']!!}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <?php 
                            $blogs =  $data['blogs'.$index];
                         ?>

                         @foreach($blogs as $b)
                         <?php 
                            $category = get_post('blog_category',$b->category);
                          ?>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <!-- single-news -->
                            <div class="single-news mb-30">
                                <a href="{!!$link = get_permalinks($b)!!}">
                                <div class="news-img">
                                    <img data-src="{!!get_media($b->image)!!}" alt="">
                                    <div class="news-date text-center">
                                        <span>{!!get_date($b->created_at,'d')!!}</span>
                                        <p>{!!get_date($b->created_at,'F')!!}</p>
                                    </div>
                                </div>
                                </a>
                                <div class="news-caption">
                                    <ul class="david-info">
                                        @if($category)
                                        <li> | &nbsp; &nbsp;  {!!$category->title!!}</li>
                                        @endif
                                    </ul>
                                    <h2><a href="{!!$link!!}">{!!$b->title!!}</a></h2>
                                    <a href="{!!$link!!}" class="d-btn">@__t('Explore more') »</a>
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

@section('js')
	<script type="text/javascript">
		// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on the button, open the modal
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
	</script>
@stop