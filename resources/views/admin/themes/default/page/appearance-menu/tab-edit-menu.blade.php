<?php 

$menu_add_filter = apply_filter('appearance-menu');

$GLOBALS['menu_add_filter'] = $menu_add_filter;

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

                  if( is_array($value2) ) $value2 = json_encode($value2);

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
              case 'route-static':
                  $argParam['label_type'] = __('Route Static');
                  $argParam['class'] = 'route-static';
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

            $argParam['param'] = $argParam;

            $result .= vn4_view(backend_theme('page.appearance-menu.item-menu'),$argParam);

         }
      }


	}

	$result = $result.'</ol>';

	return $result;

}


add_action('vn4_head',function(){

  ?>


<style type="text/css">
   ul li {
       list-style: none;
       padding: 0;
       margin: 0;
   }
   ul {
       padding: 0;
       margin: 0;
   }
   .x_panel {
       box-shadow: none;
   }
   .dd {
       position: relative;
       display: block;
       margin: 0;
       padding: 0;
       max-width: 600px;
       list-style: none;
       font-size: 13px;
       line-height: 20px;
   }
   .dd-list {
       display: block;
       position: relative;
       margin: 0;
       padding: 0;
       list-style: none;
   }
   .dd-list .dd-list {
       padding-left: 30px;
   }
   .dd-collapsed .dd-list {
       display: none;
   }
   .dd-item,
   .dd-empty,
   .dd-placeholder {
       display: block;
       position: relative;
       margin: 0;
       padding: 0;
       min-height: 20px;
       font-size: 13px;
       line-height: 20px;
   }
   .dd-dragel .dd-handle {
       margin: -15px 0;
   }
   .dd-dragel {
       padding: 10px;
       margin: -10px 0 0 -5px;
   }
   .dd-dragel .menu_item_info {
       margin-bottom: 5px
   }
   .dd-handle {
       display: block;
       margin: 5px 0;
       padding: 5px 80px 5px 10px;
       color: #333;
       text-decoration: none;
       font-weight: bold;
       border: 1px solid #ccc;
       background: #fafafa;
       background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
       background: -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
       background: linear-gradient(top, #fafafa 0%, #eee 100%);
       -webkit-border-radius: 3px;
       border-radius: 3px;
       box-sizing: border-box;
       -moz-box-sizing: border-box;
   }
   .dd-handle:hover {
       color: #2ea8e5;
       background: #fff;
   }
   .dd-item > button {
       display: block;
       position: relative;
       cursor: pointer;
       float: left;
       width: 25px;
       height: 20px;
       margin: 5px 0;
       padding: 0;
       text-indent: 100%;
       white-space: nowrap;
       overflow: hidden;
       border: 0;
       background: transparent;
       font-size: 12px;
       line-height: 1;
       text-align: center;
       font-weight: bold;
   }
   .dd-item > button:before {
       content: '+';
       display: block;
       position: absolute;
       width: 100%;
       text-align: center;
       text-indent: 0;
   }
   .dd-item > button[data-action="collapse"]:before {
       content: '-';
   }
   .dd-placeholder,
   .dd-empty {
       margin: 5px 0;
       padding: 0;
       min-height: 30px;
       background: #f2fbff;
       border: 1px dashed #b6bcbf;
       box-sizing: border-box;
       -moz-box-sizing: border-box;
   }
   .dd-empty {
       border: 1px dashed #bbb;
       min-height: 100px;
       background-color: #e5e5e5;
       background-image: -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff), -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
       background-image: -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff), -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
       background-image: linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff), linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
       background-size: 60px 60px;
       background-position: 0 0, 30px 30px;
   }
   .dd-dragel {
       position: absolute;
       pointer-events: none;
       z-index: 9999;
   }
   .dd-dragel .dd-item {
       background: white;
       border-radius: 3px;
   }
   .dd-dragel > .dd-item .dd-handle {
       margin-top: 0;
   }
   .dd-dragel .dd-handle {
       -webkit-box-shadow: 2px 4px 6px 0 rgba(0, 0, 0, .1);
       box-shadow: 2px 4px 6px 0 rgba(0, 0, 0, .1);
   }
   .nestable-lists {
       display: block;
       clear: both;
       padding: 10px 0;
       width: 100%;
       border: 0;
   }
   #nestable-menu {
       padding: 0;
       margin: 20px 0;
   }
   #nestable-output,
   @media only screen and (min-width: 700px) {
       .dd {
           float: left;
           width: 48%;
       }
       .dd + .dd {
           margin-left: 2%;
       }
   }
   .dd-hover > .dd-handle {
       background: #2ea8e5 !important;
   }
   .list_object .li_object {
       list-style: none;
       border-bottom: 1px solid #dfdfdf;
       background: #fff;
   }
   .list_object .li_object .fa,
   #nestable .dd-item>.fa,
   .menu_type {
       position: absolute;
       right: 14px;
       top: 50%;
       height: 42px;
       -webkit-transform: translate(0, -50%);
       -ms-transform: translate(0, -50%);
       -o-transform: translate(0, -50%);
       transform: translate(0, -50%);
       line-height: 39px;
   }
   .menu_type {
       right: 80px;
       top: 16px;
   }
   #nestable .dd-item>.fa {
       top: 28px;
   }
   .list_object .li_object .fa {
       top: 0;
       -webkit-transform: translate(0, 0);
       -ms-transform: translate(0, 0);
       -o-transform: translate(0, 0);
       transform: translate(0, 0);
   }
   .list_object .li_object.loading .fa {
       top: 2px;
       font-size: 20px;
       height: auto;
   }
   .list_object .li_object.active .fa {
       -webkit-transform: rotate(180deg);
       -ms-transform: rotate(180deg);
       -o-transform: rotate(180deg);
       transform: rotate(180deg);
       transition: transform 550ms ease;
       -moz-transition: -moz-transform 550ms ease;
       -ms-transition: -ms-transform 550ms ease;
       -o-transition: -o-transform 550ms ease;
       -webkit-transition: -webkit-transform 550ms ease;
   }
   .list_object .li_object .fa:before,
   #nestable .dd-item>.fa.icon-collapse:before {
       content: "\f0dd";
   }
   #nestable .dd-item>.fa.icon-remove:before {
      content: "\f00d";
      right: 25px;
      top: -6px;
   }
  #nestable .dd-item>.fa.icon-edit:before {
      content: "\f013";
      right: 45px;
      top: -6px;
   }
   .list_object .li_object.loading .fa:before {
       content: "\f110";
   }
   #nestable .dd-item>.fa:before {
       top: -7px;
       position: absolute;
       right: 5px;
       line-height: 27px;
       height: 30px;
   }
   .list_object .li_object h3 {
       position: relative;
       cursor: pointer;
       line-height: 21px;
       padding: 10px 10px 11px 14px;
       margin: 0;
       font-size: 13px;
       font-family: "Helvetica Neue", Roboto, Arial, "Droid Sans", sans-serif;
       font-weight: bold;
   }
   .list_object .li_object:not(.active-none).active h3,
   .list_object .li_object .button-controls {
       background: rgba(234, 234, 234, 0.64);
       position: relative;
   }
   .list_object .li_object:not(.active-none).active h3 {
       border-bottom: 1px solid #dfdfdf;
       background: rgba(234, 234, 234, 0.64);
   }
   .bd-n {
       border: none;
   }
   .content-li-object {
       width: 100%;
       height: auto;
       float: none;
       display: none;
       -moz-transition: none;
       -webkit-transition: none;
       -o-transition: none;
       transition: none;
       margin: 0;
   }
   .button-controls {
       clear: both;
       margin: 0;
       padding: 10px;
   }
   .list-controls {
       margin-top: 5px;
   }
   .add-to-menu {
       position: absolute;
       right: 10px;
       top: 50%;
       -webkit-transform: translate(0, -50%);
       -ms-transform: translate(0, -50%);
       -o-transform: translate(0, -50%);
       transform: translate(0, -50%);
   }
   .fl {
       float: left;
       margin-right: 5px;
   }
   .row_object {
       max-height: 160px;
       overflow: auto;
       margin: 10px;
   }
   .no_item p {
       margin: 0;
   }
   .dd-item .fa {
       cursor: pointer;
   }
   .menu_item_info {
       margin-top: -6px;
       border: 1px solid #dfdfdf;
       padding: 10px 0;
       display: none;
   }
   .btn-remove {
       color: #a00;
   }
   .btn-remove:hover {
       color: red;
       text-decoration: none;
   }
   .btn-cancel {
       text-decoration: underline;
   }
   .btn-cancel:hover {
       background: #0073aa;
       color: #fff;
   }
   .menu_item_controls {
       margin-top: 10px;
       padding: 0 10px;
   }
   .form-appearance {
       padding: 0 7px;
   }
   .menu_item_controls .btn-control {
       padding: 3px 5px;
       cursor: pointer;
   }
   .list_object .li_object .fa.out_fa {
       -webkit-transform: rotate(0);
       -ms-transform: rotate(0);
       -o-transform: rotate(0);
       transform: rotate(0);
       transition: transform 550ms ease;
       -moz-transition: -moz-transform 550ms ease;
       -ms-transition: -ms-transform 550ms ease;
       -o-transition: -o-transform 550ms ease;
       -webkit-transition: -webkit-transform 550ms ease;
   }
   .wrap-menu-items .in-label, .wrap-menu-items .in-attr, .wrap-menu-items .in-target, .wrap-menu-items .in-option, .wrap-menu-items .in-description {
      display: none;
   }
   .action-menu{
    margin: 0 -7px -10px -7px;height: auto;background: #f6f7f9;height: 48px;padding: 10px;border-top: 1px solid #E6E9ED;
   }
   .x_content h4{
    padding: 0 10px;
   }
</style>

<?php
},'appearance-menu-edit-menu-css',true);
   $editMenuClient   = check_permission('appearance_menu_client_edit');
   ?>
<div class="row">
  <div class="col-md-12">
    <div class="x_panel" style=" border: 1px solid #e5e5e5; -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.04); box-shadow: 0 1px 1px rgba(0,0,0,.04);background:#fbfbfb;">
      <div class="x_content" style="height: 29px;padding:10px;margin:0;width:auto; box-sizing: content-box;">
        <?php 
        $obj = new Vn4Model(vn4_tbpf().'menu');

        $theme = theme_name();

        $menus = $obj->where('type','menu_item')->where('status',1)->orderBy('title','asc')->get();

        if( !isset($menus[0]) ){
            $obj->title = 'Menu name';
            $obj->type = 'menu_item';
            $obj->status = 1;
            $obj->theme = $theme;
            $obj->save();
            $menus[0] = $obj;
        }


        $menusFilter = apply_filter('register_nav_menus',[]);
        $menusFilter2 = do_action('register_nav_menus',$menusFilter);

        if( $menusFilter2 ) $menusFilter = $menusFilter2;

        $key = array_keys($menusFilter);

        $menu = Request::get('id',false);

        $flag = false;

        foreach ($menus as  $value) {
            if( $value->id == $menu ){
                $flag = true;
                $menu = $value;
                break;
            }
        }

        if( !$flag ) $menu = $menus[0];

        $menu_setting =(new Vn4Model(vn4_tbpf().'menu'))->whereIn('key_word',$key)->where('content',$menu->id)->pluck(Vn4Model::$id,'key_word');

        $list_menu_added = [];

        ?>

        @if( $menus )
        <span class="fl" style="line-height: 28px;display: inline-block;float: left;margin-right:5px;">@__('Select menu to edit'): </span>

        <select id="selected_menu_edit" class="fl form-control" required="" style="display: inline;width: auto;height:100%;">


          @foreach($menus as $value)
          <?php 
            $nav_name = json_decode($value->content,true);
            $nav_name = $nav_name?$nav_name:[];

            foreach ($nav_name as $key2 => $value2) {
              $list_menu_added[$key2] = $value->id;
            }
            $nav_name = array_values($nav_name);
            if( isset($nav_name[0]) ){
              $nav_name = '('.implode(', ',$nav_name).')';
            }else{
              $nav_name = '';
            }
           ?>
          <option @if($menu->id == $value->id ) selected @endif  value="{!!$value->id!!}">{!!$value->title,' ',$nav_name!!}</option>
          @endforeach


        </select>
          <button type="submit" class="fl vn4-btn" id="submit_selected_menu_edit" name="add-post-type-menu-item">@__('Select')</button>
          
          <span class="fl" style="line-height: 28px;display: inline-block;float: left;margin-right:5px;" >@__('Or create a new menu:') </span>
          <input type="text" class="fl form-control" id="input_name_menu_new" placeholder="Tên menu" style="display:inline;width:auto;height:100%;">        
          <input type="submit"  id="create_new_menu" class="fl vn4-btn vn4-btn-blue" value="Tạo menu" style="height:100%;line-height:15px;" name="create_new_menu">

        @endif
      </div>
    </div>

  </div>
</div>
@if( $menus )
<div class="row">

  <div class="col-md-4 col-xs-12 object-left">
    <div class="x_panel" style="padding: 0;margin:0;background:transparent">
      <div class="x_content" style="padding: 0;margin:0;">

              <!-- POST TYPE -->
               <h4 class="clearfix">@__('Post Type')</h4>
            <ul class="list_object" style="padding: 0;margin:0;">
            @foreach($admin_object as $key => $object)

              @if( $object['public_view'] )
              <li class="li_object" object-type="{!!$key!!}">
                <h3>{!!$object['title']!!}<i class="fa"></i></h3>
                <div class="x_panel bd-n content-li-object">
                  <ul class="row_object">


                  </ul>

                </div>
              </li>
              @endif
            @endforeach
            </ul>
            
              <h4 class="clearfix"  style="margin-top: 40px;">@__('System')</h4>
              <ul class="list_object" style="padding: 0;margin:0;">
                <li class="li_object page-theme" object-type="page-theme">
                  <h3 title="Những trang được tạo bằng code tĩnh" >@__('Page')<i class="fa"></i></h3>
                  <div class="x_panel bd-n content-li-object">
                    <ul class="row_object">
                    </ul>
                  </div>
                </li>
                

                <li class="li_object page-static not-object" object-type="route-static">
                  <h3 title="Những link tĩnh được tạo bằng route của laravel">@__('Route Static')<i class="fa"></i></h3>
                  <div class="x_panel bd-n content-li-object">
                    <ul class="row_object">
                      <li class=""><label><input type="checkbox" class="check_obj" name="route-static[]" value="index"> @__('Home')</label></li>
                      <li class=""><label><input type="checkbox" class="check_obj" name="route-static[]" value="error404"> @__('Error 404')</label></li>
                    </ul>
                    <p class="button-controls"><span class="list-controls"><a href="#" class="select-all">Select All</a></span><span class="add-to-menu"><button type="submit" class="button-secondary vn4-btn submit-add-to-menu right" object-type="route-static" name="add-post-type-menu-item">@__('Add to Menu')</button><span class="spinner"></span></span></p>
                  </div>
                </li>


                <li class="li_object not-object custom_link" object-type="custom_link">
                  <h3>@__('Custom Links')<i class="fa"></i></h3>
                  <div class="x_panel bd-n content-li-object">
                    <div class="form-group">
                      <label class="control-label col-xs-12">@__('URL')</label>
                      <div class="col-xs-12">
                        <input type="text" id="url_custom_links" class="form-control" value="http://" placeholder="http://">
                      </div>
                      <div class="clearfix"></div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-xs-12">@__('Link Text')</label>
                      <div class="col-xs-12">
                        <input type="text" id="link_text_custom_links" class="form-control" placeholder="Menu item">
                      </div>
                      <div class="clearfix"></div>
                    </div>

                    <p class="button-controls">
                      <span class="list-controls">
                        <span class="">&nbsp;</span>
                      </span>

                      <span class="add-to-menu">
                          <button type="submit" class="button-secondary vn4-btn submit-add-custom-links right" object-type="custom_link" name="add-post-type-menu-item">@__('Add to Menu')</button>
                        <span class="spinner"></span>
                      </span>
                    </p>

                  </div>
                </li>

                <li class="li_object not-object" object-type="menu-items">
                  <h3 title="Đôi khi bạn cần dùng lại những menu đã có sẳn." >@__('Menu Items')<i class="fa"></i></h3>
                  <div class="x_panel bd-n content-li-object">
                    <ul class="row_object">
                     @foreach($menus as $value)
                        @if( $menu->id !== $value->id )
                        <li class=""><label><input type="checkbox" class="check_obj" name="menu-items[]" value="{!!$value->id!!}"> {!!$value->title!!}</label></li>
                        @endif
                      @endforeach
                    </ul>
                    <p class="button-controls">
                      <span class="list-controls">
                        <span class="">&nbsp;</span>
                      </span>

                      <span class="add-to-menu">
                          <button type="submit" class="button-secondary vn4-btn right submit-add-to-menu" object-type="menu-items" name="add-post-type-menu-item">@__('Add to Menu')</button>
                        <span class="spinner"></span>
                      </span>
                    </p>

                  </div>
                </li>


              </ul>
              <!-- END SYSTEM -->
              
              
              <!-- Added -->
              <h4 class="clearfix"  style="margin-top: 40px;">@__('Add')</h4>
              <ul class="list_object" style="padding: 0;margin:0;">
                 
                 @foreach($menu_add_filter as $key => $value)
                    <li class="li_object page-static not-object" object-type="{!!$key!!}">
                       <h3 title="{!!$value['description']!!}">{!!$value['title']!!}<i class="fa"></i></h3>
                       <div class="x_panel bd-n content-li-object">
                          <ul class="row_object">
                             {!!$value['view']()!!}
                          </ul>
                          <p class="button-controls"><span class="list-controls"><a href="#" class="select-all">Select All</a></span><span class="add-to-menu"><button type="submit" class="button-secondary vn4-btn submit-add-to-menu right" object-type="{!!$key!!}" name="add-post-type-menu-item">@__('Add to Menu')</button><span class="spinner"></span></span></p>
                       </div>
                    </li>
                 @endforeach
                
              </ul>
              <!-- END Added -->


      </div>
    </div>    
  </div>

  <div class="col-md-8 col-xs-12 col-xs-12">
    <div class="x_panel" style="padding-bottom: 0;">
      <div class="x_content" style=" padding:0 10px 10px;">
        @if( $menu )
              <form method="POST" class="form-appearance" >
                <input type="text" name="_token" value="{!!csrf_token()!!}" hidden>
                <div class="row">
                    
                    <div class="row action-menu">
                        <span class="fl" style="line-height: 28px;display: inline-block;float: left;margin-right:5px;">Menu name </span>
                        <input type="text" class="fl form-control" id="input_name_menu_current" placeholder="Tên menu" data-id="{!!$menu->id!!}" value="{{$menu->title}}" style="display:inline;width: 250px;height:100%;">
                        <?php 
                          do_action('appearance-menu-button');
                         ?>       
                        @if( $editMenuClient  )
                           <button type="submit" class="vn4-btn vn4-btn-blue pull-right btn-save" style="height:100%;line-height:15px;" name="add-post-type-menu-item">@__('Save Menu')</button>
                        @endif
                     </div>
                     <div class="clearfix"></div>

                      <h3 style="padding-top:15px;"><i>@__('Menu Structure')</i></h3>

                      <div class="drag-instructions post-body-plain">
                        <p><i>@__('Drag each item into the order you want. Click the arrow to the right of the item to display more configuration options').</i></p>
                      </div>
                             <div class="cf nestable-lists">
                                <div class="dd" id="nestable">
                                    {!! q_get_menu_structure_client(json_decode($menu->json, true)) !!}
                                </div>
                             </div>

                            <div class="setting_menu">
                                <h3><i>Menu Settings</i></h3>
                                <div class="row">
                                    <div class="col-md-2">
                                        <p style="margin-top: 10px;">Display location</p>
                                    </div>
                                    <div class="col-md-10">
                                      
                                        @foreach($menusFilter as $key => $value)
                                          @if( $value === 'no-menu' )
                                            <hr style="margin: 0 25px 0 0;max-width: 500px;">
                                          @else 
                                            <div class="checkbox">

                                                <label>
                                                  <input type="checkbox" @if( isset($menu_setting[$key]) ) checked @endif name="menu_filter[]" value="{!!$key!!}">

                                                  @if( isset($list_menu_added[$key]) )
                                                   <a href="?id={!!$list_menu_added[$key]!!}">{!!$value!!}</a>
                                                  @else
                                                   {!!$value!!}
                                                   @endif
                                                </label>
                                            </div>
                                          @endif
                                        @endforeach

                                    </div>
                                </div>
                                <br>
                            </div>

                             <textarea hidden id="nestable-output"></textarea>

                             @if( $editMenuClient  )
                             <div class="row action-menu">

                                <span id="delete_menu" class=" btn-remove" style="cursor:pointer; margin-top: 4px;text-decoration: underline;">Delete Menu</span>
                                &nbsp;
                                <a type="button" id="clear_menu" href="#" class="btn-control btn-remove" style=" margin-top: 4px;text-decoration: underline;">@__('Clear')</a>
                                @if( $editMenuClient  )
                                   <button type="submit" class="vn4-btn vn4-btn-blue pull-right btn-save" style="height:100%;line-height:15px;" name="add-post-type-menu-item">@__('Save Menu')</button>
                                @endif
                             </div>
                             @endif
                  </div>
                 </form>
          @else
          <h4><i>Hiện chưa có menu nào được tạo.</i></h4>
          @endif
        </div>
       </div>
  </div>
</div>

@endif

<?php 

  add_action('vn4_footer',function() use ($menus, $menu ) {
    ?>
      
    <script src="{!!asset('admin/js/jquery.nestable.js')!!}"></script>
    <script>
      $(document).ready(function() {

          // Click select all
          $('.content-li-object').on( 'click', 'a.select-all', function(event) {
             event.preventDefault();
             event.stopPropagation();
             $(this).closest('.content-li-object').find('input[type="checkbox"]').prop({checked:true});
          });

          // Load object
        function load_data_to_li_object($this, data){

          $this.addClass('have_data');
          $this.removeClass('loading');
          $this.find('.fa:first').removeClass('fa-spin');

          var data_object = $this.attr('object-type');
          var ul = $this.find('.content-li-object .row_object:first');

          for(i = 0; i < data.result.length; i ++){
            ul.append('<li class=""><label><input type="checkbox" class="check_obj" name="'+data_object+'[]" value="'+data.result[i].@id+'"> '+data.result[i].title+'</label></li>');
          }

          if(data.result.length < 1){
            ul.append('<li class="no_item"><p><i>@__('no data available')</i></p></li>');
          }else{
            $this.find('.content-li-object').append('<p class="button-controls"><span class="list-controls"><a href="#" class="select-all">@__('Select All')</a></span><span class="add-to-menu"><button type="submit" class="button-secondary vn4-btn submit-add-to-menu right" object-type="'+data_object+'" name="add-post-type-menu-item">@__('Add to Menu')</button><span class="spinner"></span></span></p>')
          }

          $this.addClass('active');
          $this.find('.fa:first').addClass('over_fa');
          $this.find('.content-li-object').slideDown(200);
        }

          //click load object
        $(document).on('click','.list_object .li_object',function(event) {

          var $this = $(this);

          var object_type = $this.attr('object-type');

          $('.list_object .li_object.active .content-li-object').slideUp(200,function(){
            $(this).closest('.li_object').removeClass('active');
          });


          if($this.hasClass('active')){

            $this.find('.content-li-object').slideUp(200,function(){
              $this.removeClass('active');
            });
            $this.find('.fa:first').addClass('out_fa');
            window.setTimeout( function () { $this.find('.fa:first').removeClass('out_fa'); }, 550 );

          }else{

            $( ".content-li-object .check_obj:checked" ).prop('checked', false);

            if(!$(this).hasClass('have_data')){
              $this.addClass('loading');
              $this.find('.fa:first').addClass('fa-spin');

              if( !$(this).hasClass('not-object') ){

                vn4_ajax({

                  data:{
                    object_type:object_type,
                    type:'get object data'
                  },
                  callback:function(data){


                  <?php  $do_action_load_menu = do_action('js_load_item_menu'); ?>
                   
                    load_data_to_li_object($this,data);
                  }

                });
                
              }else{
                $this.removeClass('loading');
                $this.find('.fa:first').removeClass('fa-spin');
                $this.addClass('active');
                $this.find('.fa:first').addClass('over_fa');
                $this.find('.content-li-object').slideDown(200);
              }

            }else{

              $this.addClass('active');
              $this.find('.content-li-object').slideDown(200);
            }

          }

        });
          
        $(document).on('click','.content-li-object',function(event) {
           event.stopPropagation();
        });

        $('body').on('click', '.dd-item>.fa', function(event) {
           event.preventDefault();
           event.stopPropagation();
           $(this).closest('.dd-item').find('.menu_item_info:first').slideToggle('fast');
        });

          $('body').on('change','input,textarea',function(event){
             $value = $(this).val();
            $(this).closest('.dd-item').data($(this).attr('name'),$value);
          });

          $('body').on('change','.input-nav-label',function(event){

             $value = $(this).val();

             if( !$value ) $value = '(no label)';

             $(this).closest('.dd-item').data('label',$value);
             $(this).closest('.dd-item').find('.dd-handle:first').text($value);
             $(this).attr('value',$value);
          });

          //select menu to edit
          $(document).on('click','#submit_selected_menu_edit',function(event) {
             if($('#selected_menu_edit').val()){
                window.location.href = replaceUrlParam(window.location.href,'id',$('#selected_menu_edit').val());
             }
          });

          // Clear menu - not save
          $(document).on('click','#clear_menu',function(event) {
             event.preventDefault();
             event.stopPropagation();
             $('.dd-list').empty();
          });


          // nestable
          var updateOutput = function(e) {
            var list = e.length ? e : $(e.target),
            output = list.data('output');

            if (window.JSON) {
              output.val(window.JSON.stringify(list.nestable('serialize'))); 
             } else {
                output.val('JSON browser support required for this demo.');
             }

          };

        // activate Nestable for list 1

        $('#nestable').nestable({
          group: 1,
          maxDepth: 5,
          expandBtnHTML:'',
          collapseBtnHTML:'',
        });

        // output initial serialised data
        $('#nestable-menu').on('click', function(e) {
          var target = $(e.target),
          action = target.data('action');
          if (action === 'expand-all') {
            $('.dd').nestable('expandAll');
          }
          if (action === 'collapse-all') {
            $('.dd').nestable('collapseAll');
          }
        });

        $('#nestable.dd').on('click','.icon-remove',function(event){
              event.stopPropagation();
              $(this).closest('.dd-item').find('.btn-remove').trigger('click');
          });

        $('#nestable').on('click', '.btn-remove', function(event) {
             event.preventDefault();
             event.stopPropagation();
             $(this).closest('.dd-item').find('.dd-handle').css({background: '#de0000',color: 'white'});
             $(this).closest('.dd-item').find('i.fa').css({color: 'white'});
             $(this).closest('.dd-item').find('.menu_type').css({color: 'white'});

             $(this).closest('.menu_item_info').slideUp('fast',function(){
                $(this).closest('.dd-item').remove();
             });
          });

        $('#nestable.dd').on('click','.icon-detail-all',function(event){
            event.stopPropagation();
            $(this).closest('li').find('>.dd-list>.dd-item>.dd-handle').css({'margin-top':0});
            $(this).closest('li').find('>.dd-list').slideToggle(300,function(){
              $(this).closest('li').find('>.dd-list>.dd-item>.dd-handle').css({'margin-top':5});
            });

        });

          $('#nestable').on('click', '.btn-cancel', function(event) {
             event.preventDefault();
             event.stopPropagation();
             $(this).closest('.menu_item_info').slideUp('fast');

          });

        $(document).on('click','.submit-add-custom-links',function(event) {

          var url = $('#url_custom_links').val();
          var linkText = $('#link_text_custom_links').val();
          var selector = '.dd-list:first';

          if(linkText){

            vn4_ajax({
              data:{
                links:url,
                label:linkText,
                selector:selector,
                      key:'custom links',
                type:'add menu item'
              }
            });
            
          }
          
        });

          $('body').on('change', '.change-data-menu', function(event) {
               $(this).closest('.dd-item').data($(this).data('trigger'),$(this).val());
          });

          $('body').on('click', 'input[type=checkbox]', function(event) {
             if( $(this).prop('checked') ){
               $(this).closest('.dd-item').data($(this).data('trigger'),$(this).val());
             }else{
               $(this).closest('.dd-item').data($(this).data('trigger'),'');
             }
          });

          $('.content-li-object').on('click', '.submit-add-to-menu', function(event) {

             event.preventDefault();

             var $this = $(this),key = $(this).attr('object-type');

             var list_object = $(this).closest('.content-li-object').find( ".check_obj[name='"+key+"[]']:checked" ).map(function(index, el) {
                return $(el).val();
             }).get();

             var selector = '.dd-list:first';
             vn4_ajax({

                data:{
                   list_object:list_object,
                   selector:selector,
                   key:key,
                   type:'add menu item',
                   success:function(){
                    $this.closest('.content-li-object').find( ".check_obj[name='"+key+"[]']:checked" ).prop('checked', false);
                   }
                }

             });


          });


          //Ajax create new menu
          $('body').on('click', '#create_new_menu', function(event) {
            event.preventDefault();

            if( $('#input_name_menu_new').val() === '' ){
              $('#input_name_menu_new').css({border:'1px solid red'});
              return;
            }else{
              $('#input_name_menu_new').css({border:'1px solid #ccc'});

                vn4_ajax({

                    data:{

                      'name':$('#input_name_menu_new').val(),
                      'create_new_menu':true,
                    }


                });
              
            }

            
          });

          
          // Save Menu
          $(document).on('click','.btn-save',function(event) {

             event.preventDefault();
             event.stopPropagation();

             var setting_menu = [];

            $('.setting_menu input[name="menu_filter[]"]:checked').each(function(index, el) {
                setting_menu.push($(el).val());
             });

            if( $('#input_name_menu_current').val() === '' ){
                $('#input_name_menu_current').css({border:'1px solid red'});
                return;
            }else{

                $('#input_name_menu_current').css({border:'1px solid #ccc'});

                updateOutput($('#nestable').data('output', $('#nestable-output')));

                var id = '{!!$menu->id!!}';

                vn4_ajax({
                    show_loading:true,
                    data:{
                       menu_item:$("#nestable-output").val(),
                       id:id,
                       setting_menu:setting_menu,
                       name:$('#input_name_menu_current').val(),
                       edit_menu:true,
                       type:'Edit menu'
                    },
                    callback:function(){
                      window._formHasChanged = false;
                      window.submitted = true;
                    }
                });
            }
          });

        //Delete menu
        $('body').on('click', '#delete_menu', function(event) {
            event.preventDefault();
            var r = confirm("Are your sure!");
            if (r == true) {
              vn4_ajax({
                  data:{
                     delete_menu:'{!!$menu->id!!}',
                  },
                  callback:function(){
                    window._formHasChanged = false;
                    window.submitted = true;
                  }
              });
            }
        }); 
        

      });
    </script>
    <?php
  },'appearance-menu-edit-menu-js',true);
 ?>

