<?php 
	$icon_notify = [
		'success'=>['icon'=>'fa-check-circle','background'=>'#29B87E'] ,
		'error'=>['icon'=>'fa-times-circle','background'=>'#CA2121'],
		'warning'=>['icon'=>'fa-exclamation-circle','background'=>'#CE812E'],
		'info'=>['icon'=>'fa-info-circle','background'=>'#2E79B4'],
		'fail'=>['icon'=>'fa-times-circle','background'=>'#CA2121']
	];
 ?>

<div class="session-message fadeIn" @if( isset($session['id']) && $session['id'] ) data-id="{!!$session['id']!!}" @endif >
    <div class="warpper" style="background-color:{!!@$icon_notify[$session['status']]['background']!!}">
      	<div class="session-message-icon-wrapper"><i class="fa {!!@$icon_notify[$session['status']]['icon']!!}"></i></div>
     	<div class="session-message-body"><div class="session-message-title">{!!$session['title']!!}<div></div></div><div class="lobibox-notify-msg">{!!$session['content']!!}</div></div>
      	<i class="fa fa-times session-message-icon-close" aria-hidden="true"></i>
      	<div class="progress-bar"></div>
    </div>
  </div>