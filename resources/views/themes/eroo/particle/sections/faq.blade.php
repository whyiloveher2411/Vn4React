<section class="ftco-section ftco-faqs services-section bg-light">
    <div class="overlay"></div>
    <div class="container">
        <div class="row d-flex">
            <div class="col-md-6 mb-5 md-md-0 order-md-last">
                <div class="img w-100 mb-4" style="background-image: url({!!get_media($data['content_right']['image'])!!});"></div>
                <h2 class="heading-section2 mb-5">{!!$data['content_right']['heading']!!}</h2>
                <div class="row">
                    @forif( $data['content_right']['skill'] as $skill )
                    <div class="col-md-12 animate-box">
                        <div class="progress-wrap ftco-animate">
                            <h3>{!!$skill['title']!!}</h3>
                            <div class="progress">
                                <div class="progress-bar color-1" role="progressbar" aria-valuenow="{!!$skill['progress']!!}"
                                    aria-valuemin="0" aria-valuemax="100" style="width:{!!$skill['progress']!!}%">
                                    <span>{!!$skill['progress']!!}%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforif
                </div>
            </div>
            <div class="col-md-6 heading-section pr-md-5 ftco-animate d-flex align-items-center">
                <div class="w-100 mb-4 mb-md-0">
                    <span class="subheading">{!!$data['content_left']['subheading']!!}</span>
                    <h2 class="mb-5">{!!$data['content_left']['heading']!!}</h2>
                    <div id="accordion" class="myaccordion w-100" aria-multiselectable="true">
                        
                        @forif( $data['content_left']['q&a'] as $faq)
                        <div class="card">

                            <div class="card-header p-0" id="headingTwo" role="tab">
                                <h2 class="mb-0">
                                    <button href="#collapseTwo"
                                        class="d-flex py-3 px-4 align-items-center justify-content-between btn btn-link"
                                        data-parent="#accordion" data-toggle="collapse" aria-expanded="false"
                                        aria-controls="collapseTwo">
                                        <p class="mb-0">{!!$faq['question']!!}</p>
                                        <i class="fa" aria-hidden="true"></i>
                                    </button>
                                </h2>
                            </div>
                            <div class="collapse" id="collapseTwo" role="tabpanel" aria-labelledby="headingTwo">
                                <div class="card-body py-3 px-0">
                                {!!$faq['anwser']!!}
                                </div>
                            </div>
                        </div>
                        @endforif

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>