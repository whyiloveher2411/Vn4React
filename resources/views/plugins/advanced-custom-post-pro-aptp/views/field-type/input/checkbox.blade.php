<?php 
	$choices = explode("\n", $param['choices']);

	$list_option = [];

	$param['default_value'] = explode("\n", $param['default_value']);

	foreach($choices as $option){
	  $option = explode(':', $option);
	  if( isset($option[1]) ){
	  	$list_option[trim($option[0])] = trim($option[1]);
	  }else{
	  	$list_option[trim($option[0])] = trim($option[0]);
	  }
	}

	// if( !$post ){
	// 	$value = json_encode(explode("\n", $default_value));
	// }

	// if( is_array($value) ) $value = json_encode($value);

	$param['message_null'] = 'You must check at least one checkbox '.$param['title'];
	$param['list_option'] = $list_option;
?>
{!!get_field('checkbox',$param, $param['post'])!!}