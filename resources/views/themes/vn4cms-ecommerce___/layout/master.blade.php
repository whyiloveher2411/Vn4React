<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<?php 
		vn4_head();
	 ?>

 	

	@yield('css')

</head>
<body {!!get_body_class()!!}>
	<div class="main-container" id="home">
		<div class="overlay"></div>
		
		<?php the_header(); ?>

		@yield('content')

		<?php the_footer(); ?>
	</div>
	<div class="loading-page">
        <div class="wrap">
            <img data-src="@theme_asset()img/loading.gif" alt="Loading">
        </div>
    </div>
	<script src="@theme_asset()js/lib/jquery.min.js"></script>
	<script src="@theme_asset()js/lib/slick/slick.min.js"></script>
	<script src="@theme_asset()js/lib/extension.js"></script>
	<script src="@theme_asset()js/main.js"></script>
	<script>
		$(window).on('load',function(){
			$('.slider-product .list').slick({
				infinite: false,
				slidesToShow: 5,
  				slidesToScroll: 5
			})
			
	 		setTimeout(function() {
	 			$('img[data-src]').each(function(index, el){
		 			$(el).attr('src',$(el).data('src'));
		 		});
	 		}, 10);
		});

	</script>

	 @yield('js')
</body>
</html>