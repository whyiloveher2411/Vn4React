<style>
	.table-theme-location{
		width: 100%;
		border: 1px solid #e5e5e5;
		background: #fff;

	}
	.table-theme-location th{
		border-bottom: 1px solid #e1e1e1;
		line-height: 1.4em;
	    height: 36px;
		padding: 10px;
	}
	.table-theme-location tr td{
		color: #555;
		font-size: 13px;
		font-size: 13px;
    	line-height: 1.5em;
	    height: 36px;
		padding: 8px;
	}
	.table-theme-location tr td:first-child{
		width: 35%;
	}
	.table-theme-location select{
		 max-width: 100%;
		 width: auto;
		 height: 28px;
	}
	.table-theme-location label{
		margin: 0;
	}
	.table-theme-location *{
		color: #555;
	}
</style>

<div class="row">
	<div class="col-md-8">

		<?php 
			
			$menusFilter = apply_filter('register_nav_menus',[]);
	        $menusFilter2 = do_action('register_nav_menus',$menusFilter);

	        if( $menusFilter2 ) $menusFilter = $menusFilter2;

	        $menus = (new Vn4Model(vn4_tbpf().'menu'))->where('status',1)->where('theme',theme_name())->get();

	        $menu2 = [];

	        $menu3 = [];

	        $option = '<option value="">-- Select a Menu --</option>';

	        foreach ($menus as $value) {
	        	if( $value->type === 'menu'){
	        		$menu2[$value->key_word] = $value;
	        	}else{
	        		$menu3[] = $value;
	        		$option .= '<option value="'.$value->id.'">'.$value->title.'</option>';
	        	}
	        }
		 ?>
		<p>Your theme supports {!!count($menusFilter)!!} menus. Select which menu appears in each location.</p>
		<table class="table-theme-location">
			<thead>
				<tr>
					<th>Theme Location</th>
					<th>Assigned Menu</th>
				</tr>
			</thead>

			<tbody>
				<?php 
					$keys = array_keys($menusFilter);
					$count = count($keys);
				 ?>

				 @foreach($keys as $index => $key)
				 	@if( $menusFilter[$key] === 'no-menu' )
					
					@else

					<?php 
						$dk = $index === $count - 1? false :  ($menusFilter[$keys[$index+1]] === 'no-menu' ? true : false );
					 ?>
					<tr>
						<td @if($dk) style="border-bottom: 1px solid #dedede;" @endif ><label for="">{!!$menusFilter[$key]!!}</label></td>
						<td @if($dk) style="border-bottom: 1px solid #dedede;" @endif><select class="form-control chose-menu" @if(isset($menu2[$key])) name="{!!$key!!}" data-trigger="{!!$menu2[$key]->content!!}"  @endif >
							{!!$option!!}
						</select></td>
					</tr>
					@endif

				 @endforeach
			</tbody>
		</table>
		<hr style="margin: 5px;">
		<button type="button" id="save_changes" class="vn4-btn vn4-btn-blue">@__('Save Changes')</button>
	</div>
</div>

<?php
add_action('vn4_footer',function(){
	?>
		<script>
			$(window).load(function() {
				$('.chose-menu').each(function(index, el) {
					if( $(el).data('trigger') ){
						$(el).find('option[value='+$(el).data('trigger')+']').prop('selected',true);
					}
				});

				$('body').on('click', '#save_changes', function(event) {
					event.preventDefault();
					
					var menus = {};
					$('.chose-menu').each(function(index, el) {
						key = $(el).attr('name');
						value = $(el).val();

						menus[key] = value;
					});

					console.log(menus);

					vn4_ajax({

						data:{
							manage_location:menus,
						}
					});

				});
			});
		</script>
	<?php
});