<div class="left_col scroll-view custom_scroll">
  <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">

      <?php 

         function get_sidebar_admin($list_sidebar){


            $str = '';
            foreach ($list_sidebar as $key1 => $sidebar) {

              if( isset($sidebar['permission']) && !check_permission($sidebar['permission'])  ){

                continue;

              }

              if( isset($sidebar['not-menu']) && $sidebar['not-menu'] ){

                if( isset($sidebar['title']) ){
                  $str = $str.'<li class="separator"><h3>'.$sidebar['title'].'</h3></li>';
                }else{
                  $str = $str.'<li class="separator vn4-bg-trans"></li>';
                }

              }else{

                if( isset($sidebar['icon']) ){
                  $icon = '<i class="fa '.$sidebar['icon'].' "></i> ' ;
                }elseif(isset($sidebar['image-icon'])){
                  $icon = '<img data-src="'.$sidebar['image-icon'].'"/> ';
                }else{
                  $icon = '<i class="fa fa-pencil "></i> ' ;
                }

                $symbols_submenu = isset($sidebar['submenu'])?'<span class="fa fa-caret-right"></span>':'';

                $html_sub_menu1 = '';

                if(isset($sidebar['submenu'])){


                    $html_sub_menu2 = '';

                    foreach($sidebar['submenu'] as $key2 => $value){

                        if( isset($value['permission']) && !check_permission($value['permission']) ){
                          continue;
                        }

                        $html_sub_menu3 = '';

                        if(isset($value['submenu'])){

                            foreach($value['submenu'] as $sidebar3){

                                if( isset($sidebar3['permission']) && !check_permission($sidebar3['permission']) ){
                                  continue;
                                }


                                $html_sub_menu3 = $html_sub_menu3.'<li><a href="'.$sidebar3['url'].'">'.$sidebar3['title'].'</a></li>';
                            }

                            if( $html_sub_menu3 !== '' ){
                                $html_sub_menu3 ='<li><a>'.$value['title'].$symbols_submenu.'</a><ul class="nav child_menu">'.$html_sub_menu3.'</ul></li>';
                            }


                        }else{

                          $active_menu = '';
                          if( isset($value['active_menu']) && array_search($GLOBALS['url_current'], $value['active_menu']) !== false ){
                            $active_menu = 'class="current-link"';
                          }


                          $html_sub_menu3 = '<li><a '.$active_menu.' href="'.$value['url'].'">'.$value['title'].'</a></li>';
                        }

                        if( $html_sub_menu3 !== ''){
                            $html_sub_menu2 = $html_sub_menu2.$html_sub_menu3;
                        }

                    }

                    if( $html_sub_menu2 !== ''){
                        $html_sub_menu1 =  '<ul class="nav child_menu">'.$html_sub_menu2.'</ul>';
                    }

                }


                if(isset($sidebar['url'])){

                  $href = $sidebar['url'];

                  $active_menu = '';
                  if( isset($sidebar['active_menu']) && array_search($GLOBALS['url_current'], $sidebar['active_menu']) !== false ){
                    $active_menu = 'class="current-link"';
                  }

                  $str = $str.'<li><a '.$active_menu.' href="'.$href.'">'.$icon.$sidebar['title'].$symbols_submenu.' </a>';

                }else{
                    if( $html_sub_menu1 !== '' )  $str = $str.'<li><a>'.$icon.$sidebar['title'].$symbols_submenu.' </a>'.$html_sub_menu1.'</li>';
                }

              }
              
              
            }

            return $str;

          }
          $admin_sidebar = get_sidebar_admin_object();
       ?>
      <ul class="nav side-menu">
        {!!get_sidebar_admin($admin_sidebar['data'])!!}
        <li class="separator"><h3>@__('Channels')</h3></li>
        {!!get_sidebar_admin($admin_sidebar['channels'])!!}
        <li class="separator"><h3>@__('Add-on')</h3></li>
        {!!get_sidebar_admin($admin_sidebar['add-on'])!!}
        
        <li> <a href='#'  data-url="{!!route('admin.controller',['controller'=>'user','method'=>'change-status-menu'])!!}" data-name="collapse" class="collapse-menu-main not-href"><i class="collapse-menu-icon fa @if($class_body === 'nav-md') fa-caret-left @else fa-caret-right @endif" aria-hidden="true"></i>@__('Collapse menu')</a></li>
      </ul>

      <?php do_action('after_show_sidebar_admin'); ?>

  </div>
  <div class="sidebar-footer hidden-small">
  <ul class="nav side-menu">
    <li>
      <a href="{!!route('admin.page','setting-manage')!!}"><i class="fa fa-cog "></i> @__('Settings')</a>
    </li>
  </ul>
  </div>
  </div>
</div>
</div>

