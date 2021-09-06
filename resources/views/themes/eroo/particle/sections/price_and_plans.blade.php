<section class="ftco-section bg-light">
    <div class="container">
      <div class="row justify-content-center mb-5">
        <div class="col-md-7 heading-section text-center ftco-animate">
          <span class="subheading">{!!$data['subheading']!!}</span>
          <h2>{!!$data['heading']!!}</h2>
        </div>
      </div>
      <div class="row">
        @forif( $data['price_list'] as $plan)
        <div class="col-md-4 ftco-animate">
          <div class="block-7">
            <div class="img" style="background-image: url({!!get_media($plan['image'])!!});"></div>
            <div class="p-4">
              <ul class="pricing-text mb-2">
                @forif( $plan['plans'] as $t)
                <li><span class="fa fa-check-circle mr-2"></span>{!!$t['title']!!}</li>
                @endforif
              </ul>
            </div>
            <div class="d-lg-flex align-items-center w-100 bg-light py-2 px-4">
              <span class="price"><sup>$</sup> <span class="number">{!!$plan['price']!!}</span> <sub>/mos</sub></span>
              <p class="w-100 mb-0">
                <a href="#" class="btn btn-primary d-block px-2 py-3">Get Started</a>
              </p>
            </div>
          </div>
        </div>
        @endforif
      </div>
    </div>
  </section>