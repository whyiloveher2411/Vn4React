<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

use File;

class ImageController extends Controller {

   public function checkImage(Request $r){
        $url = $r->get('image');

        $url = str_replace(['../','/../'],'',$url);

        // if (File::exists($url))
        // {
            return response()->json(['result'=>asset($url)]);
        // }
        return response()->json(['error'=>'Không tồn tại file này.']);
   }

}
