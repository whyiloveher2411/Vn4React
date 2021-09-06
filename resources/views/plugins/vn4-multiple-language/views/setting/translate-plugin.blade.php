<?php 
	add_action('vn4_head',function(){
		?>
			<style>
				.vn4_tabs_left .menu-left{
					width: 200px;
				}
				.vn4_tabs_left .content-right {
				    margin-left: 200px;
				}
				.vn4_tabs_left .menu-left li{
					text-align: left;
					padding: 0;
					margin: 0;
				}
				.vn4_tabs_left .menu-left li a{
					display: block;
					padding: 7px;
					border: 1px solid rgba(255, 255, 255, 0);
					border-right: none;

				}
				.vn4_tabs_left .menu-left li.active{
					border: none;
				}
				.vn4_tabs_left .menu-left li.active a{
					padding-left: 7px;
					border: 1px solid #ddd ;
					border-right: none;
				}
			</style>
		<?php
	},'plugin-multi-language-p-plugin',true);
 ?>

<form method="POST">
	<input name="trans_plugin" value="1" type="hidden">

<?php 


$list = File::directories(Config::get('view.paths')[0].'/plugins/');

$obj = new Vn4Model(vn4_tbpf().'setting');

$listPlugin = $obj->whereType('plugin')->where('status','publish')->pluck('key_word')->toArray();

$folder_plugin = Config::get('view.paths')[0].'/plugins/';

$count = count($listPlugin);

$list_tab_left = [];

for ($i=0; $i < $count; $i++) { 

	if( !file_exists( $fileName = $folder_plugin.$listPlugin[$i].'/rename.json') ) continue;

	$info = json_decode(File::get($fileName));

	$list_tab_left[$listPlugin[$i]] = [
		'content'=>function() use ($langs, $listPlugin, $i, $folder_plugin, $plugin ,$lang , $__env  ) {
			$argTransKey = [];

			if (!File::exists($folder_plugin.$listPlugin[$i].'/lang/'))
			{	
				File::makeDirectory($folder_plugin.$listPlugin[$i].'/lang/', 0777, true, true);
			}
					
			foreach ($langs as $k => $l) {

				if( !file_exists($file = $folder_plugin.$listPlugin[$i].'/lang/'.$l['lang_slug'].'.php') ){
					File::put($file, '<?php return [];');
					$argTransFile = [];
				}else{
					$argTransFile = include $file;
				}

				$argTransValue[$k] = $argTransFile;

				$argTransKey = array_merge($argTransKey, $argTransFile);
			}

			foreach( $argTransKey as $k => $s){
				echo '<input type="hidden" value="'.e($k).'" name="key['.$listPlugin[$i].'][]">';
			}
			echo '<script>document.getElementById("___count_word___'.$listPlugin[$i].'").innerHTML = " ('.count($argTransKey).')"</script>';

			$argTagFlag = [];
			
			foreach ($langs as $k => $l) {
				$argTagFlag[$l['lang_slug']] = [
					'title'=>'<img title="'.$l['lang_name'].'" style="" class="img-flag" src="'.plugin_asset($plugin,'flags/'.$l['flag'].'.png').'" /> '.$l['lang_name'],
					'content'=>function() use ($langs, $lang, $__env, $plugin, $k, $l, $argTransKey, $argTransValue, $listPlugin, $i ) {
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
							 			<textarea name="value[{!!$l['lang_slug']!!}][{!!$listPlugin[$i]!!}][{!!$index!!}]" class="form-control input-value">{!!$argTransValue[$k][$key]!!}</textarea>
							 			@else
							 			<textarea name="value[{!!$l['lang_slug']!!}][{!!$listPlugin[$i]!!}][{!!$index!!}]" class="form-control input-value"></textarea>
							 			@endif

							 			</td>
							 		</tr>
							 		<?php 
							 			++$index;
							 		 ?>
							 		@endforeach
							 	</tbody>
							 </table>
						<?php
					}
				];
			}

			vn4_tabs_top($argTagFlag,false,$listPlugin[$i]);
		},
		'title'=>$info->name.'<span id="___count_word___'.$listPlugin[$i].'"></span>',
	];

}
?>
<input type="hidden" name="_token" value="{!!csrf_token()!!}">
	<?php 
		vn4_tabs_left($list_tab_left,false,'plugin');
	 ?>
 <br>
 <input type="submit" name="" class="vn4-btn vn4-btn-blue">
 </form>
