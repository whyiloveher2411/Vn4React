<?php if( isset($sliders) ): ?>
<section class="uk-position-relative uk-visible-toggle uk-light"
    uk-slideshow="min-height: 300; max-height: 600;">
    <ul class="uk-slideshow-items">
        <li style="background-color: #0b0a12"><a href="#">
                <figure class="uk-container uk-height-1-1"><img src="/themes/vn4cms-ecommerce/images/promo/macbook-new.jpg"
                        alt="New Macbook" width="1200" height="600" uk-cover></figure>
            </a></li>
        <li style="background-color: #ce071e"><a href="#">
                <figure class="uk-container uk-height-1-1"><img src="/themes/vn4cms-ecommerce/images/promo/iphone.jpg" alt="iPhone"
                        width="1200" height="600" uk-cover></figure>
            </a></li>
        <li style="background-color: #1f2024"><a href="#">
                <figure class="uk-container uk-height-1-1"><img src="/themes/vn4cms-ecommerce/images/promo/ipad.jpg" alt="iPad"
                        width="1200" height="600" uk-cover></figure>
            </a></li>
    </ul><a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#"
        uk-slideshow-item="previous" uk-slidenav-previous></a><a
        class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slideshow-item="next"
        uk-slidenav-next></a>
    <div class="uk-position-bottom-center uk-position-small">
        <ul class="uk-slideshow-nav uk-dotnav"></ul>
    </div>
</section>
<?php endif; ?>