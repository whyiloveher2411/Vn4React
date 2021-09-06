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

	$param['list_option'] = $list_option;


?>
{!!get_field('select',$param, $param['post'])!!}