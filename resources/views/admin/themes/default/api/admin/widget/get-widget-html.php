<?php

$widgets = \CMS\Widget\Model\Widget::all();

$widget_type = $r->get('__widget_type');


if( isset($widgets[$widget_type]) ){

    // $widgetHtml = vn4_view('themes.'.theme_name().'.'.$widgets[$widget_type]['template_admin'], $r->all());
    $widgetHtml = '<img src="'.$widgets[$widget_type]['thumbnail'].'" />';
    return ['html'=>$widgetHtml];
}

return ['message'=>apiMessage('Widget Not Found.','error')];