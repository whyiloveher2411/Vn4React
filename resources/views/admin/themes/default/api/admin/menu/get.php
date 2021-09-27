<?php
$obj = new Vn4Model(vn4_tbpf().'menu');

$theme = theme_name();

$list_option = $obj->where('type','menu_item')->where('status',1)->orderBy('title','asc')->get();

return ['rows'=>$list_option];