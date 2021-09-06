<div id="screen-meta">
	
	<?php 
		$list_screen = vn4_one_or(do_action('list_screen'),[]);
	 ?>

	@if(is_array($list_screen))	
	@foreach($list_screen as $id => $screen)
		<div  class="screen-meta-warp {!!$id!!}">
			{!!$screen['html_screen']!!}
		</div>
	@endforeach
	@endif

</div>

<div class="conduct">
	<div id="screen-meta-links">
		
		@if(is_array($list_screen))
		@foreach($list_screen as $id => $screen)
			<div class="screen-warp-button">
				<button type="button" class="button show-settings" aria-controls="{!!$id!!}" id="{!!$id!!}" aria-expanded="false">{!!$screen['title_button']!!}</button>
			</div>
		@endforeach
		@endif

	</div>
</div>