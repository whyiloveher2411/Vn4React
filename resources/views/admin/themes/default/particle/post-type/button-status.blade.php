@foreach( $filter as $key => $value)
	@if( !isset($value['items']) )
		@if( $value['count'] != 0 )
	        <button class="btn btn-sm post-status {!!$status_current[0] === $key?'btn-primary active':''!!}" type="button" data="{!!$key!!}"> {!!$value['title']!!} ({!!number_format($value['count'])!!})</button>
	    @endif
	@else
		@php
			$status_current2 = isset($status_current[1])?$status_current[1]:'';
		@endphp

		<div class="dropdown " style="display:inline-block;margin: 0 5px 0 0;">
		  <button style="font-weight: bold;" class="dropdown-toggle btn btn-sm dropdown-table {!!$status_current[0] === $key?'btn-primary active':''!!}" data-toggle="dropdown" role="button" aria-expanded="false">{!!$value['title']!!} <i class="fa fa-sort-desc" style="vertical-align: top;"></i></button>
		  <ul class="dropdown-menu" role="menu" style="margin-top:8px;">
				@foreach( $value['items'] as $key2 => $value2 )
					@if( $value2['count'] != 0 )
					<li class="post-status {!!$status_current2 === $key2?'active':''!!}" type="button" data="{!!$key,'.',$key2!!}"><a href="#" ><label>{!!$value2['title']!!} ({!!number_format($value2['count'])!!})</label></a></li>
			    	@endif
				@endforeach
			</ul>
		</div>

	@endif
@endforeach
