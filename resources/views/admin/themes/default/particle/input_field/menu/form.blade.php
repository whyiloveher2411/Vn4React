<?php 
    if( !isset($default_value) ) $default_value = '';
    
    $obj = new Vn4Model(vn4_tbpf().'menu');

    $theme = theme_name();

    $list_option = $obj->where('type','menu_item')->where('status',1)->orderBy('title','asc')->pluck('title',Vn4Model::$id);
    
    $name = isset($name)?$name:$key;

    $value = $value !== null ?$value:$default_value;

    if( is_string($value) ){
      $value2 = json_decode($value,true);
    }else{
      $value2 = [];
    }

    if( is_array($value2) ){
      $value = $value2;
    }else{
      $value = [$value];
    }

    $multiple = isset($multiple)?$multiple:false;
 ?>
<div class="input-group">
    <select class="form-control select2" @if(isset($required) && $required) required="required" @endif @if( isset($is_live_edit) ) name="{!!$name!!}" @else name="{!!$multiple?$name.'[]':$name!!}" @endif id="{!!$key!!}" @if( $multiple ) multiple @endif>
  @foreach($list_option as $k => $option)
     <option @if(array_search($k.'', $value) !== false) selected @endif value="{!!$k!!}">{!!$option!!}</option>
  @endforeach
  </select>
  <a href="javascript:void(0)" onclick="window.open('{!!route('admin.page','appearance-menu')!!}?id='+$(this).closest('.input-group').find('select').val(), '_blank')" class="input-group-addon input-menu-edit-menu">Edit menu</a>
</div>



<?php

add_action('vn4_head',function(){
   ?>
      <link href="{!!asset('')!!}/vendors/select2/dist/css/select2.min.css" rel="stylesheet">
   <?php
},'select2 css', true);

add_action('vn4_footer',function() use ($key){
  ?>
  	<script src="{!!asset('')!!}/vendors/select2/dist/js/select2.full.min.js"></script>
    <script>
        $(".select2").select2({
          placeholder: "Nhấp để chọn",
          allowClear: true
        });
    </script>
  <?php
},'select2', true);


