<?php namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Vn4Model;
use DB;

class WidgetController extends Controller {

    public function update_sidebar(Request $r){

        extract($r->only('list_sidebar_widget','list_sidebar_id'));

        $index = 0;

        $sidebar_register = apply_filter('list_sidebar');

        $list_sidebar2 = do_action('list_sidebar',$sidebar_register);

        if( $list_sidebar2 ) $sidebar_register = $list_sidebar2;

        foreach ($list_sidebar_id as $sidebar_id) {

            if( isset($list_sidebar_widget[$index]) ){
                $list_widget = $list_sidebar_widget[$index];
            }else{
                $list_widget = [];
            }

            $list_widget2 = [];

            $name = '';
            
            $input_widget = [];

            if( isset($list_widget[0]) ){

                foreach ($list_widget as $widget) {

                    $name = array_shift($widget)['value'];

                    $input_widget = ['__class_name'=>$name];

                    if( $argDataCustom = $name::update($widget) ){
                        $input_widget = array_merge($input_widget, $argDataCustom);
                    }else{

                        foreach ($widget as $input) {
                        
                            $input_widget[$input['name']] = $input['value'];

                        }    
                    }
                    

                    $list_widget2[] = $input_widget;
                }
            }

            $list_widget2 = json_encode($list_widget2);

            $sidebar = Vn4Model::firstOrAddnew(vn4_tbpf().'widget',['sidebar_id'=>str_slug($sidebar_id),'theme'=>theme_name()]);

            $sidebar->meta = $list_widget2;

            if( isset($sidebar_register[$sidebar_id]) ){

                $sidebar->content = json_encode($sidebar_register[$sidebar_id]);
            }
            
            $sidebar->save();

            $index++;

        }

        return 'widget end';

    }
  
}
