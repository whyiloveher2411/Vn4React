<?php 
	title_head(__p('Languages',$plugin->key_word));

	$lang = languages();

	$lang_edit = ['lang_slug'=>'','lang_locale'=>'','lang_name'=>'','order'=>'','lang_list'=>'','dir'=>'','flag'=>'','country_name'=>'','text_direction'=>''];
	$flag_edit = 'src';
	$name_flag = '';


	$is_edit = false;

	if( Request::get('action') === 'edit' && $lang_edit_key = Request::get('lang') ){

		if( !isset($languages[$lang_edit['lang_locale']][4]) ){
			if( isset($lang[$lang_edit_key]) ){

				$lang_edit = $lang[$lang_edit_key];

				$flag_edit = 'src="'.plugin_asset($plugin,'flags/'.$languages[$lang_edit['lang_locale']][4].'.png').'"';
				$name_flag = $flags[$languages[$lang_edit['lang_locale']][4]];
				$is_edit = true;
			}
		}
	}
 ?>	


@extends(backend_theme('master'))
@section('css')
	<style>
		.icon-flag{
			cursor: pointer;
			text-align: left;
		    padding: .4em 10px .4em 10px;
		    display: block;
		    line-height: 23px;
		    overflow: hidden;
		    text-overflow: ellipsis;
		    white-space: nowrap;
	        background: #eee;
		    border: 1px solid #ddd;
		    box-shadow: 0 1px 2px rgba(0,0,0,.07) inset;
		    color: #32373c;
		    height: 36px;
		}
		.icon-flag .fa{
			float: right;
			margin-top: 2px;
		}
		.row-lang{

		}
		.row-lang .row-actions{
			display: none;
			position: absolute;
			bottom: 10px;
		}
		.row-lang:hover .row-actions, .row-lang:hover .change-language-default .fa{
			display: block;
		}
		.row-lang td{
			position: relative;
			padding-bottom: 30px !important;
		}
		.row-lang td a .fa{
			display: none;
			color:blue;
			cursor: pointer;
		}

	</style>
@stop
@section('content')


<div class="row">
	<div class="col-md-4 col-xs-12 wapper-panel col-left">
		<h4>{!!__p('Add new language',$plugin->key_word)!!}</h4>
		
		<form method="POST">
			<input type="hidden" value="{!!csrf_token()!!}" name="_token">
			<input type="hidden" value="{!!$lang_edit['flag']!!}" name="flag" id="flag">
			<input type="hidden" value="{!!$lang_edit['country_name']!!}" name="country_name" id="country_name">
			<input type="hidden" value="{!!$lang_edit['text_direction']!!}" name="text_direction" id="text_direction">

			<div class="form-group">
			    <label for="title"> {!!__p('Choose a language',$plugin->key_word)!!}</label>
			    <select name="lang_list" id="lang_list" class="form-control col-md-7 col-xs-12">
					<option value=""></option>
					@foreach($languages as $key=>$l)
					<option @if($key === $lang_edit['lang_locale']) selected @endif value="{!!$l[0],':',$l[1],':',$l[3],':',$l[4],':',$flags[$l[4]]!!}">{!!$l[2],' - ',$key!!}</option>
					@endforeach

			    </select>
		        <p class="note">You can choose a language in the list or directly edit it below.</p>
		  	</div>

		  	<div class="form-group">
		        <label for="lang_name"> Full name</label>
	            <input name="lang_name" required="" value="{!!$lang_edit['lang_name']!!}" readonly placeholder="" type="text" id="lang_name" class="form-control col-md-7 col-xs-12">
				<p class="note">The name is how it is displayed on your site (for example: English).</p>
	      	</div>

	      	<div class="form-group">
		        <label for="lang_locale"> Locale</label>
	            <input name="lang_locale" required="" value="{!!$lang_edit['lang_locale']!!}" readonly placeholder="" type="text" id="lang_locale" class="form-control col-md-7 col-xs-12">
				<p class="note">Vn4CMS Locale for the language (for example: en_US). You will need to install folder for this language.</p>
	      	</div>

	      	<div class="form-group">
		        <label for="lang_slug"> Language code</label>
	            <input name="lang_slug" required="" value="{!!$lang_edit['lang_slug']!!}" readonly placeholder="" type="text" id="lang_slug" class="form-control col-md-7 col-xs-12">
				<p class="note">Language code - preferably 2-letters ISO 639-1 (for example: en)</p>
	      	</div>

	      	<div class="form-group">
		        <label for="dir"> Text direction</label>
	            <input required="" value="{!!$lang_edit['text_direction']=='ltr'?'Left To Right':'Right To Left'!!}" readonly placeholder="" type="text" id="dir" class="form-control col-md-7 col-xs-12">
				<p class="note"> Choose the text direction for the language</p>
	      	</div>

	      	<div class="form-group">
		        <label for="title"> Flag</label>
	            <span class="icon-flag form-control">
	            	<img style="border-radius:0;margin-right: 5px;" id="img-flag" class="img-user icon-img" {!!$flag_edit!!}> <span id="flag-name">{!!$name_flag!!}</span> 
	            </span>
	            <div style="display:none;">
	            	
	            </div>
				<p class="note">Language code - preferably 2-letters ISO 639-1 (for example: en)</p>
	      	</div>

	      	<div class="form-group">
		        <label for="order"> Order</label>
	            <input name="order" required="" value="{!!$lang_edit['order']?:(count($lang) + 1)!!}" placeholder="" type="number" id="order" class="form-control col-md-7 col-xs-12">
				<p class="note">Position of the language in the language switcher</p>
	      	</div>
			
			<input type="submit" class="vn4-btn vn4-btn-blue btn-add-language" name="add-language" value="@if(!$is_edit){!!__p('Add new language',$plugin->key_word)!!}@else @__('Update') @endif">
		</form>

	</div>

	<div class="col-md-8 col-xs-12 wapper-panel col-right">
		<table id="datatable" class="table-responsive table table-striped table-bordered quan-table" style="background: #fff;">

			<thead>
				<tr>
					<th>Full name</th>
					<th>Locale</th>
					<th>Code</th>
					<th style="width:25px;"><i class="fa fa-star" aria-hidden="true"></i></th>
					<th style="width:25px;">Order</th>
					<th style="width:25px;">Flag</th>
				</tr>
			</thead>

			<tfoot>
				<tr>
					<th>Full name</th>
					<th>Locale</th>
					<th>Code</th>
					<th><i class="fa fa-star" aria-hidden="true"></i></th>
					<th>Order</th>
					<th>Flag</th>
				</tr>
			</tfoot>

			<tbody class="data_tbody_post body_trans">
				

				 @if( is_array($lang) )
					@forElse($lang as $key => $l)
						<tr class="row-lang">
							<td>
								<span class="lang-name">{!!$l['lang_name']!!}</span>
								<div class="row-actions">
									<strong>
									<a href="{!!route('admin.plugin.controller',['plugin'=>$plugin->key_word,'controller'=>'languages','method'=>'languages', 'action'=>'edit','lang'=>$key])!!}">Edit</a> | <a href="{!!route('admin.plugin.controller',['plugin'=>$plugin->key_word,'controller'=>'languages','method'=>'languages', 'action'=>'delete','lang'=>$key])!!}" class="delete-lang" style="color:red;">Delete</a>
									</strong>
								</div>
							</td>
							<td>{!!$l['lang_locale']!!}</td>
							<td>{!!$l['lang_slug']!!}</td>
							@if( $l['is_default'] )
							<td>
								<i class="fa fa-star" aria-hidden="true"></i>
							</td>
							@else
							<td class="change-language-default">
								<a href="{!!route('admin.plugin.controller',['plugin'=>$plugin->key_word,'controller'=>'languages','method'=>'languages', 'action'=>'default-lang','lang'=>$key])!!}"><i class="fa fa-star" aria-hidden="true"></i></a>
							</td>
							@endif
							<td>{!!$l['order']!!}</td>
							<td>
							@if( isset($languages[$l['lang_locale']][4]) )
								<img style="border-radius:0;margin-right: 5px;" id="img-flag" class="img-user icon-img" src="{!!plugin_asset($plugin,'flags/'.$languages[$l['lang_locale']][4].'.png')!!}">
							@endif
							</td>
						</tr>
						
					@empty
						<tr>
							<td colspan="100" style="text-align:center;">@__('No data available in table')</td>
						</tr>
					@endforElse
				@else
					<tr>
						<td colspan="100" style="text-align:center;">@__('No data available in table')</td>
					</tr>
				@endif
				
			</tbody>

		</table>
	</div>
</div>

@stop

@section('js')

	<script>
		$(window).load(function() {
			$(document).on('change','#lang_list',function(event) {
				var value = $(this).val();
				value = value.split(':');

				$('#lang_name').val($(this).find('option:selected').text().split(' - ')[0]);

				$('#text_direction').val(value[2]);

				if( value[2] == 'ltr' ){
					$('#dir').val('Left To Right');
				}else{
					$('#dir').val('Right To Left');
				}

				$('#lang_locale').val(value[1]);
				$('#lang_slug').val(value[0]);

				$('#flag-name').text(value[4]);
				$('#country_name').val(value[4]);

				$('#img-flag').attr('src','{!!plugin_asset($plugin)!!}/flags/'+value[3]+'.png');
				$('#flag').val(value[3]);



			});

			$(document).on('click','.delete-lang',function(event){

				event.stopPropagation();
				
				var r = confirm('@__('Are you sure you want to delete the') '+$(this).closest('td').find('.lang-name').text()+' @__('language?')');
            
                if (r != true) {
                	event.preventDefault();
                }
			});

		});
	</script>
@stop
