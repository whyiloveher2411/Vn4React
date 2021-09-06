<?php 
$name = isset($name)?$name:$key;
 ?>

 <div class="checkbox d-inline ckb " id="{!!$key!!}">
 	<input type="hidden" value="0" class="false_value" checked="checked" name="{!!$name!!}">
  <label><input type="checkbox" value="1" @if($value) checked="checked" @endif name="{!!$name!!}"></label>
</div>
