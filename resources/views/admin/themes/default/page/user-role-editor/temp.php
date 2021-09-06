<?php

function user_permission_system(){

  $admin_object = get_admin_object();

  foreach ($admin_object as $key => $object) {

    register_group_permission(['group_permission_post'],'group_post_type_'.$key, $object['title']);
    //list, create, edit, trash, delete, restore, detail
    register_permission('.group_permission_post'.'.group_post_type_'.$key, $key.'_list', 'List '.$object['title'] );
    register_permission('.group_permission_post'.'.group_post_type_'.$key, $key.'_create', 'Create '.$object['title'] );
    register_permission('.group_permission_post'.'.group_post_type_'.$key, $key.'_edit', 'Edit '.$object['title'] );
    register_permission('.group_permission_post'.'.group_post_type_'.$key, $key.'_publish', 'Publish '.$object['title'] );
    register_permission('.group_permission_post'.'.group_post_type_'.$key, $key.'_trash', 'Trash '.$object['title'] );
    register_permission('.group_permission_post'.'.group_post_type_'.$key, $key.'_delete', 'Delete '.$object['title'] );
    register_permission('.group_permission_post'.'.group_post_type_'.$key, $key.'_restore', 'Restore '.$object['title'] );
    register_permission('.group_permission_post'.'.group_post_type_'.$key, $key.'_detail', 'Detail '.$object['title'] );

  }

  register_group_permission(['group_permission_page'],'core', 'Core');

  $filesInFolder = File::directories(backend_resources('page'));

  foreach($filesInFolder as $path)
  {

      $fileName = explode('.',pathinfo($path)['filename'])[0];

      $title = ucwords(str_replace('-',' ',$fileName));

      register_permission('.group_permission_page.core',$fileName.'_view', $title.' View');
     
  }

  $setting = get_setting_object();

  register_group_permission(['group_permission_setting'],'core', 'Core');


  register_permission('.group_permission_setting.core','view_setting', 'View Setting');


  foreach ($setting as $key => $s) {

    register_permission('.group_permission_setting.core','change_setting_'.$key, $s['title']);

  }

  register_permission('.group_permission_plugin.core','plugin_action', 'plugin_action');
  
}

user_permission_system();

function show_group_permission($id, $title, $id_parent, $list_group_children){


  $show_list_group_permission = '';

  if( !empty($list_group_children) ){

    $show_list_group_permission = show_list_group_permission( $list_group_children, $id_parent.'.'.$id );

  }

  return '<li class="nav-child"><a data-id="'.$id.'" aria-controls="'.$id_parent.'.'.$id.'" href="#">- <span class="title">'.__($title).'</span></a><ul>'.$show_list_group_permission.'</ul></li>';

}

function show_list_group_permission($list_group, $id_parent){

  $str_result = '';

  foreach ($list_group as $key => $group) {

    $str_result = $str_result.show_group_permission($key, $group['title'], $id_parent, $group['list_group_children'] );

  }

  return $str_result;

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

add_action('vn4_footer',function() use ($list_role) {
  ?>
   <script>

      $('.meta-box-user-permission .col-left').on('click', 'li a:not(.all-permission)', function(event) {
          event.preventDefault();
          $('.meta-box-user-permission .col-left a.active').removeClass('active');
          $(this).addClass('active');
          $('.col-right .permission-p').hide();
          $('.col-right .permission-p'+$(this).attr('aria-controls')).show();
      });

      var col_left = $('.meta-box-user-permission').clone();

      col_left.css({position:'absolute','top':'-10000px','right':'-10000px;'});
      $('body').append(col_left);
      $('.meta-box-user-permission .col-right').css({'max-height':col_left.find('.col-left').height()});
      col_left.remove();

      $(document).on('click','.meta-box-user-permission .col-left li a.all-permission',function(event) {
        event.preventDefault();
        $('.meta-box-user-permission .col-left a.active').removeClass('active');
        $(this).addClass('active');
        $('.col-right .permission-p').show();
      });

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


      $('.all-permission').text('All ('+$('.col-right .permission-p input:checked').length+'/'+$('.col-right .permission-p').length+')');

      $('.nav-child>a').each(function(index, el) {
           $(el).find('.title').text($(el).find('.title').text()+' ('+$('.col-right '+$(el).attr('aria-controls')+' input:checked').length+'/'+$('.col-right '+$(el).attr('aria-controls')).length+')');
      });

        var list_role_permission = <?php echo json_encode($list_role); ?>;
        list_role_permission['none'] =  {list_permission:'[]','title':'none'};

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
    <li>
      <a class="all-permission active" aria-controls="" href="">@__('All')</a>
      <ul>
   <?php 

    $group_permission_system = ['group_permission_post'=>['title'=>'Post','list_group_children'=>[]],'group_permission_page'=>['title'=>'Page','list_group_children'=>[]],'group_permission_setting'=>['title'=>'Setting','list_group_children'=>[]],'group_permission_plugin'=>['title'=>'Plugin','list_group_children'=>[]]];



    $group_permission_system = apply_filter('register_group_permission',$group_permission_system);
   ?>

        
   {!!show_list_group_permission($group_permission_system, '')!!}


    </ul>

    </li>
  </ul>

<div class="col-right number-column-3">
  
  <?php 
    $list_permission = apply_filter('register_permission',[]);
   ?>

   @foreach($list_permission as $key => $value)
      
      <p id="ure_cap_div_{!!str_slug($value['title'])!!}" class="permission-p {!!preg_replace('/\./', ' ', $value['group']);!!}"><label><input type="checkbox" @if( isset( $me_permission[$key] ) ) checked="checked" @endif name="permission[]" value="{!!$key!!}">{!!$value['title']!!} </label> </p>

   @endforeach
 
 
 </div><div class="clearfix"></div>

</div>
