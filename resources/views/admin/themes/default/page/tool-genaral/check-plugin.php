<?php 
if( $r->has('plugin') && $r->has('update-now') ){

	$url = 'http://dev.dna.vn/cms_dev2/public/uploads/update-plugin.zip';

	$file_zip = cms_path('resource','views/plugins/'.$r->get('plugin').'/update-plugin.zip');

	$fh = fopen( $file_zip, 'w');
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url); 
	curl_setopt($ch, CURLOPT_FILE, $fh); 
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_exec($ch);
	curl_close($ch);
	fclose($fh);

	$zip = zip_open($file_zip);
	$dir = dirname($file_zip);
	if ($zip) {
	  while ($zip_entry = zip_read($zip)) {

	  	$file = zip_entry_name($zip_entry);

	  	if( strpos($file, '.') === false ){

	  		if (!file_exists($dir.'/'.$file)) {
			    mkdir($dir.'/'.$file, 0777, true);
			}

	  	}else{
	  		 $fp = fopen(rtrim($dir.'/'.zip_entry_name($zip_entry),'/'), "w");
		    if (zip_entry_open($zip, $zip_entry, "r")) {
		      $buf = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
		      fwrite($fp,"$buf");
		      zip_entry_close($zip_entry);
		      fclose($fp);
		    }
	  	}
	   
	  }
	  zip_close($zip);
	}

	return redirect()->route('admin.page','plugin');
}

$data = json_decode(file_post_contents_curl(Crypt::decrypt("eyJpdiI6Im1HNWl6cERSdjdES1VOS1BhbFwvR3VBPT0iLCJ2YWx1ZSI6IkwxWW1NS0dWZkdDTFIrMzdwbnZIamRPeWdYVzNaRm5PejY3QTdGTU91SFZVVkJmaURKUDR0Z0EydTlsZnA1amsiLCJtYWMiOiI3N2IwYjkyMmY4OWM5Nzg2NTMxZDdhMzAzNjUzYzgwYWU5N2U0YTIwNTZmZTgwMWE0ZTI1M2E0M2I3NGRjZGFlIn0="),['url'=>Request::fullUrl()]),true);

if( !is_array($data) ) $data = [];
?>
<head>
</head>
<body style="height: 0;margin:0;display:inline-block;width:100%;" id="body">
	<script>
		var isInIframe = (window.location != window.parent.location) ? true : false;
		if( isInIframe ){
			<?php 
				$list = File::directories(Config::get('view.paths')[0].'/plugins/');

				foreach ($list as $value) {

				    $folder_name = explode(DIRECTORY_SEPARATOR, $value);

				    $folder_name = end($folder_name);

				    $fileName = $value.'/info.json';

				    if( !file_exists( $fileName ) ){

				        continue;

				    }

				    $info = json_decode(File::get($fileName));

				    if( isset($data[$folder_name]) &&  $info->version !== $data[$folder_name]['version'] ){

				    	$message = $data[$folder_name]['message'];
						if( isset($data[$folder_name]['route']) ){
							foreach ($data[$folder_name]['route'] as $k2 => $v2) {
								$message = str_replace('##'.$k2.'##', route($v2[0],$v2[1]), $message);
							}
						}

				    	?>
				    	window.parent.document.getElementById('tr_<?php echo $folder_name; ?>').style.display = "table-row";
						window.parent.document.getElementById('td_<?php echo $folder_name; ?>').innerHTML+='<div class="notify-plugin" style="border-left-color:<?php echo $data[$folder_name]['color'] ?> !important;"><?php echo $message; ?></div>'; 
						<?php
				    }

				}

			 ?>
		}else{
			window.location.href = '<?php echo route('admin.page','plugin'); ?>';
		}
	</script>
<body>
<?php
return '&nbsp;';
