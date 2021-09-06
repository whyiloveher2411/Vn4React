<?php
if( $r->ajax() ){

    if( env('EXPERIENCE_MODE') ){
        return response()->json(['message'=>'This is a trial version, you cannot do it']);
    }
    
    $user = Auth::user();
    $user->customize_time = time() + 1;
    $user->save();

    if( $r->has('getMenuItem') ){

        $menu_item = DB::table(vn4_tbpf().'menu')->whereType('menu_item')->whereTheme(theme_name())->get()->toArray();

        $str = '<label>Menus</label><ul style="margin:0 -15px;" class="nav-session">';
        $strSession = '';
        $strId = [];

        foreach ($menu_item as $item) {
            $item = (array) $item;
            
            $content = json_decode($item['content'],true);
            $content = $content?$content:[];

            if( $content ){
                $add_to_menu = '<br>(Currently set to: '.implode(', ',array_values($content)).')';
            }else{
                $add_to_menu = '';
            }

            $str .= '<li data-session="menu-item-'.$item[Vn4Model::$id].'" class="show-session menu-active-for-'.implode(' menu-active-for-',array_keys($content)).'" data-ajax="?getMenuItemDetail=true" data-id="'.$item[Vn4Model::$id].'">'.$item['title'].' <small>'.$add_to_menu.'</small></li>';

            $strId[] = 'session-menu-item-'.$item[Vn4Model::$id];
            $strSession .= '<div id="session-menu-item-'.$item[Vn4Model::$id].'" class="session session-content session-menu-item-'.$item[Vn4Model::$id].'">'
                    .'<div class="warpper-sidenav-header bd-bt">'
                      .'<div class="sidenav-header">'
                        .'<div class="icon-back show-session" data-session="menu"></div>'
                        .'<h4 class="title-small"><span class="show-session" data-session="screen-1">Customizing</span> ▸ <span class="show-session" data-session="menu">Menus</span></h4>'
                        .'<h2 class="title">'.$item['title'].'</h2>'
                      .'</div>'
                    .'</div>'
                    .'<div class="pd">'
                    .$item['title']
                    .'</div>'
                  .'</div>';
        }
        $str .= '</ul>';

        return response()->json(['html'=>$str,'script'=>'$("#'.implode(', #',$strId).'").remove();$(".sidenav-content").append(\''.$strSession.'\');']);
    }

    if( $r->has('getMenuItemDetail') ){

        $id = $r->get('id');

        $menu_item = DB::table(vn4_tbpf().'menu')->where(Vn4Model::$id,$id)->first();

        use_module('menu');

        $str = '<label><textarea hidden class="menu-content" id="nestable-output-'.$id.'" name="nestable-output['.$id.'][json]" >'.$menu_item['json'].'</textarea><input type="text" name="nestable-output['.$id.'][id]" hidden class="menu-id" value="'.$id.'" >Menu Name<input type="text" name="nestable-output['.$id.'][name]" class="form-control" value="'.$menu_item['title'].'" /></label><div class="cf nestable-lists"><div class="dd" id="nestable-menu-'.$menu_item[Vn4Model::$id].'">'.q_get_menu_structure_client(json_decode($menu_item['json'], true)).'</div></div>';

        return response()->json(['html'=>$str,'script'=>'$("#nestable-menu-'.$menu_item[Vn4Model::$id].'").nestable({group: 1,maxDepth: 5,expandBtnHTML:"",collapseBtnHTML:"",}).on("change", function(e) {e.stopPropagation();updateOutput($("#nestable-menu-'.$id.'").data("output", $("#nestable-output-'.$id.'")));});']);

    }

    $action = $r->get('action','preview');

    if( $action === 'preview' || $action === 'save-customize' ){
       
    	$input = $r->only('options');

    	//reading_homepage
        $setting_config = get_setting_object();
        $value = $setting_config['reading']['fields']['homepage']['save']($r->all(), false);

        $input['options']['reading_homepage'] = $value;
        // end reading_homepage

        if( $action === 'preview' ){

            $note = 'Preview';
            $options = get_option();
            Cache::forever( 'options_'.theme_name(), array_merge($options,$input['options']));

        }else{

            if( $r->has('nestable-output') ){

                $menu = $r->get('nestable-output');

                $table = vn4_tbpf().'menu';

                $menus =  (new Vn4Model($table))->whereTheme(theme_name())->get();

                foreach ($menus as $v) {

                    if( isset($menu[$v->id]) ){

                        $json = json_decode($menu[$v->id]['json'],true);

                        if( !$json ) $json = [];

                        $v->title = $menu[$v->id]['name'];
                        $v->json = json_encode($json);
                        $v->setTable($table);
                        $v->save();

                    }elseif( isset($menu[$v->content]) ){

                        $json = json_decode($menu[$v->content]['json'],true);

                        if( !$json ) $json = [];
                        $v->json = json_encode($json);
                        $v->setTable($table);
                        $v->save();

                        Cache::forget('menu - '.$v->key_word);

                    }

                }

            }
            dd($input['options']);
            save_option($input['options']);
            $note  = 'Save Customize';
        }

    	return response()->json(['success'=>true,'note'=>$note]);

    }

    if( $action === 'save-menu' ){

        use_module('menu');

        $id = $r->get('id');

        $content = json_decode($r->get('content'),true);

        if( !$content ) $content = [];

        $menu_item = DB::table(vn4_tbpf().'menu')->whereContent($id)->get();

        foreach ($menu_item as $v) {

            Cache::forever('menu - '.$v->key_word, vn4_get_list_nav($content));
            
        }

        return response()->json(['success'=>true]);
    }

    if( $action === 'recover' ){

        if( $r->has('nestable-output') ){

            $menu_item = DB::table(vn4_tbpf().'menu')->whereType('menu')->whereTheme(theme_name())->get();

            foreach ($menu_item as $v) {
                Cache::forget('menu - '.$v->key_word);
            }

        }

        $obj = Vn4Model::firstOrAddnew(vn4_tbpf().'setting',['key_word'=>'options_'.theme_name(),'type'=>'theme-options']);

        $content = json_decode($obj->content,true);

        if( !is_array($content) ) $content = [];

        Cache::forever('options_'.theme_name(), $content);

        return response()->json(['success'=>true,'note'=>'Recover Cache']);

    }
}

dd('Not Ajax');