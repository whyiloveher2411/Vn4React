<header>
    <!-- Header Start -->
   <div class="header-area header-transparent">
        <div class="main-header ">
            <div class="header-top d-none d-lg-block">
               <div class="container-fluid">
                   <div class="col-xl-12">
                        <div class="row d-flex justify-content-between align-items-center">
                            <div class="header-info-left">

                                <ul>     
                                    <li><a href="tel:{!!$phone = theme_options('contact','phone')!!}">{!!$phone!!}</a></li>
                                    <li><a href="mailto:{!!$email = theme_options('contact','email')!!}">{!!$email!!}</a></li>
                                    <li>{!!theme_options('contact','openTime')!!}</li>
                                </ul>
                            </div>
                            <div class="header-info-right">
                                <ul class="header-social">    

                                    <?php 
                                        $social = theme_options('contact','social');
                                     ?>

                                    @forif($social as $s)
                                    <li><a target="_blank" rel="nofollow" href="{!!$s['link']!!}" title="{!!$s['title']!!}"><i class="fab {!!$s['icon']!!}"></i></a></li>
                                    @endforif
                                </ul>
                            </div>
                        </div>
                   </div>
               </div>
            </div>
           <div class="header-bottom  header-sticky">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <!-- Logo -->
                        <div class="col-xl-2 col-lg-2 col-md-1">
                            <div class="logo">
                                <!-- logo-1 -->
                                <a href="{!!route('index')!!}" class="big-logo"><img src="{!!get_media(theme_options('general','logo'))!!}" alt=""></a>
                                <!-- logo-2 -->
                                <a href="{!!route('index')!!}" class="small-logo"><img src="{!!get_media(theme_options('general','loder-logo'))!!}" alt=""></a>
                            </div>
                        </div>
                        <div class="col-xl-8 col-lg-8 col-md-8">
                            <!-- Main-menu -->
                            <div class="main-menu f-right d-none d-lg-block">
                                <nav> 
                                    <ul id="navigation">                                                                                                                   
                                    {!!vn4_nav_menu('header','nav-header')!!}
                                    <?php 
                                        if( is_callable('the_languages') ){
                                          $the_languages = the_languages();
                                          $language = App::getLocale();
                                          ?>
                                          <li class="nav-item dropdown">
                                              <a href="#" class="dropdown-toggle"><img style="margin-top: -3px;" src="{!!$the_languages[$language]['flag_image']!!}">&nbsp;&nbsp;&nbsp;{!!$the_languages[$language]['lang_name']!!}</a>
                                                <ul class="submenu">
                                                    @foreach($the_languages as $l)
                                                    @if(!$l['active'])
                                                    <li><a href="{!!$l['url']!!}"><img style="margin-right: 5px;margin-top: -3px;" src="{!!$l['flag_image']!!}"> {!!$l['lang_name']!!}</a></li>
                                                    @endif
                                                    @endforeach
                                                </ul>
                                          </li>
                                         <?php
                                        }
                                      ?>
                                      </ul>
                                </nav>
                            </div>
                        </div>             
                        <div class="col-xl-2 col-lg-2 col-md-3">
                            <div class="header-right-btn f-right d-none d-lg-block">

                              <?php 
                                $button_header = theme_options('general','button-header')
                               ?>

                                @if( isset($button_header['link']) )
                                  <a href="{!!get_link($button_header['link'])!!}" class="btn">{!!$button_header['label']!!}</a>
                                @endif
                            </div>
                        </div>
                        <!-- Mobile Menu -->
                        <div class="col-12">
                            <div class="mobile_menu d-block d-lg-none"></div>
                        </div>
                    </div>
                </div>
           </div>
        </div>
   </div>
    <!-- Header End -->
</header>
