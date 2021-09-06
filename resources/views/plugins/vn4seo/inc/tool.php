<?php
if( $action = $r->get('action') ){

    if( env('EXPERIENCE_MODE') ){
        return experience_mode();
    }

    if( $action == 'check_html' ){
        use_module('read_html');
       
        function add_class($class, $add){
            $class = explode(' ', $class);
            $class = array_map('trim', $class);
            $class = array_flip($class);
            $class[$add] = 1;
            if( !key($class) ){
                unset($class[key($class)]);
            }
            return implode(' ',array_keys($class));
        }
        $file = cms_path('resource','views/themes/'.theme_name().'/index.blade.php');
        $content = file_get_contents($file);

        $html = str_get_html($content,null,null,null,false);
        $tag_replace = 'a,img';
        $imgs = $html->find($tag_replace);
        $count = count($imgs);
        $mydomain = env('APP_URL');
        for ($i=0; $i < $count; $i++) { 
            if( $imgs[$i]->tag == 'img' ){
                if( strpos($imgs[$i]->src, 'data:image') !== 0 ){
                    
                    $src = $imgs[$i]->src;
                    $pos = strpos($src, $mydomain);
                    if( is_url($src) && $pos === false ){
                        $html->find($tag_replace,$i)->class = add_class($imgs[$i]->class,'img_external');
                        $html->find($tag_replace,$i)->rel = 'nofollow';
                    }else{
                        $html->find($tag_replace,$i)->class = add_class($imgs[$i]->class,'img_internal');
                    }

                    $html->find($tag_replace,$i)->title = $imgs[$i]->title? $imgs[$i]->title : '';

                }
                
            }else{
                $href = $imgs[$i]->href;
                $pos = strpos($href, $mydomain);
                if( is_url($href) && $pos === false ){
                    $html->find($tag_replace,$i)->class = add_class($imgs[$i]->class,'link_external');
                    $html->find($tag_replace,$i)->rel = 'nofollow';
                    $html->find($tag_replace,$i)->target = '_blank';
                }else{
                    $html->find($tag_replace,$i)->class = add_class($imgs[$i]->class,'link_internal');
                }
            }
        }
        file_put_contents(cms_path('resource','views/themes/'.theme_name().'/index.blade.php'), $html.'');
    }
   return redirect()->route('admin.plugins.'.$plugin->key_word,'tool');
}
if( $r->isMethod('GET') ){
    return view_plugin($plugin,'view.tool',['plugin'=>$plugin]);
}

if( env('EXPERIENCE_MODE') ){
    return experience_mode();
}

return redirect()->route('admin.plugins.'.$plugin->key_word,'tool');
