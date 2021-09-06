$.ajax({
	@if(isset($url))
	url: {!!$url!!},
	@endif
	type: '{!!isset($type)?$type:'POST'!!}',
	dataType: 'Json',
	data: {
		_token:'{!!csrf_token()!!}',
		@if( isset($data))
		@foreach($data as $key=>$value)
			{!!$key!!}:{!!$value!!},
		@endforeach
		@endif

	},

	@if( isset($show_loadding) && $show_loadding )
	beforeSend:function(){
      $('html').addClass('show-popup');
  	},
  	@endif
  
	success:function(data){
		if(data.url_redirect){
			window.location.href = data.url_redirect;
		}

		if(data.message){
			alert(data.message);
		}

		if( data.reload ){
			location.reload();
		}

		if(data.error){
			alert('Error');
		}

		if(data.success){
			alert('Success');
		}

		if(data.append){
			htmls = data.append;
			for(i = 0 ; i<htmls.length; i++ ){
				$(htmls[i].selector).append(htmls[i].html);
			}
		}

		{!!isset($function)?$function():''!!}
		
		@if( isset($show_loadding) && $show_loadding )
			$('html').removeClass('show-popup');
		@endif
	}
});
