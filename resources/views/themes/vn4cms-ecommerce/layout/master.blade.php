<!DOCTYPE html>
<html {!!get_language_attributes()!!} >
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		@head
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,500">
		<link rel="stylesheet" href="@theme_asset()styles/style.css">
		<script src="@theme_asset()scripts/uikit.js"></script>
		<script src="@theme_asset()scripts/uikit-icons.js"></script>
		@yield('css')
	</head>
	<body {!!get_body_class()!!}>
		<div class="uk-offcanvas-content">
			@header
			@yield('content')
			@footer
		</div>
		
		<script src="@theme_asset()scripts/script.js"></script>
		@yield('js')
	</body>
</html>
