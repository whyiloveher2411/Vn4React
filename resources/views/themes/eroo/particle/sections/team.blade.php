<section class="ftco-section">
    <div class="container">
        <div class="row no-gutters pb-5 justify-content-between">
            <div class="col-md-7 col-lg-6 heading-section ftco-animate">
                <span class="subheading">{!!$data['subheading']!!}</span>
                <h2 class="mb-4">{!!$data['heading']!!}</h2>
            </div>
            <div class="col-md-3 col-lg-2 d-flex align-items-center">
                <a href="#" class="btn-custom">View All Members <span class="fa fa-chevron-right"></span></a>
            </div>
        </div>
    </div>
    <div class="container container-2">
        <div class="row no-gutters justify-content-center">
            @forif( $data['teams'] as $people )
            <div class="col-md-4 col-lg ftco-animate d-flex">
                <div class="staff">
                    <div class="img-wrap d-flex align-items-stretch">
                        <div class="img d-flex align-items-center"
                            style="background-image: url({!!get_media($people['avata'])!!});">
                            <div class="text w-100 pt-3 px-3 pb-4 text-center">
                                <h3>{!!$people['name']!!}</h3>
                                <span class="position">{!!$people['position']!!}</span>
                                <div class="faded">
                                    <ul class="ftco-social text-center">
                                        @forif( $people['contact'] as $contact )
                                        <li class="ftco-animate"><a href="{!!$contact['link']!!}" class="d-flex align-items-center justify-content-center">
                                            <span class="{!!$contact['icon']!!}"></span>
                                            </a>
                                        </li>
                                        @endforif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforif
        </div>
    </div>
</section>