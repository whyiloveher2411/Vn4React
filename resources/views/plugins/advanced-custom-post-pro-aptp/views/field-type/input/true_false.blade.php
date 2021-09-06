<?php 
	$param['list_option'] = ['1'=>$param['message']];
	$param['default_value'] = [$param['default_value']];
	unset($param['required']);
?>
{!!get_field('checkbox',$param, $param['post'])!!}