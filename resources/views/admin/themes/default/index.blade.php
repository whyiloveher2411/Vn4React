@extends(backend_theme('master'))



<?php 

    title_head(__('Dashboard'));

 ?>

@section('content')

	<style type="text/css">

		.box-content{

			background: white;

			padding: 10px;

		}

	</style>

	<div id="newfeed"></div>

	

	<div id="content">

		 <div id="dashboard" class="data-iframe" data-name="dashboard" data-url="{!!route('admin.controller',['controller'=>'dashboard','method'=>'index','dashboard'=>Request::get('dashboard')])!!}"></div>

	</div>

@stop

