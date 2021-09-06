@extends(backend_theme('master'))

@section('content')

{!!view('themes.'.theme_name().'.backend.'.$page.'.'.$page)!!}

@stop