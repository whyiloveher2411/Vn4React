<!DOCTYPE html>
<html {!!get_language_attributes()!!} >
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	@head

	<link
		href="https://fonts.googleapis.com/css2?family=Arizonia&amp;family=Roboto:wght@300;400;500;700;900&amp;display=swap"
		rel="stylesheet">
	<link
		href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&amp;display=swap"
		rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="@theme_asset()css/animate.css">
	<link rel="stylesheet" href="@theme_asset()css/owl.carousel.min.css">
	<link rel="stylesheet" href="@theme_asset()css/owl.theme.default.min.css">
	<link rel="stylesheet" href="@theme_asset()css/magnific-popup.css">
	<link rel="stylesheet" href="@theme_asset()css/flaticon.css">
	<link rel="stylesheet" href="@theme_asset()css/style.css">

	@yield('css')

</head>
<body {!!get_body_class()!!}>

	@header

	@yield('content')

	@footer

	<div id="ftco-loader" class="show fullscreen">
		<svg class="circular" width="48px" height="48px">
			<circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
			<circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10"
				stroke="#F96D00" />
		</svg>
	</div>

	<script src="@theme_asset()js/jquery.min.js"></script>
	<script src="@theme_asset()js/jquery-migrate-3.0.1.min.js"></script>
	<script src="@theme_asset()js/popper.min.js"></script>
	<script src="@theme_asset()js/bootstrap.min.js"></script>
	<script src="@theme_asset()js/jquery.easing.1.3.js"></script>
	<script src="@theme_asset()js/jquery.waypoints.min.js"></script>
	<script src="@theme_asset()js/jquery.stellar.min.js"></script>
	<script src="@theme_asset()js/owl.carousel.min.js"></script>
	<script src="@theme_asset()js/jquery.magnific-popup.min.js"></script>
	<script src="@theme_asset()js/jquery.animateNumber.min.js"></script>
	<script src="@theme_asset()js/scrollax.min.js"></script>
	<script src="@theme_asset()js/main.js"></script>


 	@yield('js')

</body>
</html>
