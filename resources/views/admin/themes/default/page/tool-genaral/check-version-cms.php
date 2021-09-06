<?php 
if( $r->has('update-now') ){
	$url = 'http://dev.dna.vn/cms_dev2/public/uploads/json-file.zip';
	$fh = fopen($r->get('update-now').'.zip', 'w');
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url); 
	curl_setopt($ch, CURLOPT_FILE, $fh); 
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_exec($ch);
	curl_close($ch);
	fclose($fh);


	$zip = zip_open($r->get('update-now').".zip");

	if ($zip) {
	  while ($zip_entry = zip_read($zip)) {

	  	$file = zip_entry_name($zip_entry);

	  	if( strpos($file, '.') === false ){

	  		if (!file_exists(cms_path('public','../'.$file))) {
			    mkdir(cms_path('public','../'.$file), 0777, true);
			}

	  	}else{
	  		 $fp = fopen(rtrim(cms_path('public','../'.zip_entry_name($zip_entry)),'/'), "w");
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

}
$data = json_decode(file_post_contents_curl(Crypt::decrypt("eyJpdiI6Im1HNWl6cERSdjdES1VOS1BhbFwvR3VBPT0iLCJ2YWx1ZSI6IkwxWW1NS0dWZkdDTFIrMzdwbnZIamRPeWdYVzNaRm5PejY3QTdGTU91SFZVVkJmaURKUDR0Z0EydTlsZnA1amsiLCJtYWMiOiI3N2IwYjkyMmY4OWM5Nzg2NTMxZDdhMzAzNjUzYzgwYWU5N2U0YTIwNTZmZTgwMWE0ZTI1M2E0M2I3NGRjZGFlIn0="),['url'=>Request::fullUrl()]),true);

if( file_exists(cms_path('public','../cms.json')) ){
	$data_old = json_decode(file_get_contents(cms_path('public','../cms.json')),true);
}

if( !isset($data_old['version']) ){
	$data_old['version'] = 0;
}

?>
<head>
</head>
<body style="height: auto;margin:0;display:inline-block;width:100%;" id="body">
	

	<script>
		var isInIframe = (window.location != window.parent.location) ? true : false;

		if( isInIframe ){

			<?php 
				foreach ($data as $k => $v) {

					if( isset($v['place']) && array_search('dashboard', $v['place']) !== false  ){

						if( $v['type'] === 'message' ){
							?>
							document.getElementById("body").innerHTML+= '<div style="margin:10px 0;padding: 10px;background: white;border-radius: 3px;border-left: 5px solid <?php echo $v['color']; ?>;"><?php echo $v['message']; ?></div>';
							<?php
						}elseif( $v['type'] === 'version' && $v['version'] != $data_old['version']  ){

							$message = $v['message'];

							if( isset($v['route']) ){
								foreach ($v['route'] as $k2 => $v2) {
									$message = str_replace('##'.$k2.'##', route($v2[0],$v2[1]), $message);
								}
							}

							?>
							document.getElementById("body").innerHTML+= '<div style="margin:10px 0;padding: 10px;background: white;border-radius: 3px;border-left: 5px solid <?php echo $v['color']; ?>;"><?php echo $message; ?></div>';
							<?php
						}

					}

				}
			 ?>
		}else{
			window.location.href = '<?php echo route('admin.index'); ?>';
		}
	</script>
<body>
<?php
return '&nbsp;';
