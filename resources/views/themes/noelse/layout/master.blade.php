<!DOCTYPE html>
<html {!!get_language_attributes()!!} >
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	@head

	@yield('css')

</head>
<body {!!get_body_class()!!}>

	@header

	@yield('content')

	@footer

 	@yield('js')

</body>
</html>
