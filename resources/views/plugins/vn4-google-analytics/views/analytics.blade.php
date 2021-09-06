@extends(backend_theme('master'))



@section('content')



<?php 

title_head( 'Google Analytics' );

?>
<div class="data-iframe" data-url="{!!route('google-analytics.report-item',['folder'=>'dashboard','view'=>'index'])!!}"></div>

@stop

