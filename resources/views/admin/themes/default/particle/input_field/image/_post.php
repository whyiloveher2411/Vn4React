<?php

if( isset($value['thumbnail']) ){

	if( !function_exists('resizePng') ){

		function get_image_mime_type($image_path)
		{
		    $mimes  = array(
		        IMAGETYPE_GIF => "image/gif",
		        IMAGETYPE_JPEG => "image/jpg",
		        IMAGETYPE_PNG => "image/png",
		        IMAGETYPE_SWF => "image/swf",
		        IMAGETYPE_PSD => "image/psd",
		        IMAGETYPE_BMP => "image/bmp",
		        IMAGETYPE_TIFF_II => "image/tiff",
		        IMAGETYPE_TIFF_MM => "image/tiff",
		        IMAGETYPE_JPC => "image/jpc",
		        IMAGETYPE_JP2 => "image/jp2",
		        IMAGETYPE_JPX => "image/jpx",
		        IMAGETYPE_JB2 => "image/jb2",
		        IMAGETYPE_SWC => "image/swc",
		        IMAGETYPE_IFF => "image/iff",
		        IMAGETYPE_WBMP => "image/wbmp",
		        IMAGETYPE_XBM => "image/xbm",
		        IMAGETYPE_ICO => "image/ico");

		    if (($image_type = exif_imagetype($image_path))
		        && (array_key_exists($image_type ,$mimes)))
		    {
		        return $mimes[$image_type];
		    }
		    else
		    {
		        return FALSE;
		    }
		}


		function resizePng($image, $max_width, $max_height) {

			if( $max_width === 0 ) $max_width = null;
			if( $max_height === 0 ) $max_height = null;

		    $w = imagesx($image); //current width
		    $h = imagesy($image); //current height
		    if ((!$w) || (!$h)) { $GLOBALS['errors'][] = 'Image couldn\'t be resized because it wasn\'t a valid image.'; return false; }
		 
		    if (($w <= $max_width) && ($h <= $max_height)) { return $image; } //no resizing needed
		 
		    //try max width first...
		    $ratio = $max_width / $w;
		    $new_w = $max_width;
		    $new_h = $h * $ratio;
		 
		    //if that didn't work
		    if ($new_h > $max_height) {
		        $ratio = $max_height / $h;
		        $new_h = $max_height;
		        $new_w = $w * $ratio;
		    }
		    $newImg = imagecreatetruecolor($new_w, $new_h);
		    imagealphablending($newImg, false);
		    imagesavealpha($newImg, true);
		    $transparent = imagecolorallocatealpha($newImg, 255, 255, 255, 127);
		    imagefilledrectangle($newImg, 0, 0, $w, $h, $transparent);
		    imagecopyresampled($newImg, $image, 0, 0, 0, 0, $new_w, $new_h, $w, $h);
		    return $newImg;
		}
		function resizeJpeg($image,$max_width,$max_height) {

			if( $max_width === 0 ) $max_width = null;
			if( $max_height === 0 ) $max_height = null;

		    $w = imagesx($image); //current width
		    $h = imagesy($image); //current height
		    if ((!$w) || (!$h)) { $GLOBALS['errors'][] = 'Image couldn\'t be resized because it wasn\'t a valid image.'; return false; }
		 
		    if (($w <= $max_width) && ($h <= $max_height)) { return $image; } //no resizing needed
		 
		    //try max width first...
		    $ratio = $max_width / $w;
		    $new_w = $max_width;
		    $new_h = $h * $ratio;
		 
		    //if that didn't work
		    if ($new_h > $max_height) {
		        $ratio = $max_height / $h;
		        $new_h = $max_height;
		        $new_w = $w * $ratio;
		    }
		 
		    $new_image = imagecreatetruecolor ($new_w, $new_h);
		    imagefill($new_image,0,0,0x7fff0000);
		    imagecopyresampled($new_image,$image, 0, 0, 0, 0, $new_w, $new_h, $w, $h);
		    return $new_image;
		}

		function resize_crop_image($max_width, $max_height, $source_file, $dst_dir, $quality = 80){
		    $imgsize = getimagesize($source_file);
		    $width = $imgsize[0];
		    $height = $imgsize[1];
		    $mime = $imgsize['mime'];

		    switch($mime){
		        case 'image/gif':
		            $image_create = "imagecreatefromgif";
		            $image = "imagegif";
		            break;

		        case 'image/png':
		            $image_create = "imagecreatefrompng";
		            $image = "imagepng";
		            $quality = 7;
		            break;

		        case 'image/jpeg':
		            $image_create = "imagecreatefromjpeg";
		            $image = "imagejpeg";
		            $quality = 80;
		            break;

		        default:
		            return false;
		            break;
		    }

		    $dst_img = imagecreatetruecolor($max_width, $max_height);
		    $src_img = $image_create($source_file);

		    $width_new = $height * $max_width / $max_height;
		    $height_new = $width * $max_height / $max_width;
		    //if the new width is greater than the actual width of the image, then the height is too large and the rest cut off, or vice versa
		    if($width_new > $width){
		        //cut point by height
		        $h_point = (($height - $height_new) / 2);
		        //copy image
		        imagecopyresampled($dst_img, $src_img, 0, 0, 0, $h_point, $max_width, $max_height, $width, $height_new);
		    }else{
		        //cut point by width
		        $w_point = (($width - $width_new) / 2);
		        imagecopyresampled($dst_img, $src_img, 0, 0, $w_point, 0, $max_width, $max_height, $width_new, $height);
		    }

		    $image($dst_img, $dst_dir, $quality);

		    if($dst_img)imagedestroy($dst_img);
		    if($src_img)imagedestroy($src_img);
		}

	}
	$image = get_media($input[ $key ]);

	if( $image ){

		$thumbnail = [];

		$value_input = json_decode($input[ $key ],true);

		$info = pathinfo($image);

		$extension = get_image_mime_type($image);

		$param_route = Route::current()->parameters();

		if( isset($param_route['type']) && $admin_object = get_admin_object($param_route['type'])){
			$dir_upload = 'uploads/'.str_slug($admin_object['title']).'/thumbnail/';
		}else{
			$dir_upload = 'uploads/thumbnail/';
		}

		File::isDirectory(cms_path('public',$dir_upload)) or File::makeDirectory(cms_path('public',$dir_upload), 0777, true, true);

		// $dir_upload = cms_path('public',$dir_upload).'/';

		foreach ($value['thumbnail'] as $k => $v) {
			if( $v['type'] === 1 ){

				$width = isset($v['width'])?$v['width']:0;
				$height = isset($v['height'])?$v['height']:0;

				if( $extension === 'image/jpg' ){

					$filename = $dir_upload.$info['filename'].'-'.$k.'-'.$width.'x'.$height.'.jpg';

					resize_crop_image($width, $height, $info['dirname'].'/'.$info['basename'], cms_path('public',$filename));

					$thumbnail[$k] = $filename;
					
				}elseif( $extension === 'image/png' ){

					$filename = $dir_upload.$info['filename'].'-'.$k.'-'.$width.'x'.$height.'.png';

					resize_crop_image($width, $height, $info['dirname'].'/'.$info['basename'], cms_path('public',$filename));

					$thumbnail[$k] = $filename;

				}
			}else{

				$max_width = isset($v['max_width'])?$v['max_width']:0;
				$max_height = isset($v['max_height'])?$v['max_height']:0;

				if( $extension === 'image/jpg' ){
					$img=imagecreatefromjpeg($info['dirname'].'/'.$info['basename']);
					$img = resizeJpeg($img,$max_width,$max_height);
					$filename = $dir_upload.$info['filename'].'-'.$k.'-'.$max_width.'x'.$max_height.'.jpg';
					imagejpeg( $img, cms_path('public',$filename ));
					$thumbnail[$k] = $filename;


				}elseif( $extension === 'image/png' ){
					$img=imagecreatefrompng($info['dirname'].'/'.$info['basename']);
					$img = resizePng($img,$max_width,$max_height);
					$filename = $dir_upload.$info['filename'].'-'.$k.'-'.$max_width.'x'.$max_height.'.png';
					imagepng( $img, cms_path('public',$filename ));
					$thumbnail[$k] = $filename;
				}
			}
		}

		$value_input['thumbnail'] = $thumbnail;

		$input[$key] = json_encode($value_input);
	}
}
