@if( isset($field['list_option'][$value]) )
	<span @if(isset($field['list_option'][$value]['color'])) class="value-select" style="background: {!!$field['list_option'][$value]['color']!!};" @endif>{!!$field['list_option'][$value]['title']!!}</span>
@else
	<span class="value-select">{!!$value!!}</span>
@endif


