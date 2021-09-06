<!DOCTYPE html>
<html {!!get_language_attributes()!!} >

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	@head

	<link rel="stylesheet" href="@theme_asset()css/bootstrap.min.css">
    <link rel="stylesheet" href="@theme_asset()css/owl.carousel.min.css">
    <link rel="stylesheet" href="@theme_asset()css/slicknav.css">
    <link rel="stylesheet" href="@theme_asset()css/animate.min.css">
    <link rel="stylesheet" href="@theme_asset()css/magnific-popup.css">
    <link rel="stylesheet" href="@theme_asset()css/fontawesome-all.min.css">
    <link rel="stylesheet" href="@theme_asset()css/themify-icons.css">
    <link rel="stylesheet" href="@theme_asset()css/slick.css">
    <link rel="stylesheet" href="@theme_asset()css/nice-select.css">
    <link rel="stylesheet" href="@theme_asset()css/style.css">
    <meta name="csrf-token" content="{!! csrf_token() !!}">
	@yield('css')
</head>
<body {!!get_body_class()!!}>

<!-- 	<div id="preloader-active">
	    <div class="preloader d-flex align-items-center justify-content-center">
	        <div class="preloader-inner position-relative">
	            <div class="preloader-circle"></div>
	            <div class="preloader-img pere-text">
	                <img src="@theme_asset()img/logo/loder-logo.png" alt="">
	            </div>
	        </div>
	    </div>
	</div> -->

	@header

	@yield('content')

	@footer

    @if( !isset($_COOKIE['accept-cookies']))
    {!!get_particle('particle.cookie')!!}
    @endif

	<!-- All JS Custom Plugins Link Here here -->
    <script src="@theme_asset()js/vendor/modernizr-3.5.0.min.js"></script>
	<!-- Jquery, Popper, Bootstrap -->
	<script src="@theme_asset()js/vendor/jquery-1.12.4.min.js"></script>
    <script src="@theme_asset()js/popper.min.js"></script>
    <script src="@theme_asset()js/bootstrap.min.js"></script>
    <!-- Jquery Mobile Menu -->
    <script src="@theme_asset()js/jquery.slicknav.min.js"></script>

	<!-- Jquery Slick , Owl-Carousel Plugins -->
    <script src="@theme_asset()js/owl.carousel.min.js"></script>
    <script src="@theme_asset()js/slick.min.js"></script>
    <!-- Date Picker -->
    <script src="@theme_asset()js/gijgo.min.js"></script>
	<!-- One Page, Animated-HeadLin -->
    <script src="@theme_asset()js/wow.min.js"></script>
	<script src="@theme_asset()js/animated.headline.js"></script>
    <script src="@theme_asset()js/jquery.magnific-popup.js"></script>

	<!-- Scrollup, nice-select, sticky -->
    <script src="@theme_asset()js/jquery.scrollUp.min.js"></script>
    <script src="@theme_asset()js/jquery.nice-select.min.js"></script>
	<script src="@theme_asset()js/jquery.sticky.js"></script>
           
    <!-- counter , waypoint -->
    <script src="@theme_asset()js/waypoints.min.js"></script>
    <script src="@theme_asset()js/jquery.counterup.min.js"></script>

    <!-- contact js -->
    <script src="@theme_asset()js/jquery.form.js"></script>
    <script src="@theme_asset()js/jquery.validate.min.js"></script>
    
	<!-- Jquery Plugins, main Jquery -->	
    <script src="@theme_asset()js/plugins.js"></script>
    <script src="@theme_asset()js/main.js"></script>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(window).load(function(){

            setTimeout(function() {
                $('img[data-src]').each(function(index, el){
                    $(el).attr('src',$(el).data('src'));
                });
            }, 10);

            $(document).on('submit','.f-ajax',function(event){
                event.preventDefault();
                $this = $(this);

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    dataType:'Json',
                    data: $(this).serialize(),
                    success:function(result){

                        if( result.message ){
                            alert(result.message);
                        }
                        
                        if( result.error ){

                            for( var key in result.error ){
                                $this.find('.input-'+key).after('<label for="message" class="error">'+result.error[key].join('<br>')+'</label>');
                            }

                            return;
                            
                        }else{
                            alert('@__('Subscribe to newsletter successfully!')');
                        }

                    }
                });
            });
        });
    </script>
 	@yield('js')

</body>

</html>
