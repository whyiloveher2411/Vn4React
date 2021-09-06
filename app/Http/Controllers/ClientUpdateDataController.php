<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

use File;

use App\Module\EventAfterSave;

use Session;

use App\ModelParent;

class ClientUpdateDataController extends Controller {

  private $data_client_up;

   public function index(Request $r, $type){

        include 'cms/data_client_up.php';

        $this->data_client_up = (object)$arg;

        if(!isset($this->data_client_up->$type)){
            dd('Không tồn tại Tag type: '.$type);
        }

        $checkUnique = $this->checkUnique($r, $type);

        if(!empty($checkUnique)){
            return response()->json(['listMessage'=>$checkUnique]);
        }

        $obj = new ModelParent($this->data_client_up->{$type}['table']);

        $input = $this->handlingInput($r,$type);

        if(isset($input['error'])){
            if($r->ajax()){
                return response()->json(['message'=>$input['message']]);
            }

            return redirect()->back()->withErrors($input['listMessage']);
        }

        $obj->fillDynamic($input);

        $obj->type = $type;

                
                
        if($obj->save()){
            if(isset($this->data_client_up->{$type}['event_after_save'])){
                $method = $this->data_client_up->{$type}['event_after_save'];
                $event_after_save = new EventAfterSave();
                $event_after_save->{$method}($obj);
            }

            if($r->ajax()){
                return response()->json(['success'=>true]);
            }else{
                Session::flash('send_success','ok');
                return redirect()->back();
            }
        }

        if($r->ajax()){
            return response()->json(['success'=>false]);
        }

        return redirect()->back();


   }

    private function handlingInput(Request $r, $type){
        $list = $this->data_client_up->{$type}['fields'];
        $result = [];
        $listError = ['error'=>true,'listMessage'=>[]];
       foreach ($list as $key => $value) {

            if(isset($value['required']) && $value['required']){

                if($r->file($key)){

                }else{
                    if(!$r->has($key)){
                        $listError['listMessage'][] = $value['message_required'];
                    }
                }
            }

           if($value['type'] == 'file' && $r->file($key)){

                $filename = $this->uploadFile($r, $type, $key);

                if($filename == 'error_mime'){

                    $listError['listMessage'][] = $value['message_mimes'];

                }else{

                    $result[$key] =  $filename ;
                }
           }else{
                $result[$key] = $r->get($key);
           }
       }

       if(empty($listError['listMessage'])){
            return $result;
       }

       return $listError;

    }

    private function checkUnique(Request $r, $type){
        $fields = $this->data_client_up->{$type}['fields'];
        $result = [];
        $obj = new ModelParent($this->data_client_up->{$type}['table']);
        foreach ($fields as $key => $value) {
            if(isset($value['unique']) && $value['unique']){
                if($obj->where($key, $r->get($key))->count() > 0){
                    $result[] = $value['unique_message']; 
                }
            }
        }

        return $result;
    }

    private function uploadFile(Request $r, $type, $key){

        $fileMime = $this->data_client_up->{$type}['fields'][$key]['mime_type'];

        if(is_int(array_search($r->file($key)->getmimeType(),$fileMime))){

            $filename = str_random(10).'.'.time() . '.' . $r->file($key)->getClientOriginalExtension();

            $r->file($key)->move(base_path() . '/public/user_uploads/', $filename);

            return '/public/user_uploads/'.$filename;

        }else{
            return 'error_mime';
        }
    }
}
