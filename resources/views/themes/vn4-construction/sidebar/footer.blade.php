<?php 
	$widgets = json_decode($sidebar->content,true);
 ?>

 @foreach($widgets as $w)
 @switch($w['type'])

 	@case('info')
 	 <div class="col-lg-4 col-md-4 col-sm-8">
        <div class="single-footer-caption mb-30">
            <div class="footer-logo">
                <a href="{!!route('index')!!}"><img src="{!!get_media(theme_options('general','logo'))!!}" alt=""></a>
            </div>
            <div class="footer-tittle">
                <div class="footer-pera">
                    <p class="info1">{!!$w['data']['description']!!}</p>
                </div>
            </div>
        </div>
    </div>
 	@break
 	@case('quick-link')
 	<div class="col-lg-2 col-md-4 col-sm-5">
        <div class="single-footer-caption mb-50">
            <div class="footer-tittle">
                <h4>{!!$w['data']['title']!!}</h4>

                {!!vn4_nav_menu_db( $w['data']['links'],'menu-footer-widget',[],App::getLocale().'menu-footer-widget')!!}

            </div>
        </div>
    </div>
 	@break

 	@case('contact')
 	<div class="col-lg-3 col-md-4 col-sm-7">
        <div class="single-footer-caption mb-50">
            <div class="footer-tittle">
                <h4>{!!$w['data']['title']!!}</h4>

                

                <div class="footer-pera">
                    <p class="info1">{!!theme_options('contact','address')!!}</p>
                </div>
                <ul>
                    <li><a href="#">Phone: {!!theme_options('contact','phone')!!}</a></li>
                    <li><a href="#">Email: {!!theme_options('contact','email')!!}</a></li>
                </ul>
            </div>
        </div>
    </div>
 	@break
 	@case('newsletter')
 	<div class="col-lg-3 col-md-6 col-sm-8">
        <div class="single-footer-caption mb-50">
            <!-- Form -->
            <div class="footer-form">
                <div id="mc_embed_signup">
                    <form action="{!!route('post',['controller'=>'newsletter','method'=>'post'])!!}" method="POST" class="f-ajax " novalidate="true">
                        <input type="email" name="email" name="email" id="newsletter-form-email" placeholder="@__t('Email Address')" class="placeholder hide-on-focus" onfocus="this.placeholder = ''" onblur="this.placeholder = '@__('Email Address')'">
                        <div class="form-icon">
                            <button type="submit" name="submit" id="newsletter-submit" class="email_icon newsletter-submit button-contactForm input-title">
                                @__t('SIGN UP')
                            </button>
                        </div>
                        <div class="mt-10 info"></div>
                    </form>
                </div>
            </div>
            <!-- Map -->
            <div class="map-footer">
                <img src="{!!get_media($w['data']['map'])!!}" alt="">
            </div>
        </div>
    </div>
 	@break
 @endswitch

 @endforeach