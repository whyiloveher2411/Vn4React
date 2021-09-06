<?php

return [
	'filemanager-create-thumbnail'=>function($r){
		$result = $r->get('value');

        if(  File::exists( $resources = backend_resources('particle/input_field/image/thumbnail.php') ) ){
            include $resources;
        }

        return response()->json(['value'=>$result]);
	},

	'filemanager-upload-file-direct'=>function($r){
		if( $r->hasFile('file') ){

            $public_path = cms_path();

            if( $r->has('type') && $admin_object = get_admin_object($r->get('type')) ){
                $folder =  'uploads/'.str_slug($admin_object['title']);
            }else{
                $folder = 'uploads/upload-direct/'.date('d-m-Y');
            }

            File::isDirectory($public_path.$folder) or File::makeDirectory($public_path.$folder, 0777, true, true);

            $file = $r->file('file');

            $result = [];

            if( is_array($file) ){

                foreach ($file as $image) {
                    $name = str_random(10).'_'.time().'_'.$image->getClientOriginalName();
                    $destinationPath = $public_path.$folder.'/';
                    $image->move($destinationPath, $name);
                    $result[] = asset($folder.'/'.$name);
                }
            }else{

                $image = $file;

                $name = str_random(10).'_'.time().'_'.$image->getClientOriginalName();
                $destinationPath = $public_path.$folder;
                $image->move($destinationPath, $name);
                $result[] = asset($folder.'/'.$name);
            }

            return response()->json(['files'=>$result]);

        }
	},

];