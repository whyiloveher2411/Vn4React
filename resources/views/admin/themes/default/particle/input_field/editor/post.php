<?php

use_module('read_html');

if( Request::get('_download_image_'.$key) ){

	function isexternal($url) {
		return strrpos(strtolower($url),URL::to('/') ) === false;
	}

	$content_html = $input[$key];

	$html = str_get_html($content_html);

	if( $html ){

		$imgs = $html->find('img');

		foreach ($imgs as $i => $img) {
			if( is_url($img->src) && isexternal($img->src) ){

				File::isDirectory(cms_path().'uploads/'.str_slug($type)) or File::makeDirectory(cms_path().'uploads/'.str_slug($type), 0777, true, true);

				$fileinfo = pathinfo($img->src);

				if( isset($input['slug']) ){
					$name = $input['slug'];
				}else{
					$name = $fileinfo['filename'];
				}

				$name2 = $name;

				$index = 2;

				while ( file_exists(cms_path().'uploads/'.str_slug($type).'/'.$name2.'.'.$fileinfo['extension'] ) ) {
					$name2  = $name.'-'.$index;
					$index++;
				}

				$name = $name2.'.'.$fileinfo['extension'];

				if( ini_get('allow_url_fopen') ){
					file_put_contents( cms_path().'uploads/'.str_slug($type).'/'.$name , file_get_contents($img->src));
				}else{
					$ch = curl_init($img->src);
					$fp = fopen(cms_path().'uploads/'.str_slug($type).'/'.$name, 'wb');
					curl_setopt($ch, CURLOPT_FILE, $fp);
					curl_setopt($ch, CURLOPT_HEADER, 0);
					curl_exec($ch);
					curl_close($ch);
					fclose($fp);
				}

				$img2 = new simple_html_dom('');

                $img2 = $img2->createTextNode($imgs[ $i ]);

                $img2->src = '../../uploads/'.str_slug($type).'/'.$name;

                $content_html = str_replace($imgs[ $i ], $img2, $content_html);

			}
		}

	}

	$input[$key] = $content_html;


}

$input[$key] = get_content_html($input[$key]);
