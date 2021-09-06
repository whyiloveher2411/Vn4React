@extends(backend_theme('master'))

@section('content')

<?php 
 title_head( 'User role editor' );
 ?>
<div class="" >
    <form class="form-setting form-horizontal form-label-left input_mask" id="form_create" method="POST">
      <input type="text" name="_token" value="{!!csrf_token()!!}" hidden>
      
      <?php 
          $obj = Vn4Model::firstOrAddnew(vn4_tbpf().'setting',['key_word'=>'list_role','type'=>'option_permission']);

          $list_role = $obj->meta;

          if( (!$list_role && !json_decode($list_role,true) ) || Request::has('add_new_role') ){

            vn4_panel(__('create role'),function(){

              ?>
              <label style="" for="title">@__('Role name')
                    </label> <input name="create_role_name" required="" style="float: none;max-width:200px;display:inline;" value="" type="text" id="title" class="form-control col-md-7 col-xs-12">
              
              <?php

            },false,null);

          }else{

            $list_role = json_decode($list_role, true);

            $role_selected = Request::get('post_role',false );

            if( !$role_selected ){
              $role_selected = key($list_role);
            }
            vn4_panel(__('Select Role and change its capabilities'),function() use ($role_selected , $list_role) {

              echo vn4_view(backend_theme('page.user-role-editor.template-user-role-editor'),['role_selected'=>$role_selected,'list_role'=>$list_role]);

            },false,null, ['callback_title'=>function() use ($role_selected , $list_role, $__env) {
              ?>
                
                <select style="width: auto;display: inline;height:26px;padding:0px;"  class="form-control change-role-name" name="role_name">
                  
                  @foreach($list_role as $key => $role )  
                  <?php 
                    $count = json_decode($role['list_permission'],true);
                    if( is_array($count) ) $count = count($count); else $count = 0;
                   ?>

                  <option @if( $role_selected === $key ) selected @endif value="{!!$key!!}">{!!$role['title'],' (',$count!!} Permission )</option>
                  @endforeach

                </select>
                <input type="submit" class="vn4-btn" id="delete-role" style="height: 26px;" value="@__('Delete Role')" name="delete-role-submit">
                <a class="vn4-btn" style="height: 26px;" href="?add_new_role=1">@__('Create New Role')</a>
                
              <?php
            }]);

          }

      
          


       ?>
      @if( (!$list_role && !json_decode($list_role,true) ) || Request::has('add_new_role') )
      <p><button name="create_role" value="true" class="vn4-btn vn4-btn-blue">@__('Create Role')</button></p>
      @else
      <p><button class="vn4-btn vn4-btn-blue vn4-btn-save">@__('Save changes')</button></p>
      @endif

    </form>

</div>
@stop

@section('js')
  
  <script>

    $(document).on('click','#delete-role',function(event) {
      var r = confirm("Are you ok??");
      if (r != true) {
        event.preventDefault();
      }
    });

    var list_role_permission = <?php echo $list_role?json_encode($list_role):'{}'; ?>;
    list_role_permission['none'] =  {list_permission:'[]','title':'none'};

    function IsJsonString(str) {
          try {
              JSON.parse(str);
          } catch (e) {
              return false;
          }
          return true;
      }

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
    
@stop
