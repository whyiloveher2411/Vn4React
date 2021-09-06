<section class="ftco-section ftco-services">
    <div class="container">
        <div class="row">
            <div class="col-md-6 d-flex align-self-stretch ftco-animate">
                <div class="pb-4 heading-section heading-section-white">
                    <h2 class="mb-3">{!!$data['title']!!}</h2>
                    <p class="mb-4">{!!$data['description']!!}</p>
                </div>
            </div>

            @forif( $data['services'] as $service )
            <div class="col-md-3 d-flex align-self-stretch ftco-animate">
                <div class="services {!! @$service['active'] ? 'active' : ''!!}">
                    <div class="d-flex justify-content-end">
                        <div class="icon d-flex"><span class="{!!$service['icon']!!}"></span></div>
                    </div>
                    <div class="media-body">
                        <h3 class="heading mb-3">{!!$service['title']!!}</h3>
                    </div>
                    <a href="{!!$service['link']!!}" class="btn-custom d-flex align-items-center justify-content-center">
                        <span class="fa fa-chevron-right"></span>
                    </a>
                </div>
            </div>
            @endforif
        </div>
    </div>
</section>