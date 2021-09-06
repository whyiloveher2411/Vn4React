<section class="hero-wrap">
    <div class="home-slider owl-carousel js-fullheight">
        @forif( $data['slider'] as $slider)
        <div class="slider-item js-fullheight" style="background-image:url({!!get_media($slider['background'])!!});">
            <div class="overlay"></div>
            <div class="container">
                <div class="row d-flex no-gutters slider-text js-fullheight align-items-center align-items-stretch">
                    <div class="col-md-7 ftco-animate d-flex align-items-center">
                        <div class="text w-100 mt-5">
                            <span class="subheading">{!!$slider['subheading']!!}</h2></span>
                            <h1>{!!$slider['heading']!!}</h1>
                            <p class="mb-4">{!!$slider['description']!!}</p>
                            <p>
                                @forif( $slider['buttons'] as $button)
                                    <a href="#" class="btn {!!$button['type']!!}">{!!$button['label']!!}</a>
                                @endforif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforif
    </div>
</section>