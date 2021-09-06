<form method="POST">
	<input name="trans_core" value="1" type="hidden">

<?php 
$argTransKey = [];

$argTransValue = [];

$argTagFlag = [];

foreach ($langs as $k => $l) {
	if( !file_exists($file = cms_path('resource').'lang/'.$l['lang_slug'].'.php') ){
		File::put($file, '<?php return [];');
		$argTransFile = [];
	}else{
		$argTransFile = include $file;
	}

	$argTransValue[$k] = $argTransFile;

	$argTransKey = array_merge($argTransKey, $argTransFile);
}

foreach( $argTransKey as $k => $s){
	echo '<input type="hidden" value="'.e($k).'" name="key[]">';
}

foreach ($langs as $k => $l) {
	$argTagFlag[$l['lang_slug']] = [
		'title'=>'<img title="'.$l['lang_name'].'" style="" class="img-flag" src="'.plugin_asset($plugin,'flags/'.$l['flag'].'.png').'" /> '.$l['lang_name'],
		'content'=>function() use ($langs, $lang, $__env, $plugin, $k, $l, $argTransKey, $argTransValue ) {
			?>
				<table id="table-trans" class="table table-striped">
				 	<thead>
				 		<tr>
				 			<th style="width:50%;">String</th>
				 			<th>Translate</th>
				 		</tr>
				 	</thead>
				 	<tbody>

				 		<?php 
				 			$index = 0;
				 		 ?>
				 		@foreach( $argTransKey as $key => $value )

				 		<tr>
				 			<td>{!!$index + 1!!}. <code>{!!$key!!}</code></td>
				 			<td>

				 			@if( isset($argTransValue[$k][$key]) )
				 			<textarea name="value[{!!$l['lang_slug']!!}][{!!$index!!}]" class="form-control input-value">{!!$argTransValue[$k][$key]!!}</textarea>
				 			@else
				 			<textarea name="value[{!!$l['lang_slug']!!}][{!!$index!!}]" class="form-control input-value"></textarea>
				 			@endif

				 			</td>
				 		</tr>
				 		<?php ++$index; ?>
				 		@endforeach
				 	</tbody>
				 </table>
			<?php
		}
	];
}

?>
<input type="hidden" name="_token" value="{!!csrf_token()!!}">

<?php 
	vn4_tabs_top($argTagFlag,false,'core-lang');
 ?>
 <br>
 <input type="submit" name="" class="vn4-btn vn4-btn-blue">
 </form>
