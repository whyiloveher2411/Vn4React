<section class="ftco-section ftco-counter img" id="section-counter" style="background-image: url({!!get_media($data['background'])!!});">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            @forif( $data['counters'] as $couter)
            <div class="col-md-3 d-flex counter-wrap ftco-animate">
                <div class="block-18 d-flex align-items-center">
                    <div class="icon d-flex align-items-center justify-content-center"><span
                            class="{!!$couter['icon']!!}"></span></div>
                    <div class="text pl-3">
                        <strong class="number" data-number="{!!$couter['number']!!}">0</strong>
                        <span>{!!$couter['description']!!}</span>
                    </div>
                </div>
            </div>
            @endforif
        </div>
    </div>
</section>