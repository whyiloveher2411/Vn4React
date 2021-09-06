<?php

$list_permission = [
    'post_type'=>[
      'title'=>'Post Type',
      'children'=>[]
    ],
    'page_admin'=>[
      'title'=>'Trang',
      'children'=>[]
    ],
    'setting'=>[
      'title'=>'Setting',
      'children'=>[]
    ],
    'plugin'=>[
      'title'=>'Plugin',
      'children'=>[]
    ],
];

//POST TYPE
$admin_object = get_admin_object();

foreach ($admin_object as $key => $object) {
  $list_permission['post_type']['children']['post_type_'.$key] = [
    'title'=>$object['title'],
    'permission'=>[
        $key.'_list'=>'List '.$object['title'],
        $key.'_create'=>'Create '.$object['title'],
        $key.'_edit'=>'Edit '.$object['title'],
        $key.'_publish'=>'Publish '.$object['title'],
        $key.'_trash'=>'Trash '.$object['title'],
        $key.'_delete'=>'Delete '.$object['title'],
        $key.'_restore'=>'Restore '.$object['title'],
        $key.'_detail'=>'Detail '.$object['title'],
    ]
  ];
}

//Login Add user
$list_permission['post_type']['children']['post_type_user']['permission']['login_as_user_other'] = 'Login As User Other';


// MENU
$list_permission['page_admin']['children']['page_menu'] = ['title'=>'Appearance Menu','permission'=>['appearance_menu_client_edit'=>'Edit Menu','appearance_menu_client_delete'=>'Delete Menu']];



// PAGE ADMIN
$list_permission['page_admin']['children']['core'] = ['title'=>'Core','permission'=>[]];

$filesInFolder = File::directories(backend_resources('page'));

foreach($filesInFolder as $path)
{

    $fileName = explode('.',pathinfo($path)['filename'])[0];

    $title = ucwords(str_replace('-',' ',$fileName));

    $list_permission['page_admin']['children']['core']['permission'][$fileName.'_view'] = $title.' View';

}


$list_permission['page_admin']['children']['tool'] = ['title'=>'Tool','permission'=>[]];

$filesInFolder = File::files(backend_resources('page/tool-genaral'));

$notNeedPermission = ['post'=>1,'get'=>1,'check-notify'=>1,'check-plugin'=>1];

foreach($filesInFolder as $path)
{

    $fileName = explode('.',pathinfo($path)['filename'])[0];

    if( !isset($notNeedPermission[$fileName]) ){

      $title = ucwords(str_replace('-',' ',$fileName));

      $list_permission['page_admin']['children']['tool']['permission']['tool_'.$fileName] = $title;
    }

}
// SETTING
$list_permission['setting']['children']['core'] = ['title'=>'Core','permission'=>['view_setting'=>'View Setting']];

$setting = get_setting_object();

foreach ($setting as $key => $s) {

  $list_permission['setting']['children']['core']['permission']['change_setting_'.$key] = 'View And Edit Setting '.$s['title'];

}

// PLUGIN
$list_permission['plugin']['permission'] = ['plugin_action'=>'plugin_action'];

function add_permission_($permission, $key2, $value2 ){
  $key = array_shift($key2);

  if( !isset($permission[$key]) ) {
    $permission[$key] = [];
  }

  if( isset($value2['title_group']) && !isset($key2[0]) ){
    $permission[$key]['title'] = $value2['title_group'];
  }

  if( !isset($permission[$key]['title']) ) $permission[$key]['title'] = '(No Name)';
  
  if( count($key2) > 0 ){

    if( !isset($permission[$key]['children']) ){
      $permission[$key]['children'] = [];
    }

    $permission[$key]['children'] = add_permission_($permission[$key]['children'],$key2,$value2);
  }elseif( isset($value2['key']) && isset($value2['title']) ){

    if( !isset($permission[$key]['permission']) ) $permission[$key]['permission'] = [];

    $permission[$key]['permission'][$value2['key']] = $value2['title'];

  }    


  return $permission;

}


$plugins = plugins();


foreach ($plugins as $plugin) {

  if( file_exists($file = cms_path('resource','views/plugins/'.$plugin->key_word.'/inc/permission.php')) ){

    $permission_plugin = include $file;

    if( is_array($permission_plugin) ){
      
      foreach ($permission_plugin as $key2 => $value2) {
        $key2 = explode('.', $value2['group']);

        $list_permission = add_permission_($list_permission, $key2, $value2);

      }

    }

  }
}

$theme_name = theme_name();

if( file_exists( $file = cms_path('resource','views/themes/'.$theme_name.'/inc/permission.php')) ){
  
    $permission_theme = include $file;

    if( is_array($permission_theme) ){
      foreach ($permission_theme as $key2 => $value2) {
        
        $key2 = explode('.', $value2['group']);
        $list_permission = add_permission_($list_permission, $key2, $value2);

      }
    }
}

function show_permssion_left($data, $key_parent){
  $str = '';

  foreach ($data as $key => $value) {
    $str .= '<li class="nav-child"><a href="#" data-key="'.$key_parent.'-'.$key.'-p" title="'.$key.'"><span class="title"> - '.$value['title'].'</span></a>';

    if( isset($value['children']) && count($value['children']) > 0 ){
      $str .= '<ul>'.show_permssion_left($value['children'],$key_parent.'-'.$key.'-p').'</ul>';
    }
    $str .= '</li>';
  }

  return $str;
}


add_action('vn4_head',function(){

?>
  <style>
        .meta-box-user-permission{
          border-top: 1px solid #dedede;
        }
        .meta-box-user-permission .col-left, .controls-header .header-col-left{
            width: 250px;
            display: inline-block;
            float: left;
            padding-right: 10px;
          border-right: 1px solid #dedede;
        }
        .meta-box-user-permission .col-right, .controls-header .header-col-right{
          margin-left: 250px;
          overflow: auto;
          padding-top: 5px;
        }
        .controls-header .header-col-right{
           border-left: 1px solid #dedede;
            margin-left: 249px;
        }
        .controls-header .header-col-left{
          width: 249px;
          float: left;
          border-right: none;
        }
        #permission-meta-box label{
          font-weight: normal;
        }
        .meta-box-user-permission .col-left li{
          margin: 5px 0;
        }
        .meta-box-user-permission .col-left li a{
          display: block;
          padding: 2px 5px;
          word-spacing: 0.5px;
        }
        .meta-box-user-permission .col-left li a.active{
          background: #dedede;
        }
    
        .controls-header .header-col-right, .controls-header .header-col-left{
           padding: 10px;
        }
        .controls-header .header-col-right{
          padding-left: 5px;
        }
        .input-quick-filter{
          width: 150px;
          height: 26px;
          display: inline-block;
        }
        .permission-p{
          display: inline-block;
          float: left;
        }

        .meta-box-user-permission .col-right.number-column-1 .permission-p{
          width: 100%;
        }
        .meta-box-user-permission .col-right.number-column-2 .permission-p{
          width: 50%;
        }
        .meta-box-user-permission .col-right.number-column-3 .permission-p{
          width: 33%;
        }
        .meta-box-user-permission .col-right .permission-p{
          padding-left: 5px;
        }
        .add-group-permission{
          border-bottom: 1px solid #dedede;
        }
        .add-group-permission label, .add-group-permission .vn4-btn{
          margin-right: 5px;
          float: left;
        }
        .add-group-permission label input{
          height: 26px;
        }
        .add-group-permission .vn4-btn{
          margin-top: 18px;
          height: 26px;
        }
        .not_validate{
          border: 1px solid red !important;
        }
        .nav-child{
          padding-left: 15px;
        }

      </style>
<?php 
 },'permission_css',true);
$list_role = $list_role??[];
add_action('vn4_footer',function() use ($list_role) {
  ?>
   <script>

    $(window).load(function(){
      

      var col_left = $('.meta-box-user-permission').clone();

      col_left.css({position:'absolute','top':'-10000px','right':'-10000px;'});
      $('body').append(col_left);
      $('.meta-box-user-permission .col-right').css({'max-height':$('.col-left').height()?$('.col-left').height():'985px'});
      col_left.remove();


      $(document).on('change','.check-all-permission',function(event) {
        $('.meta-box-user-permission .col-right input[type="checkbox"]:visible').prop('checked',$(this).prop('checked'));
      });

      $(document).on('click','.granted-only',function(event) {
        
        if( $(this).prop('checked') ){
          $('.meta-box-user-permission .col-right input[type="checkbox"]:visible:not(:checked)').closest('p').hide();
        }else{
         $('.meta-box-user-permission .col-left li a.active').trigger('click');
        }

      });

      $(document).on('change','.columns-permision',function(event) {

        $('.meta-box-user-permission .col-right').removeClass('number-column-1 number-column-2 number-column-3').addClass($(this).val());

      });

      function slug_text(title)
      {
          var title, slug;
       
          slug = title.toLowerCase();
          slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
          slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
          slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
          slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
          slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
          slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
          slug = slug.replace(/đ/gi, 'd');
          slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
          slug = slug.replace(/ /gi, "-");
          slug = slug.replace(/\-\-\-\-\-/gi, '-');
          slug = slug.replace(/\-\-\-\-/gi, '-');
          slug = slug.replace(/\-\-\-/gi, '-');
          slug = slug.replace(/\-\-/gi, '-');
          slug = '@' + slug + '@';
          slug = slug.replace(/\@\-|\-\@|\@/gi, '');
          return slug;
      }

      function ure_filter_capabilities(cap_id) {

          var div_list = jQuery('.permission-p');

          for (i = 0; i < div_list.length; i++) {

              if (cap_id !== '' && div_list[i].id.substr(11).indexOf(cap_id) !== -1) {

                  jQuery('#'+ div_list[i].id).addClass('ure_tag');

                  div_list[i].style.color = '#27CF27';

              } else {
                  div_list[i].style.color = '#000000';
                  jQuery('#'+ div_list[i].id).removeClass('ure_tag');

              }
          }

      }



      $('.meta-box-user-permission .col-left').on('click', 'li a', function(event) {
          event.preventDefault();
          $('.meta-box-user-permission .col-left a.active').removeClass('active');
          $(this).addClass('active');
          $('.col-right .permission-p').hide();
          $('.col-right .permission-p.'+$(this).data('key')).show();
      });


      $('.nav-child>a').each(function(index, el) {
           $(el).find('.title').html($(el).find('.title').text()+' (<b class="p-checked">'+$('.col-right .'+$(el).data('key')+' input:checked').length+'</b>/<b class="p-all-group">'+$('.col-right .'+$(el).data('key')).length+'</b>)');
      });

        var list_role_permission = <?php echo json_encode($list_role); ?>;
        list_role_permission['none'] =  {list_permission:'[]',title:'none'};

        $(document).on('change','.change-role-name',function(event) {

          try {
            var role = JSON.parse(list_role_permission[$(this).val()]['list_permission']);
          } catch (e) {
            var role = [];
          }

          $('.meta-box-user-permission .col-right input[type="checkbox"]').each(function(index, el) {
            if( role.indexOf($(el).val())  != -1  ){
              $(el).prop('checked',true);
            }else{
              $(el).prop('checked',false);
            }
          });
          

        });
      });
    </script>
  <?php
},'template_create_edit_user_js',true);
 ?>

<input type="text" value="{!!$role_selected!!}" hidden name="role_name" >

<div class="controls-header">
  <div class="header-col-left"><strong>@__('Group')</strong> (@__('Granted/Total'))</div>
  <div class="header-col-right">
      <label><input type="checkbox" class="check-all-permission"> @__('All')</label>&nbsp;&nbsp;&nbsp;
      <label>@__('Quick filter'): <input class="form-control input-quick-filter" onkeyup="ure_filter_capabilities(slug_text(this.value));" type="text"></label>&nbsp;&nbsp;

      <label>@__('Granted Only') <input type="checkbox" class="granted-only"></label>&nbsp;&nbsp;

      <label>@__('Columns'):  <select style="width: 50px;display: inline;height:26px;padding:0px;"  class="form-control columns-permision"><option value="number-column-1">1</option><option value="number-column-2">2</option><option value="number-column-3" selected>3</option></select></label>
  </div>
  <div class="clearfix"></div>
</div>
<div class="meta-box-user-permission">
  <ul class="col-left">
    <li class="nav-child">
      <a class="all-permission active" data-key="all-p" href=""><span class="title">@__('All')</span></a>
      <ul>
        
        {!!show_permssion_left($list_permission, 'all-p')!!}

      </ul>

    </li>
  </ul>

<div class="col-right number-column-3">
  

  <?php 

    function show_permssion_right($data,$me_permission, $key_parent){

      $str = '';

      foreach ($data as $key => $value) {

        if( isset($value['children']) ){
          $str .= show_permssion_right($value['children'],$me_permission,$key_parent.' '.$key_parent.'-'.$key.'-p');
        }

        if( isset($value['permission']) ){
          foreach ($value['permission'] as $key2 => $title) {
            $str .= '<p class="permission-p '.$key_parent.' '.$key_parent.'-'.$key.'-p" title="'.$key2.'"><label><input type="checkbox" '.(isset( $me_permission[$key2] )?'checked="checked"':'').' name="permission[]" value="'.$key2.'" >'.$title.' </label> </p>';
          }
        }
      }

      return $str;
    }

    echo show_permssion_right($list_permission,$me_permission,'all-p');
   ?>
 
 </div><div class="clearfix"></div>

</div>
