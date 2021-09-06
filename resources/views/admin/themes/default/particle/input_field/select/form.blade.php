<?php 

    $data = isset($data)?$data:'';

    if( !isset($default_value) ) $default_value = '';
    
    if( !isset($list_option) && isset($choices) ){
      $choices = explode("\n", $choices );

      $list_option = [];

      foreach($choices as $option){
        $option = explode(':', $option);
        if( isset($option[1]) ){
          $list_option[trim($option[0])] = ['title'=>trim($option[1])];
        }else{
          $list_option[trim($option[0])] = ['title'=>trim($option[0])];
        }
      }

    }
    $name = isset($name)?$name:$key;

    $value = $value !== null ?$value:$default_value;

    if( !is_array($value) ){
      $value = json_decode($value,true)??[$value];
    }

    $multiple = isset($multiple)?$multiple:false;
 ?>


<input type="hidden" name="{!!$name!!}" value="">
@if( isset($select_group) )
  
<select {!!$data!!} class="form-control select2 {!!$class??''!!}" @if(isset($required) && $required) required="required" @endif @if( isset($is_live_edit) ) name="{!!$name!!}" @else name="{!!$multiple?$name.'[]':$name!!}" @endif id="{!!$key!!}" @if( $multiple ) multiple @endif>
  @foreach($list_option as $k => $listOption2)
    <optgroup label="{!!$k!!}">
    @foreach($listOption2 as $k => $option)
     <option @if(array_search($k.'', $value) !== false) selected @endif value="{!!$k!!}">{!!$option['title']??$option!!}</option>
    @endforeach
    </optgroup>
  @endforeach
</select>
@else

<select {!!$data!!} class="form-control select2 {!!$class??''!!}" @if(isset($required) && $required) required="required" @endif @if( isset($is_live_edit) ) name="{!!$name!!}" @else name="{!!$multiple?$name.'[]':$name!!}" @endif id="{!!$key!!}" @if( $multiple ) multiple @endif>
@foreach($list_option as $k => $option)
   <option @if(array_search($k.'', $value) !== false) selected @endif value="{!!$k!!}">{!!$option['title']??$option!!}</option>
@endforeach
</select>

@endif


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

      $(window).load(function(){
          $(".select2").select2({
            placeholder: "Nhấp để chọn",
            allowClear: true,
          });

          update_after_add.push(function(){
             $(".select2").select2({
              placeholder: "Nhấp để chọn",
              allowClear: true,
            });
          });
        })
    </script>
  <?php
},'select2', true);

