<?php
if( is_admin() ){
	include __DIR__.'/inc/backend.php';
}else{
	include __DIR__.'/inc/frontend.php';
}
