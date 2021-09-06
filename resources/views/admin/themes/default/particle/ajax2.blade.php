$.ajax({
	@if(isset($url))
	url: {!!$url!!},
	@endif
	type: '{!!isset($type)?$type:'POST'!!}',
	dataType: 'Json',
	data: {!!$data!!},
	success:function(data){
		if(data.url_redirect){
			window.location.href = data.url_redirect;
		}

		if(data.message){
			alert(data.message);
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
	}
});
