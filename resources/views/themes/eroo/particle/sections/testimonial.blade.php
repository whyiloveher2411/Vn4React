<section class="ftco-section testimony-section ftco-no-pt bg-light">
    <div class="overlay"></div>
    <div class="container">
        <div class="row pb-4">
            <div class="col-md-7 heading-section ftco-animate">
                <span class="subheading">{!!$data['subheading']!!}</span>
                <h2 class="mb-4">{!!$data['heading']!!}</h2>
            </div>
        </div>
    </div>
    <div class="container-fluid px-lg-5">
        <div class="row ftco-animate">
            <div class="col-md-12">
                <div class="carousel-testimony owl-carousel">
                    @forif( $data['testimonial'] as $testimonial)
                    <div class="item">
                        <div class="testimony-wrap py-4">
                            <div class="text">
                                <p class="mb-4">{!!$testimonial['content']!!}</p>
                                <div class="d-flex align-items-center">
                                    <div class="user-img" style="background-image: url({!!get_media($testimonial['avata'])!!})"></div>
                                    <div class="pl-3">
                                        <p class="star">
                                            <span class="fa fa-star"></span>
                                            <span class="fa fa-star"></span>
                                            <span class="fa fa-star"></span>
                                            <span class="fa fa-star"></span>
                                            <span class="fa fa-star"></span>
                                        </p>
                                        <p class="name">{!!$testimonial['name']!!}</p>
                                        <span class="position">{!!$testimonial['position']!!}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforif
                </div>
            </div>
        </div>
    </div>
</section>