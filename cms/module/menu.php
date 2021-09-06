<?php
function q_get_menu_structure_client($json){

   if(!is_array($json)){
      return '<ol class="dd-list"></ol>';
   }

   $result = '<ol class="dd-list">';

   foreach ($json as $value) {

      $menu_type = $value['posttype'];

      if( isset($GLOBALS['menu_add_filter'][$menu_type]) ){
         $result .= $GLOBALS['menu_add_filter'][$menu_type]['form_attr']($value);
      }else{

         if( check_menu_item ($value) ){


            $strData = '';
            $children = '';
            if( isset($value['children']) ){
               $children = q_get_menu_structure_client($value['children']);
            }

            foreach ($value as $key2 => $value2) {

               if( $value['posttype'] != 'custom links' && $key2 == 'links' ){
                  continue;
               }

               if($key2 != 'children'){
                  $strData = $strData.' data-'.$key2.'="'.htmlentities($value2).'" ';
               }


            }

            $argParam = array_merge($value, ['label'=>$value['label'],'strData'=>$strData,'menu_type'=>$menu_type,'children'=>$children]);

            switch ($menu_type) {
               case 'custom links':
                  $argParam['label_type'] = __('Custom Links');
                  $argParam['links'] = $value['links'];
                  $argParam['class'] = 'custom-links';
                  break;
               case 'page-theme':
                  $argParam['label_type'] = __('Page Theme');
                  $argParam['class'] = 'page-theme';
                  break;
               case 'page-static':
                  $argParam['label_type'] = __('Page Static');
                  $argParam['class'] = 'page-static';
                  break;
              case 'menu-items':
                  $argParam['label_type'] = __('Menu Items');
                  $argParam['class'] = 'menu-items';
                  break;
               default:
                  $argParam['label_type'] = get_admin_object($value['posttype'])['title'];
                  $argParam['class'] = 'post-type';
                  break;
            }

            $result .= vn4_view(backend_theme('page.appearance-menu.item-menu'),$argParam);

         }
      }


   }

   $result = $result.'</ol>';

   return $result;

}


if( !function_exists('vn4_get_list_nav') ){
   function vn4_get_list_nav($list_menu){

      $count = count($list_menu);

      for ($i=0; $i < $count; $i++) { 

         $attrtitle = $list_menu[$i]['attrtitle']?' title="'.$list_menu[$i]['attrtitle'].'"':'';
         $attrtitle .= $list_menu[$i]['target']?' target="'.$list_menu[$i]['target'].'"':'';
         $attrtitle .= $list_menu[$i]['xfn']?' rel="'.$list_menu[$i]['xfn'].'" ':' ';

         $list_menu[$i]['link'] = get_link_menu($list_menu[$i]);
         $list_menu[$i]['attrtitle'] = $attrtitle;

         if( isset($list_menu[$i]['children']) ){
            $list_menu[$i]['children'] = vn4_get_list_nav($list_menu[$i]['children']);
         }

      }

      return $list_menu;
   }
}

if( !function_exists('get_link_menu') ){

   function get_link_menu($menu_item){

      $menuType = $menu_item['posttype'];

      switch ($menuType) {
         case 'custom links':

            if( is_url($menu_item['links']) ){
               $link = $menu_item['links'];
            }else{
               $link = '';
            }
            
            break;
         case 'page-theme':
            $link = route('page',$menu_item['page']);
            break;

         case 'page-static':
            $link = route($menu_item['route']);
            break;
         default:

            $post = get_post($menu_item['posttype'],$menu_item['id']);

            if( !$post ){
               return '';
            }

            $link = get_permalinks($post);

            break;
      }

      $link2 = do_action('get_link_menu',$link, $menuType, $menu_item);

      if( $link2 ) $link = $link2;

      return $link;

   }
}